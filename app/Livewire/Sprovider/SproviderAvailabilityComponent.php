<?php

namespace App\Livewire\Sprovider;

use App\Models\ServiceAvailability;
use App\Models\ServiceAvailabilityException;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SproviderAvailabilityComponent extends Component
{
    public $week = [];
    public $exception_date;
    public $exception_is_available = false;
    public $exception_start_time = '09:00';
    public $exception_end_time = '17:00';

    public function mount()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            abort(403);
        }

        $days = [0,1,2,3,4,5,6];
        foreach ($days as $day) {
            $availability = ServiceAvailability::firstOrCreate(
                ['service_provider_id' => $sprovider->id, 'weekday' => $day],
                ['is_active' => false, 'start_time' => '09:00', 'end_time' => '17:00']
            );
            $this->week[$day] = [
                'is_active' => (bool)$availability->is_active,
                'start_time' => $availability->start_time,
                'end_time' => $availability->end_time
            ];
        }
    }

    public function saveWeekly()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            abort(403);
        }

        foreach ($this->week as $day => $data) {
            ServiceAvailability::updateOrCreate(
                ['service_provider_id' => $sprovider->id, 'weekday' => (int)$day],
                [
                    'is_active' => (bool)($data['is_active'] ?? false),
                    'start_time' => $data['start_time'] ?? null,
                    'end_time' => $data['end_time'] ?? null
                ]
            );
        }

        session()->flash('message', 'Weekly availability updated.');
    }

    public function addException()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            abort(403);
        }

        $this->validate([
            'exception_date' => 'required|date',
            'exception_is_available' => 'boolean',
            'exception_start_time' => 'nullable',
            'exception_end_time' => 'nullable'
        ]);

        ServiceAvailabilityException::create([
            'service_provider_id' => $sprovider->id,
            'date' => $this->exception_date,
            'is_available' => (bool)$this->exception_is_available,
            'start_time' => $this->exception_start_time,
            'end_time' => $this->exception_end_time
        ]);

        $this->exception_date = null;
        $this->exception_is_available = false;
        $this->exception_start_time = '09:00';
        $this->exception_end_time = '17:00';

        session()->flash('message', 'Exception saved.');
    }

    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $exceptions = ServiceAvailabilityException::where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.sprovider.sprovider-availability-component', [
            'exceptions' => $exceptions
        ])->layout('layouts.base');
    }
}
