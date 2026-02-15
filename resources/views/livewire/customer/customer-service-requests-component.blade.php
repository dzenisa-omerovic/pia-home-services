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
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>My requests</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>My requests</li>
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
                                    My requests
                                </div>
                                <div class="panel-body">
                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Provider</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                                <th>Provider rating</th>
                                                <th>Your rating</th>
                                                <th>Complaint</th>
                                                <th>Review</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($requests as $request)
                                                @php
                                                    $pr = $providerReviews[$request->id] ?? null;
                                                    $cr = $customerReviews[$request->id] ?? null;
                                                    $cmp = $complaints[$request->id] ?? null;
                                                @endphp
                                                <tr>
                                                    <td>{{ $request->service ? $request->service->name : '-' }}</td>
                                                    <td>
                                                        {{ $request->serviceProvider && $request->serviceProvider->user ? $request->serviceProvider->user->name : '-' }}
                                                    </td>
                                                    <td>{{ $request->start_at }}</td>
                                                    <td>{{ $request->end_at }}</td>
                                                    <td>{{ $request->status }}</td>
                                                    <td>{{ $request->note }}</td>
                                                    <td>{{ $pr ? $pr->rating : '' }}</td>
                                                    <td>{{ $cr ? $cr->rating : '' }}</td>
                                                    <td>
                                                        @if($request->status === 'completed')
                                                            <a href="{{ route('customer.complaint', ['request_id' => $request->id]) }}"><i class="fa fa-flag fa-2x text-danger"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($request->status === 'completed')
                                                            <a href="{{ route('customer.review_provider', ['request_id' => $request->id]) }}"><i class="fa fa-star fa-2x text-warning"></i></a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
