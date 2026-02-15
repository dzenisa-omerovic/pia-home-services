<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Review Provider</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Review Provider</li>
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
                                <div class="panel-heading">Leave a Review</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" wire:submit.prevent="submitReview">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Rating (1-5)</label>
                                            <div class="col-sm-9">
                                                <input type="number" min="1" max="5" class="form-control" wire:model="rating">
                                                @error('rating') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Comment</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="4" wire:model="comment"></textarea>
                                                @error('comment') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success pull-right">Submit Review</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
