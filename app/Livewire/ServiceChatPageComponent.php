<?php

namespace App\Livewire;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceChatPageComponent extends Component
{
    public $service_slug;
    public $service;
    public $customer_id;
    public $canView = false;

    public function mount($service_slug, $customer_id = null)
    {
        $this->service_slug = $service_slug;
        $this->service = Service::with('serviceProvider')->where('slug', $service_slug)->first();

        if (!$this->service) {
            abort(404);
        }

        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $isCustomer = $user->utype === 'CST';
        $isProviderOwner = $this->service->serviceProvider && $this->service->serviceProvider->user_id === $user->id;

        if ($isCustomer) {
            $this->customer_id = $user->id;
            $this->canView = true;
        } elseif ($isProviderOwner && $customer_id) {
            $this->customer_id = $customer_id;
            $this->canView = true;
        } else {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.service-chat-page-component', [
            'service' => $this->service,
            'customer_id' => $this->customer_id,
            'canView' => $this->canView
        ])->layout('layouts.base');
    }
}
