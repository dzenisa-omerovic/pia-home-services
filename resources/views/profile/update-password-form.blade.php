<div class="change-password-root">
    @php
        $bag = $errors->getBag('updatePassword');
    @endphp

    @if ($bag->any())
        @foreach ($bag->all() as $message)
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @endforeach
    @endif

    <div
        x-data
        x-init="
            @this.on('saved', () => {
                if (window.toastr) { toastr.success('Saved.'); }
                const modal = document.querySelector('#changePasswordModalSprovider, #changePasswordModalCustomer');
                if (!modal) {
                    window.location.reload();
                    return;
                }

                if (window.jQuery) {
                    let reloaded = false;
                    const reloadOnce = () => {
                        if (reloaded) { return; }
                        reloaded = true;
                        window.location.reload();
                    };

                    window.jQuery(modal).one('hidden.bs.modal', reloadOnce);
                    window.jQuery(modal).modal('hide');
                    setTimeout(reloadOnce, 450);
                    return;
                }

                modal.classList.remove('in');
                modal.style.display = 'none';
                window.location.reload();
            });
            @this.on('password-update-failed', (...args) => {
                if (!window.toastr) { return; }
                const payload = args[0] || {};
                const messages = Array.isArray(payload) ? payload : (payload.messages || []);
                if (messages.length === 0) {
                    toastr.error('Password update failed.');
                    return;
                }
                messages.forEach((message) => toastr.error(message));
            });
        "
    ></div>

    <div class="change-password-form">
        <div class="change-password-header">
            <h4>Update Password</h4>
            <p>Ensure your account is using a long, random password to stay secure.</p>
        </div>

        <form class="form-horizontal change-password-body" wire:submit.prevent="updatePassword">
            <div class="form-group">
                <label for="current_password" class="control-label col-sm-4">Current Password</label>
                <div class="col-sm-8">
                    <input id="current_password" type="password" class="form-control" wire:model="state.current_password" autocomplete="current-password">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="control-label col-sm-4">New Password</label>
                <div class="col-sm-8">
                    <input id="password" type="password" class="form-control" wire:model="state.password" autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="control-label col-sm-4">Confirm Password</label>
                <div class="col-sm-8">
                    <input id="password_confirmation" type="password" class="form-control" wire:model="state.password_confirmation" autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
