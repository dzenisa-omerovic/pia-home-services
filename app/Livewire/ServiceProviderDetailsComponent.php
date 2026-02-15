<?php

namespace App\Livewire;

use App\Models\ServiceProvider;
use Livewire\Component;

class ServiceProviderDetailsComponent extends Component
{
    public $provider_id;

    public function mount($provider_id)
    {
        if (!auth()->check()) {
            session(['url.intended' => url()->current()]);
            return redirect()->route('login', ['status' => 'loginRequiredProvider']);
        }

        $this->provider_id = $provider_id;
    }

    public function render()
    {
        $provider = ServiceProvider::with(['user', 'category', 'services'])
            ->findOrFail($this->provider_id);
        if (($provider->approval_status ?? 'pending') !== 'approved') {
            abort(404);
        }

        $reviews = \App\Models\ServiceReview::where('service_provider_id', $provider->id)->get();
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 2) : 0;
        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        return view('livewire.service-provider-details-component', [
            'provider' => $provider,
            'avgRating' => $avgRating,
            'ratingCounts' => $ratingCounts
        ])
            ->layout('layouts.base');
    }
}
