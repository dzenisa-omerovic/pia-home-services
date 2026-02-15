<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block !important;
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
                <h1>All Slides</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>All Slides</li>
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
                                            All Slides
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('admin.add_slide') }}" class="btn btn-info pull-right">Add New</a>
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
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($slides as $slide)
                                                <tr>
                                                    <td><img src="{{ asset('images/slider') }}/{{ $slide->image }}" height="60"/></td>
                                                    <td>{{ $slide->title }}</td>
                                                    <td>
                                                        @if($slide->status)
                                                            Active
                                                        @else
                                                            Inactive
                                                        @endif
                                                    </td>
                                                    <td>{{ $slide->created_at }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.edit_slide', ['slide_id' => $slide->id]) }}"><i class="fa fa-edit fa-2x text-info"></i></a>
                                                        <a href="#" wire:click.prevent="openDeleteModal({{ $slide->id }})" style="margin-left: 10px;"><i class="fa fa-times fa-2x text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $slides->links() }}
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
                <div class="delete-modal-head">Delete Slide</div>
                <div class="delete-modal-body">
                    Are you sure you want to delete slide <strong>{{ $slideToDeleteTitle }}</strong>?
                </div>
                <div class="delete-modal-actions">
                    <button type="button" class="btn btn-default" wire:click="cancelDeleteModal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="confirmDeleteSlide">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
