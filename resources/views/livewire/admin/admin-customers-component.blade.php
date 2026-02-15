<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block !important;
        }
        .customer-filter-card {
            border: 1px solid #e6e8ee;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 14px;
            background: #fafcff;
        }
        .customer-filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            align-items: center;
            height: 34px;
        }
        .customer-filter-actions-label {
            visibility: hidden;
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .admin-pagination {
            display: flex;
            justify-content: center;
            margin: 14px 0 6px;
            clear: both;
            width: 100%;
        }
        .admin-pager {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f7f8fb;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.10);
        }
        .admin-pager .btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #0b3b5b;
            font-weight: 600;
        }
        .admin-pager .btn[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .admin-pager .btn:hover:not([disabled]) {
            background: #eaf0f6;
        }
        .admin-pager .btn.page-btn.active,
        .admin-pager .btn.page-btn.active:hover,
        .admin-pager .btn.page-btn.active:focus {
            background: #0b3b5b;
            color: #fff;
            border: 0;
        }
        .delete-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(11, 21, 36, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1100;
            padding: 16px;
        }
        .delete-modal-card {
            width: 100%;
            max-width: 430px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0,0,0,0.25);
        }
        .delete-modal-head {
            background: #0b3b5b;
            color: #fff;
            padding: 14px 18px;
            font-size: 16px;
            font-weight: 700;
        }
        .delete-modal-body {
            padding: 18px;
            color: #1f2b3a;
            font-size: 14px;
            line-height: 1.5;
        }
        .delete-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 0 18px 18px;
        }
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Customers</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Customers</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="content-central">
        <div class="content_info">
            <div class="paddings-mini">
                <div class="container">
                    <div class="row portfolioContainer">
                        <div class="col-md-12 profile1">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    All customers
                                </div>
                                <div class="panel-body">
                                    <div class="customer-filter-card">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="customerSearch" style="font-weight: 600;">Search</label>
                                                <input id="customerSearch" type="text" class="form-control" placeholder="Name, email or phone" wire:model.defer="pending_search">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="customerSort" style="font-weight: 600;">Sort by</label>
                                                <select id="customerSort" class="form-control" wire:model.defer="pending_sort_by">
                                                    <option value="latest">Newest first</option>
                                                    <option value="name_asc">Name A-Z</option>
                                                    <option value="email_asc">Email A-Z</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="customer-filter-actions-label">Actions</label>
                                                <div class="customer-filter-actions">
                                                    <button type="button" class="btn btn-default" wire:click="resetFilters">Reset</button>
                                                    <button type="button" class="btn btn-primary" wire:click="applyFilters">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Registered</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($customers as $customer)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $customer->profile_photo_url }}" alt="{{ $customer->name }}" height="48" style="border-radius: 50%;">
                                                    </td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>{{ $customer->created_at }}</td>
                                                    <td>
                                                        <a href="#" wire:click.prevent="openDeleteModal({{ $customer->id }})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No customers found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="admin-pagination">
                                        <div class="admin-pager">
                                            <button type="button" class="btn btn-default" wire:click="previousPage" @if($customers->onFirstPage()) disabled @endif aria-label="Previous page">
                                                <i class="fa fa-angle-left"></i>
                                            </button>
                                            @for($page = 1; $page <= max($customers->lastPage(), 1); $page++)
                                                <button
                                                    type="button"
                                                    class="btn btn-default page-btn @if($customers->currentPage() === $page) active @endif"
                                                    wire:click="gotoPage({{ $page }})"
                                                    aria-label="Page {{ $page }}">
                                                    {{ $page }}
                                                </button>
                                            @endfor
                                            <button type="button" class="btn btn-default" wire:click="nextPage" @if(!$customers->hasMorePages()) disabled @endif aria-label="Next page">
                                                <i class="fa fa-angle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($showDeleteModal)
        <div class="delete-modal-overlay">
            <div class="delete-modal-card">
                <div class="delete-modal-head">Delete Customer</div>
                <div class="delete-modal-body">
                    Are you sure you want to delete customer <strong>{{ $customerToDeleteName }}</strong>?
                    All customer related data will be deleted.
                </div>
                <div class="delete-modal-actions">
                    <button type="button" class="btn btn-default" wire:click="cancelDeleteModal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="confirmDeleteCustomer">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
