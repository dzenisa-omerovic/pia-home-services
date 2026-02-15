<?php

namespace App\Livewire\Sprovider;

use App\Models\ServiceCategory;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;


class EditSproviderProfileComponent extends Component
{
    use WithFileUploads;
    public $service_provider_id;
    public $image;
    public $about;
    public $city;
    public $service_locations;
    public $service_category_id;
    public $newimage;
    public $new_category_name;
    public function mount()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $this->service_provider_id = $sprovider->id;
        $this->image = $sprovider->image;
        $this->about = $sprovider->about;
        $this->city = $sprovider->city;
        $this->service_category_id = $sprovider->service_category_id;
        $this->service_locations = $sprovider->service_locations;
    }
    public function onServiceCategoryChanged($value)
    {
        $this->service_category_id = $value;
        if ($value !== 'other') {
            $this->new_category_name = null;
        }
    }
    public function updateProfile()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if ($this->service_category_id === 'other') {
            $this->validate([
                'new_category_name' => 'required|string|max:255'
            ]);
            $baseSlug = Str::slug($this->new_category_name);
            $slug = $baseSlug ?: ('category-' . Carbon::now()->timestamp);
            if (ServiceCategory::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . Carbon::now()->timestamp;
            }
            $defaultImage = ServiceCategory::value('image') ?? '1521969345.png';
            $newCategory = new ServiceCategory();
            $newCategory->name = $this->new_category_name;
            $newCategory->slug = $slug;
            $newCategory->image = $defaultImage;
            $newCategory->save();
            $this->service_category_id = $newCategory->id;
        } elseif (empty($this->service_category_id)) {
            $this->addError('service_category_id', 'Please select a category or choose Other.');
            return;
        }
        if($this->newimage)
        {
            $imageName = Carbon::now()->timestamp . '.' . $this->newimage->extension();
            $this->newimage->storeAs('sproviders', $imageName);
            $sprovider->image = $imageName;
        }
        $sprovider->about = $this->about;
        $sprovider->city = $this->city;
        $sprovider->service_category_id = $this->service_category_id;
        $sprovider->service_locations = $this->service_locations;
        $sprovider->save();
        session()->flash('message', 'Profile has been updated successfully!');
    }

    public function render()
    {
        $scategories = ServiceCategory::all();
        return view('livewire.sprovider.edit-sprovider-profile-component', ['scategories' => $scategories])->layout('layouts.base');
    }
}
