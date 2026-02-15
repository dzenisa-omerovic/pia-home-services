<?php

namespace App\Livewire\Sprovider;

use App\Models\ServiceReview;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SproviderReviewsComponent extends Component
{
    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            abort(403);
        }

        $reviews = ServiceReview::where('service_provider_id', $sprovider->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $total = $reviews->count();
        $avg = $total > 0 ? round($reviews->avg('rating'), 2) : 0;
        $distribution = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        $perService = ServiceReview::where('service_reviews.service_provider_id', $sprovider->id)
            ->join('services', 'service_reviews.service_id', '=', 'services.id')
            ->select('service_reviews.service_id', 'services.name', DB::raw('AVG(service_reviews.rating) as avg_rating'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('service_reviews.service_id', 'services.name')
            ->get()
            ->map(function ($row) {
                $row->score = round($row->avg_rating * log(1 + $row->cnt), 2);
                return $row;
            });

        $weeksBack = 5;
        $rangeStart = Carbon::now()->startOfWeek()->subWeeks($weeksBack - 1);
        $rawWeekly = ServiceReview::query()
            ->where('service_provider_id', $sprovider->id)
            ->where('created_at', '>=', $rangeStart)
            ->select('created_at', 'rating')
            ->get();

        $weeklyBuckets = [];
        for ($i = 0; $i < $weeksBack; $i++) {
            $weekStart = Carbon::now()->startOfWeek()->subWeeks($weeksBack - 1 - $i);
            $key = $weekStart->toDateString();
            $weeklyBuckets[$key] = [
                'label' => $weekStart->format('d M'),
                'range' => $weekStart->format('d M') . ' - ' . $weekStart->copy()->endOfWeek()->format('d M'),
                'sum' => 0,
                'count' => 0,
                'avg_rating' => 0,
            ];
        }

        foreach ($rawWeekly as $row) {
            $weekKey = Carbon::parse($row->created_at)->startOfWeek()->toDateString();
            if (!isset($weeklyBuckets[$weekKey])) {
                continue;
            }

            $weeklyBuckets[$weekKey]['sum'] += (float) $row->rating;
            $weeklyBuckets[$weekKey]['count'] += 1;
        }

        foreach ($weeklyBuckets as $key => $bucket) {
            if ($bucket['count'] > 0) {
                $weeklyBuckets[$key]['avg_rating'] = round($bucket['sum'] / $bucket['count'], 2);
            }
        }

        $weeklyRatings = collect(array_values($weeklyBuckets));

        return view('livewire.sprovider.sprovider-reviews-component', [
            'reviews' => $reviews,
            'total' => $total,
            'avg' => $avg,
            'distribution' => $distribution,
            'perService' => $perService,
            'weeklyRatings' => $weeklyRatings,
        ])->layout('layouts.base');
    }
}
