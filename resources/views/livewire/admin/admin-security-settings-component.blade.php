<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Security Settings</div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                        @endif

                        <form wire:submit.prevent="save">
                            <div class="form-group">
                                <label>Remember last N passwords</label>
                                <input type="number" class="form-control" min="1" max="50" wire:model="password_history_count">
                                <small class="text-muted">Users cannot reuse any of their last N passwords (including current).</small>
                                @error('password_history_count') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
