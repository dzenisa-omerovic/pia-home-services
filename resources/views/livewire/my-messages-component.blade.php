<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>My Messages</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>My Messages</li>
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
                        <div class="col-md-10 col-md-offset-1 profile1">
                            <div class="panel panel-default">
                                <div class="panel-heading">My Messages</div>
                                <div class="panel-body">
                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>With</th>
                                                <th>Last message</th>
                                                <th>Updated</th>
                                                <th>Open</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($threads as $thread)
                                                <tr>
                                                    <td>{{ $thread->service_name }}</td>
                                                    <td>
                                                        @if($isCustomer)
                                                            {{ $thread->provider_name ?? 'Provider' }}
                                                        @else
                                                            {{ $thread->customer_name ?? 'Customer' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ \Illuminate\Support\Str::limit($thread->message, 60) }}</td>
                                                    <td>{{ $thread->created_at }}</td>
                                                    <td>
                                                        @if($isCustomer)
                                                            <a href="{{ route('service.chat', ['service_slug' => $thread->service_slug]) }}">
                                                                <i class="fa fa-comments fa-2x text-info"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('service.chat', ['service_slug' => $thread->service_slug, 'customer_id' => $thread->customer_id]) }}">
                                                                <i class="fa fa-comments fa-2x text-info"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">No messages yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
