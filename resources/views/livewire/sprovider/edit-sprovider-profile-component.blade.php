<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Update Profile</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Update Profile</li>
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
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Update Profile
                                        </div>
                                        <div class="col-md-6 text-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(Session::has('message'))
                                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                            @endif
                                            <form class="form-horizontal" wire:submit.prevent="updateProfile">
                                                <div class="form-group">
                                                    <label for="newimage" class="control-label col-md-3">
                                                        Profile image:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="file" class="form-control-file" name="newimage"  wire:model="newimage"/>
                                                        @if($newimage)
                                                            <img src="{{ $newimage->temporaryUrl() }}" width="220"/>
                                                        @elseif($image)
                                                            <img src="{{ asset('images/sproviders') }}/{{ $image }}" width="220"/>
                                                        @else
                                                            <img src="{{ asset('images/sproviders/123.png') }}" width="220"/>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="about" class="control-label col-md-3">
                                                        About:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control" name="about" wire:model="about"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="control-label col-md-3">
                                                        City:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="city" wire:model="city"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="service_category_id" class="control-label col-md-3">
                                                        Service category:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="service_category_id" wire:model="service_category_id" wire:change="onServiceCategoryChanged($event.target.value)">
                                                            <option value="">-- Select category --</option>
                                                            <option value="other">Other (add new)</option>
                                                            @foreach ($scategories as $scategory)
                                                                <option value="{{ $scategory->id }}">{{ $scategory->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if($service_category_id == 'other')
                                                    <div class="form-group">
                                                        <label for="new_category_name" class="control-label col-md-3">
                                                            New category:
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="new_category_name" wire:model="new_category_name" placeholder="Type new category name"/>
                                                            @error('new_category_name') <p class="text-danger">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="text-right">
                                                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#changePasswordModalSprovider">
                                                            Change Password
                                                        </button>
                                                    @endif
                                                    <button type="submit" class="btn btn-success">Update profile</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                <div class="modal" id="changePasswordModalSprovider" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalSproviderLabel" data-backdrop="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="changePasswordModalSproviderLabel">Change Password</h4>
                                            </div>
                                            <div class="modal-body">
                                                @livewire('profile.update-password-form')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>
</div>
