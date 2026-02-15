<?php

namespace App\Livewire\Customer;

use App\Models\ServiceComplaint;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerComplaintComponent extends Component
{
    public $request_id;
    public $title;
    public $description;
    public $request;

    public function mount($request_id)
    {
        $this->request_id = $request_id;
        $this->request = ServiceRequest::find($request_id);

        if (!$this->request || $this->request->customer_id !== Auth::id()) {
            abort(403);
        }
    }

    public function submitComplaint()
    {
        $existing = ServiceComplaint::where('service_request_id', $this->request_id)
            ->where('customer_id', Auth::id())
            ->first();
        if ($existing) {
            return;
        }

        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        ServiceComplaint::create([
            'service_request_id' => $this->request_id,
            'customer_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'open'
        ]);

        $this->dispatch('toast', type: 'success', message: 'Complaint submitted.');
        $this->dispatch('app-redirect', url: route('customer.requests'));
    }

    public function render()
    {
        $existing = ServiceComplaint::where('service_request_id', $this->request_id)
            ->where('customer_id', Auth::id())
            ->first();

        return view('livewire.customer.customer-complaint-component', [
            'existing' => $existing
        ])->layout('layouts.base');
    }
}
