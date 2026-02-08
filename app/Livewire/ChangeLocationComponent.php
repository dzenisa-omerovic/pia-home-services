<?php

namespace App\Livewire;

use Livewire\Component;

class ChangeLocationComponent extends Component
{
    public $streetnumber;
    public $routes;
    public $city;
    public $state;
    public $country;
    public $zipcode;
    public function changeLocation()
    {
        session()->put('streetnumber', $this->streetnumber);
        session()->put('routes', $this->routes);
        session()->put('state', $this->state);
        session()->put('country', $this->country);
        session()->put('city', $this->city);
        session()->put('zipcode', $this->zipcode);
        session()->flash('message', 'Location has been changed!');
        $this->dispatch('refreshComponent')->to(LocationComponent::class); //emitTo
    }
    
    public function render()
    {
        return view('livewire.change-location-component')->layout('layouts.base');
    }
}
