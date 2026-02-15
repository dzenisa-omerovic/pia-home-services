<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCustomersComponent extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $customerToDeleteId;
    public $customerToDeleteName;

    public $search = '';
    public $sort_by = 'latest';
    public $pending_search = '';
    public $pending_sort_by = 'latest';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pending_search = $this->search;
        $this->pending_sort_by = $this->sort_by ?: 'latest';
    }

    public function applyFilters()
    {
        $this->search = trim((string) $this->pending_search);
        $this->sort_by = $this->pending_sort_by ?: 'latest';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->pending_search = '';
        $this->pending_sort_by = 'latest';
        $this->search = '';
        $this->sort_by = 'latest';
        $this->resetPage();
    }

    public function openDeleteModal($customer_id)
    {
        $customer = User::where('utype', 'CST')->find($customer_id);
        if (!$customer) {
            return;
        }

        $this->customerToDeleteId = $customer->id;
        $this->customerToDeleteName = $customer->name;
        $this->showDeleteModal = true;
    }

    public function cancelDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->customerToDeleteId = null;
        $this->customerToDeleteName = null;
    }

    public function confirmDeleteCustomer()
    {
        if (!$this->customerToDeleteId) {
            return;
        }

        $customer = User::where('utype', 'CST')->find($this->customerToDeleteId);
        if ($customer) {
            // Deleting customer user cascades requests/messages/reviews/complaints/interests.
            $customer->delete();
            session()->flash('message', 'Customer has been deleted successfully!');
        }

        $this->cancelDeleteModal();
    }

    public function render()
    {
        $query = User::query()
            ->where('utype', 'CST');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->sort_by) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $customers = $query->paginate(12);

        return view('livewire.admin.admin-customers-component', [
            'customers' => $customers
        ])->layout('layouts.base');
    }
}
