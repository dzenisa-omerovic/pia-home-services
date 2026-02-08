<?php

namespace App\Livewire\Sprovider;

use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SproviderServicesComponent extends Component
{
    use WithPagination;

    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $services = Service::where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->paginate(10);

        return view('livewire.sprovider.sprovider-services-component', [
            'services' => $services,
            'sprovider' => $sprovider
        ])->layout('layouts.base');
    }
}
