<?php

namespace App\Livewire\Admin;

use App\Models\ServiceProvider;
use Livewire\Component;
use Livewire\WithPagination;

class AdminServiceProvidersComponent extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $providerToDeleteId;
    public $providerToDeleteName;

    public function approve($id)
    {
        $sprovider = ServiceProvider::find($id);
        if ($sprovider) {
            $sprovider->approval_status = 'approved';
            $sprovider->save();
            session()->flash('message', 'Service provider approved.');
        }
    }

    public function reject($id)
    {
        $sprovider = ServiceProvider::find($id);
        if ($sprovider) {
            $sprovider->approval_status = 'rejected';
            $sprovider->save();
            session()->flash('message', 'Service provider rejected.');
        }
    }

    public function openDeleteModal($provider_id)
    {
        $sprovider = ServiceProvider::with('user')->find($provider_id);
        if (!$sprovider) {
            return;
        }

        $this->providerToDeleteId = $sprovider->id;
        $this->providerToDeleteName = $sprovider->user?->name ?? 'this service provider';
        $this->showDeleteModal = true;
    }

    public function cancelDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->providerToDeleteId = null;
        $this->providerToDeleteName = null;
    }

    public function confirmDeleteProvider()
    {
        if (!$this->providerToDeleteId) {
            return;
        }

        $sprovider = ServiceProvider::with(['user', 'services'])->find($this->providerToDeleteId);
        if ($sprovider) {
            foreach ($sprovider->services as $service) {
                if ($service->thumbnail && file_exists('images/services/thumbnails/' . $service->thumbnail)) {
                    unlink('images/services/thumbnails/' . $service->thumbnail);
                }
                if ($service->image && file_exists('images/services/' . $service->image)) {
                    unlink('images/services/' . $service->image);
                }
            }

            if (!empty($sprovider->image) && file_exists('images/sproviders/' . $sprovider->image)) {
                unlink('images/sproviders/' . $sprovider->image);
            }

            // Deleting provider user cascades provider/services/requests/messages/reviews/complaints.
            if ($sprovider->user) {
                $sprovider->user->delete();
            } else {
                $sprovider->delete();
            }
            session()->flash('message', 'Service provider has been deleted successfully!');
        }

        $this->cancelDeleteModal();
    }

    public function render()
    {
        $sproviders = ServiceProvider::paginate(12);
        return view('livewire.admin.admin-service-providers-component' ,['sproviders' => $sproviders])->layout('layouts.base');
    }
}
