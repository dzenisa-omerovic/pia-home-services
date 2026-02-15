<?php

namespace App\Livewire\Admin;

use App\Models\AppSetting;
use App\Services\PasswordHistoryService;
use Livewire\Component;

class AdminSecuritySettingsComponent extends Component
{
    public $password_history_count;

    public function mount()
    {
        $this->password_history_count = PasswordHistoryService::getHistoryCount();
    }

    public function save()
    {
        $this->validate([
            'password_history_count' => 'required|integer|min:1|max:50',
        ]);

        AppSetting::setValue('password_history_count', (int)$this->password_history_count);
        session()->flash('message', 'Security settings updated.');
    }

    public function render()
    {
        return view('livewire.admin.admin-security-settings-component')
            ->layout('layouts.base');
    }
}
