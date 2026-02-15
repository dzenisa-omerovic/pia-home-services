<?php

namespace App\Livewire;

use App\Models\ServiceMessage;
use App\Models\ServiceRequest;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceMessagesComponent extends Component
{
    public $request_id;
    public $message;
    public $request;

    public function mount($request_id)
    {
        $this->request_id = $request_id;
        $this->request = ServiceRequest::find($request_id);

        if (!$this->request) {
            abort(404);
        }

        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $sprovider = ServiceProvider::find($this->request->service_provider_id);
        $isProvider = $sprovider && $sprovider->user_id === $user->id;
        $isCustomer = $this->request->customer_id === $user->id;

        if (!$isProvider && !$isCustomer) {
            abort(403);
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:2000'
        ]);

        ServiceMessage::create([
            'service_request_id' => $this->request_id,
            'sender_id' => Auth::id(),
            'message' => $this->message
        ]);

        $this->message = null;
    }

    public function render()
    {
        $messages = ServiceMessage::where('service_request_id', $this->request_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.service-messages-component', [
            'messages' => $messages,
            'request' => $this->request
        ])->layout('layouts.base');
    }
}
