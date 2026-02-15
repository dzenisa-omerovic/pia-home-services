<?php

namespace App\Livewire\Sprovider;

use App\Models\Service;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class SproviderAddServiceComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $tagline;
    public $service_category_id;
    public $price;
    public $discount;
    public $discount_type;
    public $image;
    public $thumbnail;
    public $description;
    public $inclusion;
    public $exclusion;

    public function mount()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $this->service_category_id = $sprovider ? $sprovider->service_category_id : null;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name, '-');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required|unique:services,slug',
            'tagline' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,png',
            'thumbnail' => 'required|mimes:jpeg,png',
            'description' => 'required',
            'inclusion' => 'required',
            'exclusion' => 'required'
        ]);
    }

    public function createService()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:services,slug',
            'tagline' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,png',
            'thumbnail' => 'required|mimes:jpeg,png',
            'description' => 'required',
            'inclusion' => 'required',
            'exclusion' => 'required'
        ]);

        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            session()->flash('message', 'Service Provider profile is missing.');
            return;
        }
        if (!$sprovider->service_category_id) {
            session()->flash('message', 'Please set your service category before adding services.');
            return;
        }

        $service = new Service();
        $service->name = $this->name;
        $service->slug = $this->slug;
        $service->tagline = $this->tagline;
        $service->service_category_id = $sprovider->service_category_id;
        $service->service_provider_id = $sprovider->id;
        $service->price = $this->price;
        $service->discount = $this->discount;
        $service->discount_type = $this->discount_type;
        $service->inclusion = str_replace("\n", '|', trim($this->inclusion));
        $service->exclusion = str_replace("\n", '|', trim($this->exclusion));
        $service->description = $this->description;

        $thumbnailName = Carbon::now()->timestamp . '.' . $this->thumbnail->extension();
        $this->thumbnail->storeAs('services/thumbnails', $thumbnailName);
        $service->thumbnail = $thumbnailName;

        $imageName = Carbon::now()->timestamp . '.' . $this->image->extension();
        $this->image->storeAs('services', $imageName);
        $service->image = $imageName;

        $service->save();
        session()->flash('message', 'Service has been created successfully!');
        return redirect()->route('home.service_details', ['service_slug' => $service->slug]);
    }

    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        return view('livewire.sprovider.sprovider-add-service-component', ['sprovider' => $sprovider])
            ->layout('layouts.base');
    }
}
