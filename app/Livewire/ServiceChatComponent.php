<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\ServiceChatMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceChatComponent extends Component
{
    public $service_id;
    public $customer_id;
    public $message;
    public $service;
    public $canView = false;

    public function mount($service_id, $customer_id = null)
    {
        $this->service_id = $service_id;
        $this->customer_id = $customer_id;
        $this->service = Service::with('serviceProvider')->find($service_id);

        if (!$this->service) {
            $this->canView = false;
            return;
        }

        $user = Auth::user();
        if (!$user) {
            $this->canView = false;
            return;
        }

        $isCustomer = $user->utype === 'CST';
        $isProviderOwner = $this->service->serviceProvider && $this->service->serviceProvider->user_id === $user->id;

        if ($isCustomer) {
            $this->customer_id = $user->id;
            $this->canView = true;
        } elseif ($isProviderOwner && $this->customer_id) {
            $this->canView = true;
        } else {
            $this->canView = false;
        }
    }

    public function sendMessage()
    {
        if (!$this->canView) {
            return;
        }

        $this->validate([
            'message' => 'required|string|max:2000'
        ]);

        ServiceChatMessage::create([
            'service_id' => $this->service_id,
            'customer_id' => $this->customer_id,
            'sender_id' => Auth::id(),
            'message' => $this->message
        ]);

        $this->message = null;
    }

    public function render()
    {
        $messages = collect();
        if ($this->canView) {
            $messages = ServiceChatMessage::where('service_id', $this->service_id)
                ->where('customer_id', $this->customer_id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.service-chat-component', [
            'messages' => $messages
        ]);
    }
}
