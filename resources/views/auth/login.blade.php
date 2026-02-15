{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
<x-base-layout>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Login</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Login</li>
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
                        <div class="col-xs-12 col-sm-3 col-md-3 profile1">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 profile1" style="min-height: 300px;">
                            <div class="thinborder-ontop">
                                <h3>Login Info</h3>
                                @php
                                    $statusMessages = [
                                        'required' => 'Morate biti ulogovani da biste nastavili.',
                                        'loginRequired' => 'Morate biti ulogovani da biste nastavili.',
                                        'contactLoginRequired' => 'Morate biti ulogovani da biste pristupili Contact Us stranici.',
                                        'loginRequiredProvider' => 'Morate biti ulogovani da biste videli detalje provajdera.',
                                        'loginRequiredService' => 'Morate biti ulogovani da biste videli servis.',
                                        'loginRequiredCategory' => 'Morate biti ulogovani da biste videli servise ove kategorije.',
                                        'customerLoginRequired' => 'Morate biti ulogovani kao korisnik da biste rezervisali servis.',
                                        'providerApprovalPending' => 'Registracija servis provajdera je na cekanju. Sacekajte odobrenje administratora.',
                                        'providerRejected' => 'Vasa registracija servis provajdera je odbijena. Kontaktirajte administratora.'
                                    ];
                                    $status = request('status');
                                    $statusToastMessage = ($status && isset($statusMessages[$status])) ? $statusMessages[$status] : null;
                                @endphp
                                @if($statusToastMessage)
                                    @push('scripts')
                                        <script type="text/javascript">
                                            (function showStatusToast() {
                                                if (window.toastr) {
                                                    toastr.warning(@json($statusToastMessage));
                                                    return;
                                                }
                                                setTimeout(showStatusToast, 100);
                                            })();
                                        </script>
                                    @endpush
                                @endif
                                @if(Session::has('message'))
                                    <div class="alert alert-warning" role="alert">{{ Session::get('message') }}</div>
                                @endif
                                <x-validation-errors class="mb-4" />
                                <form id="userloginform" method="POST" action="{{ route('login') }}">  
                                    @csrf                                      
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="" required="" autofocus="">
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
                                        <div class="col-md-10">
                                            <button type="submit" class="btn btn-primary pull-right">Login</button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-10">
                                            <a class="" href="{{route('password.request')}}">Forgot Your Password?</a>
                                        </div>
                                    </div>
                                </form>
                            </div>                                
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 profile1">
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
</x-base-layout>
