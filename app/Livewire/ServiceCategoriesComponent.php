<?php

namespace App\Livewire;

use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceCategoriesComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $pending_search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pending_search = $this->search;
    }

    public function applySearch()
    {
        $this->search = trim($this->pending_search);
        $this->resetPage();
    }

    public function render()
    {
        $canUseSearchAndPagination = Auth::check() && in_array(Auth::user()->utype, ['CST', 'SVP'], true);

        $query = ServiceCategory::query();
        if ($canUseSearchAndPagination && $this->search !== '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($canUseSearchAndPagination) {
            $scategories = $query->orderBy('name')->paginate(20);
        } else {
            $scategories = $query->orderBy('name')->limit(20)->get();
        }

        return view('livewire.service-categories-component', [
            'scategories' => $scategories,
            'canUseSearchAndPagination' => $canUseSearchAndPagination
        ])->layout('layouts.base');
    }
}
