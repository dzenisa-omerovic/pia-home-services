<?php

namespace App\Livewire\Sprovider;

use App\Models\ServiceComplaint;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SproviderComplaintReplyComponent extends Component
{
    public $complaint_id;
    public $response;
    public $complaint;

    public function mount($complaint_id)
    {
        $this->complaint_id = $complaint_id;
        $this->complaint = ServiceComplaint::find($complaint_id);

        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        if (!$this->complaint || !$sprovider) {
            abort(403);
        }

        if ($this->complaint->serviceRequest && $this->complaint->serviceRequest->service_provider_id !== $sprovider->id) {
            abort(403);
        }

        $this->response = $this->complaint->response;
    }

    public function submitResponse()
    {
        if ($this->complaint->status === 'closed') {
            session()->flash('message', 'Complaint already closed.');
            return;
        }

        $this->validate([
            'response' => 'required|string'
        ]);

        $this->complaint->response = $this->response;
        $this->complaint->responded_at = now();
        $this->complaint->status = 'closed';
        $this->complaint->save();

        session()->flash('message', 'Complaint closed with response.');
    }

    public function render()
    {
        return view('livewire.sprovider.sprovider-complaint-reply-component')
            ->layout('layouts.base');
    }
}
