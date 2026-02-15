<?php

namespace App\Livewire\Sprovider;

use App\Models\CustomerReview;
use App\Models\ServiceProvider;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SproviderReviewCustomerComponent extends Component
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
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();

        if (!$this->request || !$sprovider || $this->request->service_provider_id !== $sprovider->id) {
            abort(403);
        }
        if ($this->request->status !== 'completed') {
            abort(403);
        }

        $this->existing = CustomerReview::where('service_request_id', $this->request_id)
            ->where('service_provider_id', $this->request->service_provider_id)
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

        CustomerReview::updateOrCreate(
            ['service_request_id' => $this->request_id, 'service_provider_id' => $this->request->service_provider_id],
            [
                'customer_id' => $this->request->customer_id,
                'rating' => $this->rating,
                'comment' => $this->comment
            ]
        );

        $this->dispatch('toast', type: 'success', message: 'Customer rated successfully. Current rating: ' . $this->rating);
        $this->dispatch('app-redirect', url: route('sprovider.requests'));
    }

    public function render()
    {
        return view('livewire.sprovider.sprovider-review-customer-component', [
            'existing' => $this->existing
        ])->layout('layouts.base');
    }
}
