<?php

namespace App\Livewire\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditCustomerProfileComponent extends Component
{
    public $name;
    public $email;
    public $phone;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || $user->utype !== 'CST') {
            abort(403);
        }

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updated($fields)
    {
        $userId = Auth::id();
        $this->validateOnly($fields, [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => 'required|string|max:50'
        ]);
    }

    public function updateProfile()
    {
        $user = Auth::user();
        if (!$user || $user->utype !== 'CST') {
            abort(403);
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'required|string|max:50'
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->save();

        session()->flash('message', 'Profile has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.customer.edit-customer-profile-component')
            ->layout('layouts.base');
    }
}
