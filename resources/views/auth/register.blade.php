{{--<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
--}}
<x-base-layout>
    <style>
        .interest-dropdown {
            position: relative;
        }
        .interest-dropdown-toggle {
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .interest-dropdown-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #d8e0ea;
            border-radius: 6px;
            box-shadow: 0 10px 22px rgba(0,0,0,0.14);
            padding: 8px;
            max-height: 220px;
            overflow-y: auto;
            z-index: 20;
            display: none;
        }
        .interest-dropdown.open .interest-dropdown-menu {
            display: block;
        }
        .interest-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 2px;
            font-size: 13px;
            margin: 0;
            font-weight: 400;
        }
    </style>
    <div class="section-title-01 honmob">
            <div class="bg_parallax image_02_parallax"></div>
            <div class="opacy_bg_02">
                <div class="container">
                    <h1>Registration</h1>
                    <div class="crumbs">
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li>/</li>
                            <li>Registration</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="content-central">
            <div class="semiboxshadow text-center">
            </div>
            <div class="content_info">
                <div class="paddings-mini">
                    <div class="container">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3 profile1" style="padding-bottom:40px;">
                            <div class="thinborder-ontop">
                                <h3>User Info</h3>
                                <x-validation-errors class="mb-4" />
                                <form id="userregisterationform" method="POST" action="{{ route('register') }}">    
                                    @csrf                                
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" value="" required="" autofocus="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm"
                                            class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                                        <div class="col-md-6">
                                            <input id="phone" type="text" class="form-control" name="phone" value="" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="registeras" class="col-md-4 col-form-label text-md-right">Register as</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="registeras" id="registeras">
                                                <option value="CST">Customer</option>
                                                <option value="SVP">Service Provider</option>
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $regCategories = \App\Models\ServiceCategory::orderBy('name')->get();
                                    @endphp
                                    <div class="form-group row" id="interestsRow">
                                        <label for="interests" class="col-md-4 col-form-label text-md-right">Interests</label>
                                        <div class="col-md-6">
                                            <div class="interest-dropdown" id="interestDropdown">
                                                <button type="button" class="form-control interest-dropdown-toggle" id="interestDropdownToggle" aria-expanded="false">
                                                    <span id="interestDropdownLabel">Select interests</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <div class="interest-dropdown-menu" id="interestDropdownMenu">
                                                    @foreach($regCategories as $cat)
                                                        <label class="interest-option">
                                                            <input type="checkbox" name="interests[]" value="{{ $cat->id }}" class="interest-checkbox">
                                                            <span>{{ $cat->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <small class="text-muted">You can select multiple interests.</small>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-10">
                                            <span style="font-size: 14px;">If you have already registered <a
                                                    href="{{route('login')}}" title="Login">click here</a> to login</span>
                                            <button type="submit" class="btn btn-primary pull-right">Register</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="section-twitter">
                <i class="fa fa-twitter icon-big"></i>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>             
        </section>
        <script>
            (function () {
                var roleSelect = document.getElementById('registeras');
                var interestsRow = document.getElementById('interestsRow');
                var dropdown = document.getElementById('interestDropdown');
                var toggle = document.getElementById('interestDropdownToggle');
                var label = document.getElementById('interestDropdownLabel');
                var checkboxes = document.querySelectorAll('.interest-checkbox');

                function toggleInterests() {
                    if (!roleSelect || !interestsRow) return;
                    interestsRow.style.display = roleSelect.value === 'CST' ? 'flex' : 'none';
                }

                function refreshInterestLabel() {
                    if (!label) return;
                    var selected = Array.from(checkboxes).filter(function (cb) { return cb.checked; });
                    if (selected.length === 0) {
                        label.textContent = 'Select interests';
                        return;
                    }
                    if (selected.length === 1) {
                        var text = selected[0].parentElement ? selected[0].parentElement.innerText : '1 selected';
                        label.textContent = text.trim();
                        return;
                    }
                    label.textContent = selected.length + ' selected';
                }

                function closeDropdown() {
                    if (!dropdown || !toggle) return;
                    dropdown.classList.remove('open');
                    toggle.setAttribute('aria-expanded', 'false');
                }

                function openDropdown() {
                    if (!dropdown || !toggle) return;
                    dropdown.classList.add('open');
                    toggle.setAttribute('aria-expanded', 'true');
                }

                if (roleSelect) {
                    roleSelect.addEventListener('change', toggleInterests);
                    toggleInterests();
                }
                if (toggle) {
                    toggle.addEventListener('click', function (event) {
                        event.preventDefault();
                        if (dropdown.classList.contains('open')) {
                            closeDropdown();
                        } else {
                            openDropdown();
                        }
                    });
                }
                checkboxes.forEach(function (cb) {
                    cb.addEventListener('change', refreshInterestLabel);
                });
                document.addEventListener('click', function (event) {
                    if (!dropdown) return;
                    if (!dropdown.contains(event.target)) {
                        closeDropdown();
                    }
                });
                refreshInterestLabel();
            })();
        </script>
</x-base-layout>
