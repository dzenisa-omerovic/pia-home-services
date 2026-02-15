<?php

namespace App\Livewire;

use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Slider;
use App\Models\ServiceReview;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class HomeComponent extends Component
{
    public function render()
    {
        $scategories = ServiceCategory::inRandomOrder()->take(18)->get();
        $promotedServices = Service::query()
            ->leftJoin('service_providers', 'services.service_provider_id', '=', 'service_providers.id')
            ->where('services.status', 1)
            ->where('services.promoted_until', '>', now())
            ->where(function ($q) {
                $q->where('service_providers.approval_status', 'approved')
                    ->orWhereNull('services.service_provider_id');
            })
            ->select('services.*')
            ->orderByDesc('services.promoted_until')
            ->take(8)
            ->get();
        $fservices = Service::where('featured', 1)->inRandomOrder()->take(8)->get();
        $fscategories = ServiceCategory::inRandomOrder()->take(8)->get();
        $sid = ServiceCategory::whereIn('slug', ['ac', 'tv', 'refrigerator', 'geyser', 'water-purifier'])->get()->pluck('id');
        $aservices = Service::whereIn('service_category_id', $sid)->inRandomOrder()->take(8)->get();
        $popularServices = Service::leftJoin('service_reviews', 'services.id', '=', 'service_reviews.service_id')
            ->leftJoin('service_providers', 'services.service_provider_id', '=', 'service_providers.id')
            ->leftJoin('service_requests', function ($join) {
                $join->on('services.id', '=', 'service_requests.service_id')
                    ->where('service_requests.status', '=', 'completed');
            })
            ->where('services.status', 1)
            ->where(function ($q) {
                $q->where('service_providers.approval_status', 'approved')
                    ->orWhereNull('services.service_provider_id');
            })
            ->select(
                'services.id',
                'services.name',
                'services.slug',
                'services.tagline',
                'services.thumbnail',
                'services.price',
                DB::raw('COALESCE(AVG(service_reviews.rating),0) as avg_rating')
            )
            ->selectRaw('COUNT(DISTINCT service_reviews.id) as review_count')
            ->selectRaw('COUNT(DISTINCT service_requests.id) as completed_count')
            ->selectRaw('(COALESCE(AVG(service_reviews.rating),0) * LOG(1 + COUNT(DISTINCT service_reviews.id))) as score')
            ->groupBy('services.id', 'services.name', 'services.slug', 'services.tagline', 'services.thumbnail', 'services.price')
            ->orderByDesc('score')
            ->orderByDesc('avg_rating')
            ->orderByDesc('review_count')
            ->orderByDesc('completed_count')
            ->take(4)
            ->get();
        $latestReviews = ServiceReview::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $slides = Slider::where('status', 1)->get();
        return view('livewire.home-component', [
            'scategories' => $scategories,
            'promotedServices' => $promotedServices,
            'fservices' => $fservices,
            'fscategories' => $fscategories,
            'aservices' => $aservices,
            'popularServices' => $popularServices,
            'latestReviews' => $latestReviews,
            'slides' => $slides
        ])->layout('layouts.base');
    }
}
