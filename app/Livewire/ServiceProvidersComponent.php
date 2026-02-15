<?php

namespace App\Livewire;

use App\Models\ServiceProvider;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceProvidersComponent extends Component
{
    public $category_id = '';
    public $min_rating = '';
    public $sort_rating = 'desc';
    public $pending_category_id = '';
    public $pending_min_rating = '';
    public $pending_sort_rating = 'desc';

    protected $queryString = [
        'category_id' => ['except' => ''],
        'min_rating' => ['except' => ''],
        'sort_rating' => ['except' => 'desc']
    ];

    public function mount()
    {
        if (!in_array(strtolower((string) $this->sort_rating), ['asc', 'desc'], true)) {
            $this->sort_rating = 'desc';
        }

        $this->pending_category_id = $this->category_id;
        $this->pending_min_rating = $this->min_rating;
        $this->pending_sort_rating = $this->sort_rating ?: 'desc';
    }

    public function applyFilters()
    {
        $this->category_id = $this->pending_category_id;
        $this->min_rating = $this->pending_min_rating;
        $this->sort_rating = strtolower((string) $this->pending_sort_rating) === 'asc' ? 'asc' : 'desc';
    }

    public function resetFilters()
    {
        $this->pending_category_id = '';
        $this->pending_min_rating = '';
        $this->pending_sort_rating = 'desc';
        $this->category_id = '';
        $this->min_rating = '';
        $this->sort_rating = 'desc';
    }

    public function render()
    {
        $query = ServiceProvider::with(['user', 'category'])
            ->where('service_providers.approval_status', 'approved')
            ->leftJoin('service_reviews', 'service_providers.id', '=', 'service_reviews.service_provider_id')
            ->select('service_providers.*', DB::raw('COALESCE(AVG(service_reviews.rating),0) as avg_rating'), DB::raw('COUNT(service_reviews.id) as review_count'))
            ->groupBy(
                'service_providers.id',
                'service_providers.user_id',
                'service_providers.image',
                'service_providers.about',
                'service_providers.city',
                'service_providers.approval_status',
                'service_providers.completed_jobs_count',
                'service_providers.promotion_credits',
                'service_providers.service_category_id',
                'service_providers.service_locations',
                'service_providers.created_at',
                'service_providers.updated_at'
            );

        if (!empty($this->category_id)) {
            $query->where('service_providers.service_category_id', $this->category_id);
        }
        if ($this->min_rating !== '' && is_numeric($this->min_rating)) {
            $query->havingRaw('COALESCE(AVG(service_reviews.rating),0) >= ?', [(float)$this->min_rating]);
        }
        if (Auth::check() && Auth::user()->utype === 'SVP') {
            $query->where('service_providers.user_id', '!=', Auth::id());
        }

        $ratingSort = strtolower($this->sort_rating) === 'asc' ? 'asc' : 'desc';
        $sproviders = $query->orderBy('avg_rating', $ratingSort)
            ->orderByDesc('review_count')
            ->get();

        $categories = ServiceCategory::orderBy('name')->get();

        return view('livewire.service-providers-component', [
            'sproviders' => $sproviders,
            'categories' => $categories
        ])
            ->layout('layouts.base');
    }
}
