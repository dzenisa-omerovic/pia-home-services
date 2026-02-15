<?php

namespace App\Livewire\Customer;

use App\Models\ServiceRequest;
use App\Models\ServiceReview;
use App\Models\CustomerReview;
use App\Models\ServiceComplaint;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerServiceRequestsComponent extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        if (!$user || $user->utype !== 'CST') {
            abort(403);
        }

        $requests = ServiceRequest::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $requestIds = $requests->pluck('id')->all();
        $providerReviews = ServiceReview::whereIn('service_request_id', $requestIds)->get()->keyBy('service_request_id');
        $customerReviews = CustomerReview::whereIn('service_request_id', $requestIds)->get()->keyBy('service_request_id');
        $complaints = ServiceComplaint::whereIn('service_request_id', $requestIds)->get()->keyBy('service_request_id');

        return view('livewire.customer.customer-service-requests-component', [
            'requests' => $requests,
            'providerReviews' => $providerReviews,
            'customerReviews' => $customerReviews,
            'complaints' => $complaints
        ])->layout('layouts.base');
    }
}
