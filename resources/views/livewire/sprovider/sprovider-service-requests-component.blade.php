<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block !important;
        }
        .requests-pagination {
            display: flex;
            justify-content: center;
            margin: 14px 0 6px;
            clear: both;
            width: 100%;
        }
        .requests-pager {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f7f8fb;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.10);
        }
        .requests-pager .btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #0b3b5b;
            font-weight: 600;
        }
        .requests-pager .btn[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .requests-pager .btn:hover:not([disabled]) {
            background: #eaf0f6;
        }
        .requests-pager .btn.page-btn.active,
        .requests-pager .btn.page-btn.active:hover,
        .requests-pager .btn.page-btn.active:focus {
            background: #0b3b5b;
            color: #fff;
            border: 0;
        }
        .request-actions a.is-loading {
            pointer-events: none;
            opacity: 0.65;
        }
        .overlap-modal {
            position: fixed;
            inset: 0;
            z-index: 20000;
            background: rgba(0, 0, 0, 0.5);
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .overlap-modal .modal-dialog {
            width: 100%;
            max-width: 560px;
            margin: 0;
        }
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Service Requests</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Service Requests</li>
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
                                    Service Requests
                                </div>
                                <div class="panel-body">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    @endif
                                    @if(!$sprovider)
                                        <div class="alert alert-warning" role="alert">
                                            Service Provider profile is missing.
                                        </div>
                                    @endif
                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Customer</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                                <th>Review</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($requests as $request)
                                                <tr>
                                                    <td>{{ $request->service ? $request->service->name : '-' }}</td>
                                                    <td>{{ $request->customer ? $request->customer->name : '-' }}</td>
                                                    <td>{{ $request->customer ? $request->customer->email : '-' }}</td>
                                                    <td>{{ $request->customer ? $request->customer->phone : '-' }}</td>
                                                    <td>{{ $request->start_at }}</td>
                                                    <td>{{ $request->end_at }}</td>
                                                    <td>{{ $request->status }}</td>
                                                    <td>{{ $request->note }}</td>
                                                    <td>{{ $request->created_at }}</td>
                                                    <td class="request-actions-cell">
                                                        <div class="request-actions">
                                                        @if($request->status === 'pending')
                                                            <a href="#"
                                                               wire:click.prevent="acceptRequest({{ $request->id }})"
                                                               wire:loading.class="is-loading"
                                                               wire:target="acceptRequest({{ $request->id }})"
                                                               title="Accept request">
                                                                <span wire:loading.remove wire:target="acceptRequest({{ $request->id }})">
                                                                    <i class="fa fa-check fa-2x text-success"></i>
                                                                </span>
                                                                <span wire:loading.inline wire:target="acceptRequest({{ $request->id }})">
                                                                    <i class="fa fa-spinner fa-spin fa-2x text-info"></i>
                                                                </span>
                                                            </a>
                                                            <a href="#"
                                                               wire:click.prevent="rejectRequest({{ $request->id }})"
                                                               wire:loading.class="is-loading"
                                                               wire:target="rejectRequest({{ $request->id }})"
                                                               title="Reject request">
                                                                <span wire:loading.remove wire:target="rejectRequest({{ $request->id }})">
                                                                    <i class="fa fa-times fa-2x text-danger"></i>
                                                                </span>
                                                                <span wire:loading.inline wire:target="rejectRequest({{ $request->id }})">
                                                                    <i class="fa fa-spinner fa-spin fa-2x text-info"></i>
                                                                </span>
                                                            </a>
                                                        @elseif($request->status === 'accepted')
                                                            <a href="#"
                                                               wire:click.prevent="completeRequest({{ $request->id }})"
                                                               wire:loading.class="is-loading"
                                                               wire:target="completeRequest({{ $request->id }})"
                                                               title="Mark Completed">
                                                                <span wire:loading.remove wire:target="completeRequest({{ $request->id }})">
                                                                    <i class="fa fa-flag fa-2x text-success"></i>
                                                                </span>
                                                                <span wire:loading.inline wire:target="completeRequest({{ $request->id }})">
                                                                    <i class="fa fa-spinner fa-spin fa-2x text-info"></i>
                                                                </span>
                                                            </a>
                                                        @else
                                                            
                                                        @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($request->status === 'completed')
                                                            <a href="{{ route('sprovider.review_customer', ['request_id' => $request->id]) }}"><i class="fa fa-star fa-2x text-warning"></i></a>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11">No requests yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="requests-pagination">
                                        <div class="requests-pager">
                                            <button type="button" class="btn btn-default" wire:click="previousPage" @if($requests->onFirstPage()) disabled @endif aria-label="Previous page">
                                                <i class="fa fa-angle-left"></i>
                                            </button>
                                            @for($page = 1; $page <= max($requests->lastPage(), 1); $page++)
                                                <button
                                                    type="button"
                                                    class="btn btn-default page-btn @if($requests->currentPage() === $page) active @endif"
                                                    wire:click="gotoPage({{ $page }})"
                                                    aria-label="Page {{ $page }}">
                                                    {{ $page }}
                                                </button>
                                            @endfor
                                            <button type="button" class="btn btn-default" wire:click="nextPage" @if(!$requests->hasMorePages()) disabled @endif aria-label="Next page">
                                                <i class="fa fa-angle-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                    @if($showOverlapConfirmModal)
                                        <div class="modal fade in overlap-modal" style="display:block;" tabindex="-1" role="dialog" aria-modal="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Overlapping Requests Found</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            There are {{ $pendingOverlapCount }} pending request(s) that overlap with this time period.
                                                            If you continue, those pending overlaps will be rejected automatically.
                                                        </p>
                                                    </div>
                                                     <div class="modal-footer">
                                                         <button type="button" class="btn btn-default" wire:click="cancelOverlapConfirmation">Cancel</button>
                                                         <button type="button"
                                                                 class="btn btn-danger"
                                                                 wire:click="confirmAcceptWithOverlapRejection"
                                                                 wire:loading.attr="disabled"
                                                                 wire:target="confirmAcceptWithOverlapRejection">
                                                             <span wire:loading.remove wire:target="confirmAcceptWithOverlapRejection">
                                                                 Yes, accept and reject overlaps
                                                             </span>
                                                             <span wire:loading.inline wire:target="confirmAcceptWithOverlapRejection">
                                                                 <i class="fa fa-spinner fa-spin"></i> Processing...
                                                             </span>
                                                         </button>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
