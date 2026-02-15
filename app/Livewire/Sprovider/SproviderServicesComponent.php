<?php

namespace App\Livewire\Sprovider;

use App\Models\Service;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SproviderServicesComponent extends Component
{
    use WithPagination;

    private const PROMOTION_DAYS = 7;
    public $showDeleteModal = false;
    public $serviceToDeleteId = null;
    public $serviceToDeleteName = '';

    public function openDeleteModal($service_id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            return;
        }

        $service = Service::where('id', $service_id)
            ->where('service_provider_id', $sprovider->id)
            ->first();

        if (!$service) {
            return;
        }

        $this->serviceToDeleteId = $service->id;
        $this->serviceToDeleteName = $service->name ?? '';
        $this->showDeleteModal = true;
    }

    public function cancelDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->serviceToDeleteId = null;
        $this->serviceToDeleteName = '';
    }

    public function confirmDeleteService()
    {
        if (!$this->serviceToDeleteId) {
            $this->cancelDeleteModal();
            return;
        }

        $this->deleteService($this->serviceToDeleteId);
        $this->cancelDeleteModal();
    }

    public function deleteService($service_id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            return;
        }

        $service = Service::where('id', $service_id)
            ->where('service_provider_id', $sprovider->id)
            ->first();

        if (!$service) {
            return;
        }

        if ($service->thumbnail && file_exists('images/services/thumbnails' . '/' . $service->thumbnail)) {
            unlink('images/services/thumbnails' . '/' . $service->thumbnail);
        }
        if ($service->image && file_exists('images/services' . '/' . $service->image)) {
            unlink('images/services' . '/' . $service->image);
        }

        $service->delete();
        session()->flash('message', 'Service has been deleted successfully!');
    }

    public function promoteService($service_id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$sprovider) {
            return;
        }

        $service = Service::where('id', $service_id)
            ->where('service_provider_id', $sprovider->id)
            ->first();

        if (!$service) {
            return;
        }

        if ((int) $sprovider->promotion_credits < 1) {
            session()->flash('message', 'You do not have free promotion credits.');
            return;
        }

        if ($service->promoted_until && $service->promoted_until->isFuture()) {
            session()->flash('message', 'This service is already promoted.');
            return;
        }

        $sprovider->promotion_credits = (int) $sprovider->promotion_credits - 1;
        $sprovider->save();
        $this->dispatch('promotion-credits-updated', credits: (int) $sprovider->promotion_credits);

        $service->promoted_until = Carbon::now()->addDays(self::PROMOTION_DAYS);
        $service->save();

        session()->flash('message', 'Service promoted for ' . self::PROMOTION_DAYS . ' days.');
    }

    public function render()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $services = Service::where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->withCount([
                'serviceRequests as completed_requests_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'serviceReviews as reviews_count',
            ])
            ->withAvg('serviceReviews as avg_rating', 'rating')
            ->orderByRaw('CASE WHEN promoted_until IS NOT NULL AND promoted_until > NOW() THEN 0 ELSE 1 END')
            ->orderByDesc('promoted_until')
            ->orderByDesc('created_at')
            ->paginate(10);

        $popularServices = Service::where('service_provider_id', $sprovider ? $sprovider->id : 0)
            ->withCount([
                'serviceRequests as completed_requests_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'serviceReviews as reviews_count',
            ])
            ->withAvg('serviceReviews as avg_rating', 'rating')
            ->orderByDesc('completed_requests_count')
            ->orderByDesc('avg_rating')
            ->orderByDesc('reviews_count')
            ->take(6)
            ->get();

        return view('livewire.sprovider.sprovider-services-component', [
            'services' => $services,
            'sprovider' => $sprovider,
            'popularServices' => $popularServices,
        ])->layout('layouts.base');
    }
}
