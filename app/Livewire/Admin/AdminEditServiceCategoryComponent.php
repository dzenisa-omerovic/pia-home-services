<?php

namespace App\Livewire\Admin;

use App\Models\ServiceCategory;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminEditServiceCategoryComponent extends Component
{
    use WithFileUploads;
    public $category_id;
    public $name;
    public $image;
    public $newimage;
    public $featured;
    public function mount($category_id)
    {
        $scategory = ServiceCategory::find($category_id);
        $this->category_id = $scategory->id;
        $this->name = $scategory->name;
        $this->image = $scategory->image;
        $this->featured = $scategory->featured;

    }
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required'
        ]);
        if($this->newimage)
        {
            $this->validateOnly($fields, [
                'newimage' => 'required|mimes:jpeg,png'
            ]);
        }
    }
    public function updateServiceCategory()
    {
        $this->validate([
            'name' => 'required'

        ]);
        if($this->newimage)
        {
            $this->validate([
                'newimage' => 'required|mimes:jpeg,png'
            ]);
        }
        $scategory = ServiceCategory::find($this->category_id);
        $scategory->name = $this->name;
        if($this->newimage)
        {
            $imageName = Carbon::now()->timestamp . '.' . $this->newimage->extension();
            $this->newimage->storeAs('categories', $imageName);
            $scategory->image = $imageName;
        }
        $scategory->featured = $this->featured;
        $scategory->save();
        session()->flash('message', 'Service Category has been updated successfully!');
    }
    public function render()
    {
        return view('livewire.admin.admin-edit-service-category-component')->layout('layouts.base');
    }
}
