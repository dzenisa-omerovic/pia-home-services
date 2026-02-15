<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;

class AdminServicesComponent extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $serviceToDeleteId;
    public $serviceToDeleteName;

    public function deleteService($service_id)
    {
        $service = Service::find($service_id);
        if($service->thumbnail)
        {
            unlink('images/services/thumbnails' . '/' . $service->thumbnail);

        }
        if($service->image)
        {
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
        $services = Service::paginate(10);
        return view('livewire.admin.admin-services-component', ['services' => $services])->layout('layouts.base') ;
    }
}
