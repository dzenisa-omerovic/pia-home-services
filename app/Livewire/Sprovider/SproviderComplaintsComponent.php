<?php

namespace App\Livewire\Sprovider;

use App\Models\ServiceComplaint;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SproviderComplaintsComponent extends Component
{
    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            abort(403);
        }

        $complaints = ServiceComplaint::whereHas('customer', function ($q) {
            $q->whereNotNull('id');
        })
        ->whereHas('serviceRequest', function ($q) use ($sprovider) {
            $q->where('service_provider_id', $sprovider->id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.sprovider.sprovider-complaints-component', [
            'complaints' => $complaints
        ])->layout('layouts.base');
    }
}
