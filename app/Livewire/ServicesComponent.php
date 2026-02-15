<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\ServiceCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesComponent extends Component
{
    use WithPagination;

    public $category_id = '';
    public $sort_by = 'latest';
    public $pending_category_id = '';
    public $pending_sort_by = 'latest';

    protected $queryString = [
        'category_id' => ['except' => ''],
        'sort_by' => ['except' => 'latest'],
    ];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pending_category_id = $this->category_id;
        $this->pending_sort_by = $this->sort_by ?: 'latest';
    }

    public function applyFilters()
    {
        $this->category_id = $this->pending_category_id;
        $this->sort_by = $this->pending_sort_by ?: 'latest';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->pending_category_id = '';
        $this->pending_sort_by = 'latest';
        $this->category_id = '';
        $this->sort_by = 'latest';
        $this->resetPage();
    }

    public function render()
    {
        $baseQuery = Service::query()
            ->with(['category', 'serviceProvider'])
            ->select('services.*')
            ->withCount([
                'serviceRequests as completed_requests_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'serviceReviews as reviews_count',
            ])
            ->withAvg('serviceReviews as avg_rating', 'rating')
            ->leftJoin('service_providers', 'services.service_provider_id', '=', 'service_providers.id')
            ->where(function ($q) {
                $q->where('service_providers.approval_status', 'approved')
                    ->orWhereNull('services.service_provider_id');
            });

        $query = clone $baseQuery;

        if (!empty($this->category_id)) {
            $query->where('services.service_category_id', $this->category_id);
        }

        switch ($this->sort_by) {
            case 'price_asc':
                $query->orderBy('services.price', 'asc')->orderByDesc('services.created_at');
                break;
            case 'price_desc':
                $query->orderBy('services.price', 'desc')->orderByDesc('services.created_at');
                break;
            case 'name_asc':
                $query->orderBy('services.name', 'asc');
                break;
            default:
                $query->orderByDesc('services.created_at');
                break;
        }

        $services = $query->paginate(8);
        $categories = ServiceCategory::orderBy('name')->get();

        return view('livewire.services-component', [
            'services' => $services,
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
