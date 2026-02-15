<?php

namespace App\Livewire\Sprovider;

use App\Models\ServiceAvailabilityException;
use App\Models\ServiceProvider;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class SproviderServiceRequestsComponent extends Component
{
    use WithPagination;

    public $showOverlapConfirmModal = false;
    public $pendingAcceptRequestId = null;
    public $pendingOverlapRequestIds = [];
    public $pendingOverlapCount = 0;

    public function acceptRequest($request_id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            return;
        }

        $request = ServiceRequest::where('id', $request_id)
            ->where('service_provider_id', $sprovider->id)
            ->first();

        if (!$request || $request->status !== 'pending') {
            return;
        }

        $acceptedOverlap = ServiceRequest::where('service_provider_id', $sprovider->id)
            ->where('id', '!=', $request->id)
            ->where('status', 'accepted')
            ->where(function ($q) use ($request) {
                $q->where('start_at', '<', $request->end_at)
                    ->where('end_at', '>', $request->start_at);
            })
            ->exists();

        if ($acceptedOverlap) {
            session()->flash('message', 'Cannot accept. Time slot already booked.');
            return;
        }

        $overlappingPending = ServiceRequest::where('service_provider_id', $sprovider->id)
            ->where('id', '!=', $request->id)
            ->where('status', 'pending')
            ->where(function ($q) use ($request) {
                $q->where('start_at', '<', $request->end_at)
                    ->where('end_at', '>', $request->start_at);
            })
            ->orderBy('start_at')
            ->get();

        if ($overlappingPending->isNotEmpty()) {
            $this->pendingAcceptRequestId = $request->id;
            $this->pendingOverlapRequestIds = $overlappingPending->pluck('id')->all();
            $this->pendingOverlapCount = $overlappingPending->count();
            $this->showOverlapConfirmModal = true;
            return;
        }

        $this->acceptRequestAndBlockTime($request);
        session()->flash('message', 'Request accepted.');
    }

    public function confirmAcceptWithOverlapRejection()
    {
        $requestId = $this->pendingAcceptRequestId;
        $overlapIds = $this->pendingOverlapRequestIds;
        $this->resetOverlapConfirmState();

        if (!$requestId) {
            return;
        }

        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            return;
        }

        $request = ServiceRequest::where('id', $requestId)
            ->where('service_provider_id', $sprovider->id)
            ->first();

        if (!$request || $request->status !== 'pending') {
            session()->flash('message', 'Request is no longer pending.');
            return;
        }

        $acceptedOverlap = ServiceRequest::where('service_provider_id', $sprovider->id)
            ->where('id', '!=', $request->id)
            ->where('status', 'accepted')
            ->where(function ($q) use ($request) {
                $q->where('start_at', '<', $request->end_at)
                    ->where('end_at', '>', $request->start_at);
            })
            ->exists();

        if ($acceptedOverlap) {
            session()->flash('message', 'Cannot accept. Time slot already booked.');
            return;
        }

        if (!empty($overlapIds)) {
            $overlaps = ServiceRequest::where('service_provider_id', $sprovider->id)
                ->whereIn('id', $overlapIds)
                ->where('status', 'pending')
                ->where(function ($q) use ($request) {
                    $q->where('start_at', '<', $request->end_at)
                        ->where('end_at', '>', $request->start_at);
                })
                ->get();

            foreach ($overlaps as $overlap) {
                $overlap->status = 'rejected';
                $overlap->save();
                $this->notifyCustomer($overlap, 'rejected');
            }
        }

        $this->acceptRequestAndBlockTime($request);
        session()->flash('message', 'Request accepted. Overlapping pending requests were rejected.');
    }

    public function cancelOverlapConfirmation()
    {
        $this->resetOverlapConfirmState();
    }

    protected function acceptRequestAndBlockTime(ServiceRequest $request)
    {
        $request->status = 'accepted';
        $request->save();

        $this->createBlockingExceptionForRequest($request);
        $this->notifyCustomer($request, 'accepted');
    }

    protected function createBlockingExceptionForRequest(ServiceRequest $request)
    {
        if (!$request->start_at || !$request->end_at) {
            return;
        }

        ServiceAvailabilityException::firstOrCreate([
            'service_provider_id' => $request->service_provider_id,
            'date' => $request->start_at->toDateString(),
            'is_available' => false,
            'start_time' => $request->start_at->format('H:i:s'),
            'end_time' => $request->end_at->format('H:i:s'),
        ]);
    }

    protected function resetOverlapConfirmState()
    {
        $this->showOverlapConfirmModal = false;
        $this->pendingAcceptRequestId = null;
        $this->pendingOverlapRequestIds = [];
        $this->pendingOverlapCount = 0;
    }

    public function rejectRequest($request_id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $request = ServiceRequest::where('id', $request_id)
            ->where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->first();

        if (!$request) {
            return;
        }

        $request->status = 'rejected';
        $request->save();
        $this->notifyCustomer($request, 'rejected');
        session()->flash('message', 'Request rejected.');
    }

    public function completeRequest($request_id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $request = ServiceRequest::where('id', $request_id)
            ->where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->first();

        if (!$request || $request->status !== 'accepted') {
            return;
        }

        $request->status = 'completed';
        $request->save();
        $this->createBlockingExceptionForRequest($request);

        $sprovider->completed_jobs_count = (int) $sprovider->completed_jobs_count + 1;
        $awardedCredit = false;
        if ($sprovider->completed_jobs_count % 3 === 0) {
            $sprovider->promotion_credits = (int) $sprovider->promotion_credits + 1;
            $awardedCredit = true;
        }
        $sprovider->save();
        $this->dispatch('promotion-credits-updated', credits: (int) $sprovider->promotion_credits);

        $this->notifyCustomer($request, 'completed');
        $message = 'Request marked as completed.';
        if ($awardedCredit) {
            $message .= ' You earned 1 free promotion credit.';
        }
        session()->flash('message', $message);
    }

    protected function notifyCustomer(ServiceRequest $request, string $status)
    {
        $user = $request->customer;
        if (!$user || !$user->email) {
            return;
        }

        $subject = 'Service request ' . $status;
        $body = 'Your request #' . $request->id . ' has been ' . $status . '.';
        try {
            Mail::raw($body, function ($message) use ($user, $subject) {
                $message->to($user->email)
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            // Mail is optional; ignore errors if not configured.
        }
    }

    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $requests = ServiceRequest::where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.sprovider.sprovider-service-requests-component', [
            'requests' => $requests,
            'sprovider' => $sprovider
        ])->layout('layouts.base');
    }
}
