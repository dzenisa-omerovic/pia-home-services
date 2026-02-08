<?php

namespace App\Livewire\Sprovider;

use App\Models\Service;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class SproviderEditServiceComponent extends Component
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
    public $newthumbnail;
    public $newimage;
    public $service_id;

    public $sprovider;

    public function mount($service_slug)
    {
        $this->sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$this->sprovider) {
            abort(403);
        }

        $service = Service::where('slug', $service_slug)
            ->where('service_provider_id', $this->sprovider->id)
            ->first();

        if (!$service) {
            abort(404);
        }

        $this->service_id = $service->id;
        $this->name = $service->name;
        $this->slug = $service->slug;
        $this->tagline = $service->tagline;
        $this->service_category_id = $service->service_category_id;
        $this->price = $service->price;
        $this->discount = $service->discount;
        $this->discount_type = $service->discount_type;
        $this->image = $service->image;
        $this->thumbnail = $service->thumbnail;
        $this->description = $service->description;
        $this->inclusion = str_replace("|", "\n", $service->inclusion);
        $this->exclusion = str_replace("|", "\n", $service->exclusion);
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name, '-');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required|unique:services,slug,' . $this->service_id,
            'tagline' => 'required',
            'price' => 'required',
            'description' => 'required',
            'inclusion' => 'required',
            'exclusion' => 'required'
        ]);

        if ($this->newthumbnail) {
            $this->validateOnly($fields, [
                'newthumbnail' => 'required|mimes:jpeg,png'
            ]);
        }
        if ($this->newimage) {
            $this->validateOnly($fields, [
                'newimage' => 'required|mimes:jpeg,png'
            ]);
        }
    }

    public function updateService()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:services,slug,' . $this->service_id,
            'tagline' => 'required',
            'price' => 'required',
            'description' => 'required',
            'inclusion' => 'required',
            'exclusion' => 'required'
        ]);

        if ($this->newthumbnail) {
            $this->validate([
                'newthumbnail' => 'required|mimes:jpeg,png'
            ]);
        }
        if ($this->newimage) {
            $this->validate([
                'newimage' => 'required|mimes:jpeg,png'
            ]);
        }

        $service = Service::where('id', $this->service_id)
            ->where('service_provider_id', $this->sprovider->id)
            ->first();

        if (!$service) {
            abort(403);
        }

        $service->name = $this->name;
        $service->slug = $this->slug;
        $service->tagline = $this->tagline;
        $service->service_category_id = $this->service_category_id;
        $service->price = $this->price;
        $service->discount = $this->discount;
        $service->discount_type = $this->discount_type;
        $service->inclusion = str_replace("\n", '|', trim($this->inclusion));
        $service->exclusion = str_replace("\n", '|', trim($this->exclusion));
        $service->description = $this->description;

        if ($this->newthumbnail) {
            if ($service->thumbnail) {
                unlink('images/services/thumbnails' . '/' . $service->thumbnail);
            }
            $imageName = Carbon::now()->timestamp . '.' . $this->newthumbnail->extension();
            $this->newthumbnail->storeAs('services/thumbnails', $imageName);
            $service->thumbnail = $imageName;
        }

        if ($this->newimage) {
            if ($service->image) {
                unlink('images/services' . '/' . $service->image);
            }
            $imageName2 = Carbon::now()->timestamp . '.' . $this->newimage->extension();
            $this->newimage->storeAs('services', $imageName2);
            $service->image = $imageName2;
        }

        $service->save();
        session()->flash('message', 'Service has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.sprovider.sprovider-edit-service-component', [
            'sprovider' => $this->sprovider
        ])->layout('layouts.base');
    }
}
