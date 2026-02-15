<?php

namespace App\Livewire\Admin;
use App\Models\ServiceCategory;

use Livewire\Component;
use Livewire\WithPagination;

class AdminServiceCategoryComponent extends Component
{
    use WithPagination;
    public $showDeleteModal = false;
    public $categoryToDeleteId = null;
    public $categoryToDeleteName = '';

    public function openDeleteModal($id)
    {
        $scategory = ServiceCategory::find($id);
        if(!$scategory) {
            return;
        }

        $this->categoryToDeleteId = $scategory->id;
        $this->categoryToDeleteName = $scategory->name;
        $this->showDeleteModal = true;
    }

    public function cancelDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->categoryToDeleteId = null;
        $this->categoryToDeleteName = '';
    }

    public function confirmDeleteCategory()
    {
        if($this->categoryToDeleteId) {
            $this->deleteServiceCategory($this->categoryToDeleteId);
        }
        $this->cancelDeleteModal();
    }

    public function deleteServiceCategory($id)
    {
        $scategory = ServiceCategory::find($id);
        if(!$scategory) {
            return;
        }

        if($scategory->image)
        {
            unlink('images/categories' . '/' . $scategory->image);
        }
        $scategory->delete();
        session()->flash('message', 'Service Category has been deleted successfully!');

    }
    public function render()
    {
        $scategories = ServiceCategory::withCount('serviceRequests')
            ->paginate(10);
        return view('livewire.admin.admin-service-category-component', ['scategories'=>$scategories])->layout('layouts.base');
    }
}
