<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\ServiceProvider;
use App\Models\ServiceAvailability;
use App\Models\ServiceAvailabilityException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Component;

class ServiceDetailsComponent extends Component
{
    public $service_slug;
    public $note;
    public $date;
    public $start_time;
    public $end_time;
    public $available_start_times = [];
    public $available_end_times = [];
    public $availability_ranges = [];

    protected $slotMinutes = 30;
    public function mount($service_slug)
    {
        if (!auth()->check()) {
            session(['url.intended' => url()->current()]);
            return redirect()->route('login', ['status' => 'loginRequiredService']);
        }
        $this->service_slug = $service_slug;
    }

    public function bookService()
    {
        if (!Auth::check()) {
            return redirect()->route('login', ['status' => 'customerLoginRequired']);
        }

        $user = Auth::user();
        if ($user->utype !== 'CST') {
            session()->flash('message', 'Only customers can book services.');
            return;
        }

        $this->validate([
            'note' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $service = Service::where('slug', $this->service_slug)->first();
        if (!$service) {
            session()->flash('message', 'Service not found.');
            return;
        }

        $sprovider = ServiceProvider::find($service->service_provider_id);
        if (!$sprovider) {
            session()->flash('message', 'Service provider not found.');
            return;
        }

        $startAt = Carbon::parse($this->date . ' ' . $this->start_time);
        $endAt = Carbon::parse($this->date . ' ' . $this->end_time);
        if ($endAt->lessThanOrEqualTo($startAt)) {
            session()->flash('message', 'End time must be after start time.');
            return;
        }

        $weekday = (int)$startAt->format('w');
        $weekly = ServiceAvailability::where('service_provider_id', $sprovider->id)
            ->where('weekday', $weekday)
            ->first();

        $exceptions = ServiceAvailabilityException::where('service_provider_id', $sprovider->id)
            ->whereDate('date', $this->date)
            ->get();

        $ranges = $this->getAvailabilityRangesForDate($sprovider->id, Carbon::parse($this->date), $weekly, $exceptions);
        if (empty($ranges)) {
            session()->flash('message', 'Selected time is not available.');
            return;
        }

        $fitsAnyRange = false;
        foreach ($ranges as $range) {
            $rangeStart = Carbon::parse($this->date . ' ' . $range['start']);
            $rangeEnd = Carbon::parse($this->date . ' ' . $range['end']);
            if ($startAt->gte($rangeStart) && $endAt->lte($rangeEnd)) {
                $fitsAnyRange = true;
                break;
            }
        }
        if (!$fitsAnyRange) {
            session()->flash('message', 'Selected time is outside provider availability.');
            return;
        }

        $overlap = ServiceRequest::where('service_provider_id', $sprovider->id)
            ->whereIn('status', ['accepted', 'completed'])
            ->where(function ($q) use ($startAt, $endAt) {
                $q->where('start_at', '<', $endAt)
                    ->where('end_at', '>', $startAt);
            })
            ->exists();
        if ($overlap) {
            session()->flash('message', 'Selected time is already booked.');
            return;
        }

        ServiceRequest::create([
            'service_id' => $service->id,
            'service_provider_id' => $sprovider->id,
            'customer_id' => $user->id,
            'status' => 'pending',
            'note' => $this->note,
            'start_at' => $startAt,
            'end_at' => $endAt
        ]);

        $this->note = null;
        $this->date = null;
        $this->start_time = null;
        $this->end_time = null;
        session()->flash('message', 'Your request has been sent!');
    }

    public function updatedDate()
    {
        $this->start_time = null;
        $this->end_time = null;
        $this->available_end_times = [];
        $this->refreshAvailabilityForSelectedDate();
    }

    public function updatedStartTime()
    {
        if (empty($this->availability_ranges) && $this->date) {
            $this->refreshAvailabilityForSelectedDate();
        }
        $this->end_time = null;
        $this->available_end_times = $this->buildEndTimesForStart($this->start_time);
    }

    public function updatedStart_time($value)
    {
        $this->updatedStartTime();
    }

    public function onStartTimeChange()
    {
        $this->updatedStartTime();
    }

    protected function refreshAvailabilityForSelectedDate()
    {
        $this->available_start_times = [];
        $this->availability_ranges = [];

        if (!$this->date) {
            return;
        }

        $service = Service::where('slug', $this->service_slug)->first();
        if (!$service) {
            return;
        }

        $sprovider = ServiceProvider::find($service->service_provider_id);
        if (!$sprovider) {
            return;
        }

        $date = Carbon::parse($this->date);
        $this->availability_ranges = $this->getAvailabilityRangesForDate($sprovider->id, $date);
        $this->available_start_times = $this->buildStartTimes($this->availability_ranges, $date);
    }

    protected function getAvailabilityRangesForDate($sproviderId, Carbon $date, $weekly = null, $exceptions = null)
    {
        if ($weekly === null) {
            $weekday = (int)$date->format('w');
            $weekly = ServiceAvailability::where('service_provider_id', $sproviderId)
                ->where('weekday', $weekday)
                ->first();
        }

        if ($exceptions === null) {
            $exceptions = ServiceAvailabilityException::where('service_provider_id', $sproviderId)
                ->whereDate('date', $date->toDateString())
                ->get();
        } elseif ($exceptions instanceof ServiceAvailabilityException) {
            $exceptions = collect([$exceptions]);
        } elseif (is_array($exceptions)) {
            $exceptions = collect($exceptions);
        }

        if (!$exceptions instanceof Collection) {
            $exceptions = collect();
        }

        $ranges = [];
        if ($weekly && $weekly->is_active && $weekly->start_time && $weekly->end_time) {
            $ranges[] = [
                'start' => Carbon::parse($weekly->start_time)->format('H:i'),
                'end' => Carbon::parse($weekly->end_time)->format('H:i')
            ];
        }

        $availableRanges = [];
        $blockedRanges = [];
        foreach ($exceptions as $exception) {
            if ($exception->is_available) {
                if ($exception->start_time && $exception->end_time) {
                    $availableRanges[] = [
                        'start' => Carbon::parse($exception->start_time)->format('H:i'),
                        'end' => Carbon::parse($exception->end_time)->format('H:i')
                    ];
                }
                continue;
            }

            if (!$exception->start_time || !$exception->end_time) {
                return [];
            }

            $blockedRanges[] = [
                'start' => Carbon::parse($exception->start_time)->format('H:i'),
                'end' => Carbon::parse($exception->end_time)->format('H:i')
            ];
        }

        if (!empty($availableRanges)) {
            $ranges = $this->mergeRanges(array_merge($ranges, $availableRanges));
        } else {
            $ranges = $this->mergeRanges($ranges);
        }

        foreach ($blockedRanges as $blockedRange) {
            $ranges = $this->subtractRange($ranges, $blockedRange['start'], $blockedRange['end']);
            if (empty($ranges)) {
                break;
            }
        }

        return $this->mergeRanges($ranges);
    }

    protected function subtractRange(array $ranges, $blockStart, $blockEnd)
    {
        $blockStartMin = $this->timeToMinutes($blockStart);
        $blockEndMin = $this->timeToMinutes($blockEnd);
        if ($blockStartMin >= $blockEndMin) {
            return $ranges;
        }

        $result = [];

        foreach ($ranges as $range) {
            $rangeStartMin = $this->timeToMinutes($range['start']);
            $rangeEndMin = $this->timeToMinutes($range['end']);
            if ($rangeStartMin >= $rangeEndMin) {
                continue;
            }

            if ($blockEndMin <= $rangeStartMin || $blockStartMin >= $rangeEndMin) {
                $result[] = $range;
                continue;
            }

            if ($blockStartMin > $rangeStartMin) {
                $result[] = [
                    'start' => $range['start'],
                    'end' => $this->minutesToTime($blockStartMin)
                ];
            }

            if ($blockEndMin < $rangeEndMin) {
                $result[] = [
                    'start' => $this->minutesToTime($blockEndMin),
                    'end' => $range['end']
                ];
            }
        }

        return $this->mergeRanges($result);
    }

    protected function mergeRanges(array $ranges)
    {
        if (empty($ranges)) {
            return [];
        }

        $normalized = [];
        foreach ($ranges as $range) {
            if (!isset($range['start'], $range['end'])) {
                continue;
            }

            $startMin = $this->timeToMinutes($range['start']);
            $endMin = $this->timeToMinutes($range['end']);
            if ($startMin >= $endMin) {
                continue;
            }

            $normalized[] = ['start' => $startMin, 'end' => $endMin];
        }

        if (empty($normalized)) {
            return [];
        }

        usort($normalized, function ($a, $b) {
            return $a['start'] <=> $b['start'];
        });

        $merged = [];
        foreach ($normalized as $current) {
            if (empty($merged)) {
                $merged[] = $current;
                continue;
            }

            $lastIndex = count($merged) - 1;
            if ($current['start'] <= $merged[$lastIndex]['end']) {
                $merged[$lastIndex]['end'] = max($merged[$lastIndex]['end'], $current['end']);
                continue;
            }

            $merged[] = $current;
        }

        return array_map(function ($range) {
            return [
                'start' => $this->minutesToTime($range['start']),
                'end' => $this->minutesToTime($range['end'])
            ];
        }, $merged);
    }

    protected function timeToMinutes($time)
    {
        $parsed = Carbon::parse($time);
        return ((int)$parsed->format('H')) * 60 + ((int)$parsed->format('i'));
    }

    protected function minutesToTime($minutes)
    {
        $hours = intdiv((int)$minutes, 60);
        $mins = ((int)$minutes) % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }

    protected function buildStartTimes(array $ranges, Carbon $date)
    {
        $times = [];
        foreach ($ranges as $range) {
            $cursor = Carbon::parse($date->toDateString() . ' ' . $range['start']);
            $end = Carbon::parse($date->toDateString() . ' ' . $range['end']);
            while ($cursor->lt($end)) {
                $next = $cursor->copy()->addMinutes($this->slotMinutes);
                if ($next->lte($end)) {
                    $times[] = $cursor->format('H:i');
                }
                $cursor->addMinutes($this->slotMinutes);
            }
        }
        return array_values(array_unique($times));
    }

    protected function buildEndTimesForStart($startTime)
    {
        if (!$startTime || !$this->date) {
            return [];
        }

        $date = Carbon::parse($this->date);
        $start = Carbon::parse($this->date . ' ' . $startTime);

        foreach ($this->availability_ranges as $range) {
            $rangeStart = Carbon::parse($date->toDateString() . ' ' . $range['start']);
            $rangeEnd = Carbon::parse($date->toDateString() . ' ' . $range['end']);

            if ($start->gte($rangeStart) && $start->lt($rangeEnd)) {
                $times = [];
                $cursor = $start->copy()->addMinutes($this->slotMinutes);
                while ($cursor->lte($rangeEnd)) {
                    $times[] = $cursor->format('H:i');
                    $cursor->addMinutes($this->slotMinutes);
                }
                return $times;
            }
        }

        return [];
    }

    public function render()
    {
        if ($this->date && $this->start_time && empty($this->available_end_times)) {
            if (empty($this->availability_ranges)) {
                $this->refreshAvailabilityForSelectedDate();
            }
            $this->available_end_times = $this->buildEndTimesForStart($this->start_time);
        }

        $service = Service::where('slug', $this->service_slug)->first();
        $r_service = Service::where('service_category_id', $service->service_category_id)->where('slug', '!=', $this->service_slug)->inRandomOrder()->first();

        $calendar_days = [];
        if ($service) {
            $sprovider = ServiceProvider::find($service->service_provider_id);
            if ($sprovider) {
                $today = Carbon::today();
                $end = $today->copy()->addDays(29);

                $weekly = ServiceAvailability::where('service_provider_id', $sprovider->id)->get()->keyBy('weekday');
                $exceptions = ServiceAvailabilityException::where('service_provider_id', $sprovider->id)
                    ->whereBetween('date', [$today->toDateString(), $end->toDateString()])
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->date->toDateString();
                    });

                for ($i = 0; $i < 30; $i++) {
                    $d = $today->copy()->addDays($i);
                    $weekday = (int)$d->format('w');
                    $w = $weekly->get($weekday);
                    $e = $exceptions->get($d->toDateString(), collect());
                    $ranges = $this->getAvailabilityRangesForDate($sprovider->id, $d, $w, $e);
                    $calendar_days[] = [
                        'date' => $d->toDateString(),
                        'label' => $d->format('d.m'),
                        'weekday' => $d->format('D'),
                        'available' => count($ranges) > 0
                    ];
                }
            }
        }

        return view('livewire.service-details-component', [
            'service' => $service,
            'r_service' => $r_service,
            'calendar_days' => $calendar_days
        ])->layout('layouts.base');
    }
}
