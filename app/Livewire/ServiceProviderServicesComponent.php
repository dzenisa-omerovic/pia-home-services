<?php

namespace App\Livewire;

use App\Models\ServiceProvider;
use Livewire\Component;

class ServiceProviderServicesComponent extends Component
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
        $provider = ServiceProvider::with(['user', 'category'])
            ->findOrFail($this->provider_id);
        if (($provider->approval_status ?? 'pending') !== 'approved') {
            abort(404);
        }

        $services = $provider->services()
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.service-provider-services-component', [
            'provider' => $provider,
            'services' => $services,
        ])->layout('layouts.base');
    }
}
