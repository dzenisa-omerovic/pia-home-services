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
                                            <a href="{{ route('customer.profile') }}" class="btn btn-info">Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" roles="alert">{{ Session::get('message') }}</div>
                                    @endif
                                    <form class="form-horizontal" wire:submit.prevent="updateProfile">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="control-label col-sm-3">Name: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" wire:model="name"/>
                                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label col-sm-3">Email: </label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" wire:model="email"/>
                                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="control-label col-sm-3">Phone: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone" wire:model="phone"/>
                                                @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#changePasswordModalCustomer">
                                                    Change Password
                                                </button>
                                            @endif
                                            <button type="submit" class="btn btn-success">Update Profile</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                <div class="modal" id="changePasswordModalCustomer" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalCustomerLabel" data-backdrop="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="changePasswordModalCustomerLabel">Change Password</h4>
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
        </div>
    </section>
</div>
