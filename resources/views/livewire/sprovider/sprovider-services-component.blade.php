<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block !important;
        }
        .delete-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(11, 18, 27, 0.55);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .delete-modal {
            width: 92%;
            max-width: 460px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .delete-modal-head {
            padding: 16px 18px 10px;
            border-bottom: 1px solid #eef0f4;
        }
        .delete-modal-head h4 {
            margin: 0;
            font-weight: 700;
            color: #123e66;
        }
        .delete-modal-body {
            padding: 14px 18px;
            color: #3d4a58;
        }
        .delete-modal-actions {
            padding: 12px 18px 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .popular-services-wrap {
            margin: 12px 0 14px;
            padding: 12px;
            border: 1px solid #dce7f2;
            border-radius: 10px;
            background: #f8fbff;
        }
        .popular-services-title {
            font-weight: 700;
            color: #0b3b5b;
            margin-bottom: 10px;
        }
        .popular-service-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 4px 6px 4px 0;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid #cfe0ef;
            background: #fff;
            color: #123e66;
            font-size: 12px;
            font-weight: 600;
        }
        .popular-service-chip .score {
            background: #0b3b5b;
            color: #fff;
            border-radius: 999px;
            padding: 1px 8px;
            font-size: 11px;
        }
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>My services</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>My services</li>
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
                                    <div class="row heading-row">
                                        <div class="col-md-6 heading-title">
                                            My services
                                        </div>
                                        <div class="col-md-6 heading-actions">
                                            <a href="{{ route('sprovider.add_service') }}" class="btn btn-info">Add New</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    @endif

                                    @if(!$sprovider)
                                        <div class="alert alert-warning" role="alert">
                                            Service Provider profile is missing.
                                        </div>
                                    @else
                                        <div class="alert alert-info" role="alert">
                                            Free promotion credits: {{ (int) $sprovider->promotion_credits }}
                                        </div>
                                    @endif

                                    <table class="table rable-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Promotion</th>
                                                <th>Category</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($services as $service)
                                                <tr>
                                                    <td><img src="{{ asset('images/services/thumbnails') }}/{{ $service->thumbnail }}" height="60"/></td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>{{ $service->price }}</td>
                                                    <td>
                                                        @if($service->status)
                                                            Active
                                                        @else
                                                            Inactive
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($service->promoted_until && $service->promoted_until->isFuture())
                                                            Promoted until {{ $service->promoted_until->format('Y-m-d H:i') }}
                                                        @else
                                                            Not promoted
                                                        @endif
                                                    </td>
                                                    <td>{{ $service->category ? $service->category->name : '-' }}</td>
                                                    <td>{{ $service->created_at }}</td>
                                                    <td>
                                                        <a href="{{ route('sprovider.edit_service', ['service_slug' => $service->slug]) }}"><i class="fa fa-edit fa-2x text-info"></i></a>
                                                        <a href="#"
                                                        
                                                           title="Promote this service (uses 1 free promotion credit)"
                                                           wire:click.prevent="promoteService({{ $service->id }})"
                                                           style="margin-left: 10px;">
                                                            <i class="fa fa-bullhorn fa-2x text-primary"></i>
                                                        </a>
                                                        <a href="#" wire:click.prevent="openDeleteModal({{ $service->id }})" style="margin-left: 10px;"><i class="fa fa-times fa-2x text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8">No services yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $services->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($showDeleteModal)
        <div class="delete-modal-backdrop" wire:click="cancelDeleteModal">
            <div class="delete-modal" wire:click.stop>
                <div class="delete-modal-head">
                    <h4>Delete Service</h4>
                </div>
                <div class="delete-modal-body">
                    Are you sure you want to delete
                    <strong>{{ $serviceToDeleteName ?: 'this service' }}</strong>?
                    This action cannot be undone.
                </div>
                <div class="delete-modal-actions">
                    <button type="button" class="btn btn-default" wire:click="cancelDeleteModal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="confirmDeleteService">Delete Service</button>
                </div>
            </div>
        </div>
    @endif
</div>
