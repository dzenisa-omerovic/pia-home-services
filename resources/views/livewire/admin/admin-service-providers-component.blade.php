<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block !important;
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
                <h1>Service providers</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Service providers</li>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            All service providers
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    @endif
                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>City</th>
                                                <th>Service Category</th>
                                                <th>Service Locations</th>
                                                <th>Status</th>
                                                <th>Approval</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sproviders as $sprovider)
                                                <tr>
                                                    <td><img src="{{ asset('images/sproviders') }}/{{ $sprovider->image }}" height="60"/></td>
                                                    <td>{{ $sprovider->user->name }}</td>
                                                    <td>{{ $sprovider->user->email }}</td>
                                                    <td>{{ $sprovider->user->phone }}</td>
                                                    <td>{{ $sprovider->city }}</td>
                                                    <td>{{ $sprovider->category ? $sprovider->category->name : '—' }}</td>

                                                    <td>{{ $sprovider->service_locations }}</td>
                                                    <td>{{ ucfirst($sprovider->approval_status ?? 'pending') }}</td>
                                                    <td>
                                                        @if(($sprovider->approval_status ?? 'pending') === 'pending')
                                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                                <a href="#" wire:click.prevent="approve({{ $sprovider->id }})" class="btn btn-xs btn-success" style="min-width: 78px; text-align: center;">Approve</a>
                                                                <a href="#" wire:click.prevent="reject({{ $sprovider->id }})" class="btn btn-xs btn-danger" style="min-width: 78px; text-align: center;">Reject</a>
                                                            </div>
                                                        @elseif($sprovider->approval_status === 'approved')
                                                            <span class="text-success">Approved</span>
                                                        @else
                                                            <span class="text-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="#" wire:click.prevent="openDeleteModal({{ $sprovider->id }})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="admin-pagination">
                                        <div class="admin-pager">
                                            <button type="button" class="btn btn-default" wire:click="previousPage" @if($sproviders->onFirstPage()) disabled @endif aria-label="Previous page">
                                                <i class="fa fa-angle-left"></i>
                                            </button>
                                            @for($page = 1; $page <= max($sproviders->lastPage(), 1); $page++)
                                                <button
                                                    type="button"
                                                    class="btn btn-default page-btn @if($sproviders->currentPage() === $page) active @endif"
                                                    wire:click="gotoPage({{ $page }})"
                                                    aria-label="Page {{ $page }}">
                                                    {{ $page }}
                                                </button>
                                            @endfor
                                            <button type="button" class="btn btn-default" wire:click="nextPage" @if(!$sproviders->hasMorePages()) disabled @endif aria-label="Next page">
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
                <div class="delete-modal-head">Delete Service Provider</div>
                <div class="delete-modal-body">
                    Are you sure you want to delete service provider <strong>{{ $providerToDeleteName }}</strong>?
                    All related services and records will be deleted.
                </div>
                <div class="delete-modal-actions">
                    <button type="button" class="btn btn-default" wire:click="cancelDeleteModal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="confirmDeleteProvider">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>

