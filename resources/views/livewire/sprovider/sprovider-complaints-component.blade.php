<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Complaints</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Complaints</li>
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
                                <div class="panel-heading">Complaints</div>
                                <div class="panel-body">
                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Response</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($complaints as $complaint)
                                                <tr>
                                                    <td>{{ $complaint->customer ? $complaint->customer->name : '-' }}</td>
                                                    <td>{{ $complaint->title }}</td>
                                                    <td>{{ $complaint->description }}</td>
                                                    <td>{{ $complaint->response }}</td>
                                                    <td>{{ $complaint->status }}</td>
                                                    <td>{{ $complaint->created_at }}</td>
                                                    <td>
                                                        <a href="{{ route('sprovider.complaint_reply', ['complaint_id' => $complaint->id]) }}"><i class="fa fa-reply fa-2x text-info"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">No complaints.</td>
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
