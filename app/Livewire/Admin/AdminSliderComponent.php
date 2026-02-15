<?php

namespace App\Livewire\Admin;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSliderComponent extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $slideToDeleteId;
    public $slideToDeleteTitle;

    public function deleteSlide($slide_id)
    {
        $slide = Slider::find($slide_id);
        unlink('images/slider/' . $slide->image);
        $slide->delete();
        session()->flash('message', 'Slide has been deleted successfully!');
    }

    public function openDeleteModal($slide_id)
    {
        $slide = Slider::find($slide_id);
        if (!$slide) {
            return;
        }

        $this->slideToDeleteId = $slide->id;
        $this->slideToDeleteTitle = $slide->title;
        $this->showDeleteModal = true;
    }

    public function cancelDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->slideToDeleteId = null;
        $this->slideToDeleteTitle = null;
    }

    public function confirmDeleteSlide()
    {
        if (!$this->slideToDeleteId) {
            return;
        }

        $this->deleteSlide($this->slideToDeleteId);
        $this->cancelDeleteModal();
    }

    public function render()
    {
        $slides = Slider::paginate(10);
        return view('livewire.admin.admin-slider-component', ['slides' => $slides] )->layout('layouts.base');
    }
}
