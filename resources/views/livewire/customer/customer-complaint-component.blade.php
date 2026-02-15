<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Complaint</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Complaint</li>
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
                        <div class="col-md-8 col-md-offset-2 profile1">
                            <div class="panel panel-default">
                                <div class="panel-heading">Submit Complaint</div>
                                <div class="panel-body">
                                    @if($existing)
                                        @if($existing->response)
                                            <div class="alert alert-success no-toast" role="alert">
                                                Provider response: {{ $existing->response }}
                                            </div>
                                        @else
                                            <div class="alert alert-info no-toast" role="alert">
                                                Complaint submitted. Please wait for provider response.
                                            </div>
                                        @endif
                                    @else
                                        <form class="form-horizontal" wire:submit.prevent="submitComplaint">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" wire:model="title">
                                                    @error('title') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="4" wire:model="description"></textarea>
                                                    @error('description') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-danger pull-right">Submit</button>
                                        </form>
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
