<?php

namespace App\Livewire\Customer;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerProfileComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user || $user->utype !== 'CST') {
            abort(403);
        }

        $popularServices = Service::query()
            ->select('services.*')
            ->withCount([
                'serviceRequests as completed_requests_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'serviceReviews as reviews_count',
            ])
            ->withAvg('serviceReviews as avg_rating', 'rating')
            ->leftJoin('service_providers', 'services.service_provider_id', '=', 'service_providers.id')
            ->where(function ($q) {
                $q->where('service_providers.approval_status', 'approved')
                    ->orWhereNull('services.service_provider_id');
            })
            ->orderByDesc('completed_requests_count')
            ->orderByDesc('avg_rating')
            ->orderByDesc('reviews_count')
            ->take(6)
            ->get();

        return view('livewire.customer.customer-profile-component', [
            'user' => $user,
            'interests' => $user->interests()->orderBy('name')->get(),
            'popularServices' => $popularServices,
        ])->layout('layouts.base');
    }
}
