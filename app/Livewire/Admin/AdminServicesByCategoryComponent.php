<?php

namespace App\Livewire\Admin;

use App\Models\ServiceCategory;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class AdminServicesByCategoryComponent extends Component
{
    use WithPagination;
    public $category_slug;
    public $showDeleteModal = false;
    public $serviceToDeleteId;
    public $serviceToDeleteName;

    public function mount($category_slug)
    {
        $this->category_slug = $category_slug;
    }

    public function deleteService($service_id)
    {
        $service = Service::find($service_id);
        if ($service->thumbnail) {
            unlink('images/services/thumbnails' . '/' . $service->thumbnail);
        }
        if ($service->image) {
            unlink('images/services' . '/' . $service->image);
        }

        $service->delete();
        session()->flash('message', 'Service has been deleted successfully!');
    }

    public function openDeleteModal($service_id)
    {
        $service = Service::find($service_id);
        if (!$service) {
            return;
        }

        $this->serviceToDeleteId = $service->id;
        $this->serviceToDeleteName = $service->name;
        $this->showDeleteModal = true;
    }

    public function cancelDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->serviceToDeleteId = null;
        $this->serviceToDeleteName = null;
    }

    public function confirmDeleteService()
    {
        if (!$this->serviceToDeleteId) {
            return;
        }

        $this->deleteService($this->serviceToDeleteId);
        $this->cancelDeleteModal();
    }

    public function render()
    {
        $category = ServiceCategory::where('slug', $this->category_slug)->first();
        $services = Service::where('service_category_id', $category->id)->paginate(10);
        return view('livewire.admin.admin-services-by-category-component', ['category_name' => $category->name, 'services' => $services])->layout('layouts.base');
    }
}
