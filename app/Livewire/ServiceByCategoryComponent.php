<?php

namespace App\Livewire;

use App\Models\ServiceCategory;
use Livewire\Component;

class ServiceByCategoryComponent extends Component
{
    public $category_slug;
    public function mount($category_slug)
    {
        if (!auth()->check()) {
            session(['url.intended' => url()->current()]);
            return redirect()->route('login', ['status' => 'loginRequiredCategory']);
        }
        $this->category_slug = $category_slug;
    }
    public function render()
    {
        $scategory = ServiceCategory::where('slug', $this->category_slug)->first();
        return view('livewire.service-by-category-component', ['scategory' => $scategory])->layout('layouts.base');
    }
}
