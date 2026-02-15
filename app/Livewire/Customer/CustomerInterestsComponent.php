<?php

namespace App\Livewire\Customer;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerInterestsComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user || $user->utype !== 'CST') {
            abort(403);
        }

        return view('livewire.customer.customer-interests-component', [
            'interests' => $user->interests()->orderBy('name')->get()
        ])->layout('layouts.base');
    }
}
