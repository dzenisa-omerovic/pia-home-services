<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Complaint Reply</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Complaint Reply</li>
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
                                <div class="panel-heading">Reply to Complaint</div>
                                <div class="panel-body">
                                    @if($complaint->status === 'closed')
                                        <div class="alert alert-info no-toast" role="alert">
                                            Complaint is closed.
                                        </div>
                                    @else
                                        <p><b>Title:</b> {{ $complaint->title }}</p>
                                        <p><b>Description:</b> {{ $complaint->description }}</p>
                                        <form class="form-horizontal" wire:submit.prevent="submitResponse">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">Response</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="4" wire:model="response"></textarea>
                                                    @error('response') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success pull-right">Close Complaint</button>
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
