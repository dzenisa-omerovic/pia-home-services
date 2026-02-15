<?php

namespace App\Livewire\Customer;

use App\Models\ServiceRequest;
use App\Models\ServiceReview;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerReviewProviderComponent extends Component
{
    public $request_id;
    public $rating;
    public $comment;
    public $request;
    public $existing;

    public function mount($request_id)
    {
        $this->request_id = $request_id;
        $this->request = ServiceRequest::find($request_id);

        if (!$this->request || $this->request->customer_id !== Auth::id()) {
            abort(403);
        }
        if ($this->request->status !== 'completed') {
            abort(403);
        }

        $this->existing = ServiceReview::where('service_request_id', $this->request_id)
            ->where('customer_id', Auth::id())
            ->first();

        if ($this->existing) {
            $this->dispatch('toast', type: 'info', message: 'Your current rating: ' . $this->existing->rating);
        }
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000'
        ]);

        ServiceReview::updateOrCreate(
            ['service_request_id' => $this->request_id, 'customer_id' => Auth::id()],
            [
                'service_id' => $this->request->service_id,
                'service_provider_id' => $this->request->service_provider_id,
                'rating' => $this->rating,
                'comment' => $this->comment
            ]
        );

        $this->dispatch('toast', type: 'success', message: 'Customer rated successfully. Current rating: ' . $this->rating);
        $this->dispatch('app-redirect', url: route('customer.requests'));
    }

    public function render()
    {
        return view('livewire.customer.customer-review-provider-component', [
            'existing' => $this->existing
        ])->layout('layouts.base');
    }
}
