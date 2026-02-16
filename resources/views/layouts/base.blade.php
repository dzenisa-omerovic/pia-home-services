<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home Services - Online Service Provider for your House Needs</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/chblue.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/theme-responsive.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/dtb/jquery.dataTables.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" media="screen">        
    <style>
        .footer-cats li,
        .footer-cats li a {
            font-size: 15px;
        }
        .contact_footer {
            font-size: 16px;
        }
        .footer-contact {
            text-align: right;
            border-left: 1px solid #ddd;
        }
        .footer-contact .contact_footer li {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
        }
        .footer-contact .contact_footer li a {
            text-align: right;
        }
        .footer-contact .social {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            padding-right: 0;
        }
        .footer-contact .social li {
            margin-right: 0;
            width: auto;
            min-width: 0;
        }
        .footer-contact .social li span {
            margin-right: 0;
        }
        .change-password-form {
            background: #fafafa;
            border: 1px solid #e6e6e6;
            border-radius: 6px;
            padding: 16px 18px;
        }
        .change-password-header h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        .change-password-header p {
            margin: 6px 0 12px;
            color: #777;
            font-size: 13px;
        }
        .change-password-form .form-group {
            margin-bottom: 12px;
        }
        .change-password-form .form-control {
            height: 38px;
            border-radius: 4px;
        }
        .change-password-form .form-control:focus {
            border-color: #46b8da;
            box-shadow: 0 0 0 2px rgba(70, 184, 218, 0.2);
        }
        .request-actions-cell {
            text-align: center;
            vertical-align: middle;
        }
        .request-actions {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .request-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border: 0;
            outline: 0;
            background: transparent;
            box-shadow: none;
            text-decoration: none;
        }
        .request-actions a:hover,
        .request-actions a:focus {
            text-decoration: none;
        }
        .request-actions i {
            line-height: 1;
        }
        .customer-profile-row {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
        }
        .customer-profile-photo {
            display: flex;
        }
        .customer-profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .customer-profile-details {
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .customer-profile-cta {
            position: absolute;
            right: 8px;
            bottom: 0;
        }
        
    </style>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.1.10.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/modernizr.js') }}"></script>
    @livewireStyles
</head>
<body>
    <div id="layout">
        <div class="info-head">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="visible-md visible-lg text-left">
                            <li><a href="tel:+3816123456"><i class="fa fa-phone"></i> +3816123456</a></li>
                            <li><a href="mailto:contact@homeservices.rs"><i class="fa fa-envelope"></i>
                                    contact@homeservices.rs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="visible-md visible-lg text-right">
                            <li><a href="#"><i class="fa fa-map-marker"></i> Tutin, Serbia</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <header id="header" class="header-v3">
            <nav class="flat-mega-menu">
                <label for="mobile-button"> <i class="fa fa-bars"></i></label>
                <input id="mobile-button" type="checkbox">

                <ul class="collapse">
                    <li class="title">
                        <a href="/"><img src="{{ asset('assets/img/logo1.png') }}"></a>
                    </li>
                    @auth
                        @if(Auth::user()->utype !== 'ADM')
                            <li>
                                <a href="{{route('home.service_categories')}}">Service categories</a>
                            </li>
                            <li>
                                <a href="{{ route('home.services') }}">Services</a>
                            </li>
                            <li>
                                <a href="{{ route('home.service_providers') }}">Service providers</a>
                            </li>
                        @endif
                        @if(Auth::user()->utype === 'CST')
                            <li>
                                <a href="{{ route('customer.requests') }}">My requests</a>
                            </li>
                        @endif
                        @if(Auth::user()->utype==='ADM')
                            <li class="login-form"> <a href="{{ route('admin.customers') }}" title="Admin">Admin</a>
                                <ul class="drop-down one-column hover-fade">
                                    <li><a href="{{ route('admin.service_categories') }}">Service categories</a></li>
                                    <li><a href="{{ route('admin.all_services') }}">All services</a></li>
                                    <li><a href="{{ route('admin.slider') }}">Manage slider</a></li>
                                    <li><a href="{{ route('admin.contacts') }}">All contacts</a></li>
                                    <li><a href="{{ route('admin.customers') }}">Customers</a></li>
                                    <li><a href="{{ route('admin.service_providers') }}">All service providers</a></li>
                                    <li><a href="{{ route('admin.security_settings') }}">Security settings</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                </ul>
                            </li>
                        @elseif(Auth::user()->utype==='SVP')
                            @php
                                $svProvider = \App\Models\ServiceProvider::where('user_id', Auth::id())->first();
                                $svApproval = $svProvider?->approval_status;
                                $svCredits = (int) ($svProvider?->promotion_credits ?? 0);
                            @endphp
                            <li>
                                <a href="{{ route('sprovider.services') }}" title="Free promotions">
                                    <i class="fa fa-bullhorn"></i> Free promotions: <span data-promotion-credits>{{ $svCredits }}</span>
                                </a>
                            </li>
                            <li class="login-form"> <a href="#" title="Account">{{ Auth::user()->name }}</a>
                                <ul class="drop-down one-column hover-fade">
                                    @if($svApproval === 'approved')
                                        <li><a href="{{ route('sprovider.services') }}">Promotion credits: <span data-promotion-credits>{{ $svCredits }}</span></a></li>
                                        <li><a href="{{ route('sprovider.profile') }}">Profile</a></li>
                                        <li><a href="{{ route('sprovider.services') }}">All services</a></li>
                                        <li><a href="{{ route('sprovider.add_service') }}">Add service</a></li>
                                        <li><a href="{{ route('sprovider.availability') }}">Availability</a></li>
                                        <li><a href="{{ route('sprovider.requests') }}">Service requests</a></li>
                                        <li><a href="{{ route('messages.index') }}">My messages</a></li>
                                        <li><a href="{{ route('sprovider.reviews') }}">My reviews</a></li>
                                        <li><a href="{{ route('sprovider.complaints') }}">Complaints</a></li>
                                    @else
                                        <li><a href="javascript:void(0)">Pending approval</a></li>
                                    @endif
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="login-form"> <a href="#" title="Register">{{ Auth::user()->name }}</a>
                                <ul class="drop-down one-column hover-fade">
                                    <li><a href="{{ route('customer.profile') }}">Profile</a></li>
                                    <li><a href="{{ route('customer.interests') }}">Moji interesi</a></li>
                                    <li><a href="{{ route('messages.index') }}">My Messages</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                        <li class="search-bar">
                        </li>
                    @else
                        @if(Route::has('register'))
                            <li class="login-form"><a href="{{ route('register') }}" title="Register">Register</a></li>
                        @endif
                        @if(Route::has('login'))
                            <li class="login-form"><a href="{{ route('login') }}" title="Login">Login</a></li>
                        @endif
                    @endif
                </ul>
            </nav>
        </header>
        {{ $slot }}
        <footer id="footer" class="footer-v1">
            @php
                use App\Models\ServiceCategory;

                $footerCategories = ServiceCategory::orderBy('name')->take(18)->get();
                $footerChunks = $footerCategories->chunk(6);
                $footerCol1 = $footerChunks->get(0, collect());
                $footerCol2 = $footerChunks->get(1, collect());
                $footerCol3 = $footerChunks->slice(2)->flatten(1);
            @endphp
            <div class="container">
                <div class="row visible-md visible-lg">
                    <div class="col-md-3 col-xs-6 col-sm-6">
                        <ul class="footer-cats">
                            @foreach ($footerCol1 as $cat)
                                <li><i class="fa fa-check"></i>
                                    <a href="{{ route('home.services_by_category', ['category_slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-3 col-xs-6 col-sm-6">
                        <ul class="footer-cats">
                            @foreach ($footerCol2 as $cat)
                                <li><i class="fa fa-check"></i>
                                    <a href="{{ route('home.services_by_category', ['category_slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-3 col-xs-6 col-sm-6">
                        <ul class="footer-cats">
                            @foreach ($footerCol3 as $cat)
                                <li><i class="fa fa-check"></i>
                                    <a href="{{ route('home.services_by_category', ['category_slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-3 col-xs-6 col-sm-6 footer-contact">
                        <h3>CONTACT US</h3>
                        <ul class="contact_footer">
                            <li class="location">
                                <i class="fa fa-map-marker"></i> <a href="#"> Tutin, Serbia</a>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i> <a
                                    href="mailto:contact@homeservices.rs">contact@homeservices.rs</a>
                            </li>
                            <li>
                                <i class="fa fa-headphones"></i> <a href="tel:+3816123456">+3816123456</a>
                            </li>
                        </ul>
                        <h3 style="margin-top: 10px">FOLLOW US</h3>
                        <ul class="social">
                            <li class="facebook"><span><i class="fa fa-facebook"></i></span><a href="#"></a></li>
                            <li class="twitter"><span><i class="fa fa-twitter"></i></span><a href="#"></a></li>
                            <li class="github"><span><i class="fa fa-instagram"></i></span><a href="#"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row visible-sm visible-xs">
                    <div class="col-md-6 footer-contact">
                        <h3 class="mlist-h">CONTACT US</h3>
                        <ul class="contact_footer mlist">
                            <li class="location">
                                <i class="fa fa-map-marker"></i> <a href="#"> Tutin, Serbia</a>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i> <a
                                    href="mailto:contact@surfsidemedia.in">contact@homeservices.rs</a>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i> <a href="tel:+3816123456">+3816123456</a>
                            </li>
                        </ul>
                        <ul class="social mlist-h">
                            <li class="facebook"><span><i class="fa fa-facebook"></i></span><a href="#"></a></li>
                            <li class="twitter"><span><i class="fa fa-twitter"></i></span><a href="#"></a></li>
                            <li class="github"><span><i class="fa fa-instagram"></i></span><a href="#"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-down">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="nav-footer">
                                <li><a href="{{route('home.contact')}}">Contact Us</a></li>
                                
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-xs-center crtext">&copy; 2026 Home Services. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>                
            </div>            
        </footer>
    </div>
    <script type="text/javascript" src="{{ asset('assets/js/nav/jquery.sticky.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/totop/jquery.ui.totop.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/accordion/accordion.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/maps/gmap3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/fancybox/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/carousel/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/filters/jquery.isotope.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/twitter/jquery.tweet.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/flickr/jflickrfeed.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/theme-options/theme-options.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/theme-options/jquery.cookies.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/bootstrap-slider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dtb/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dtb/jquery.table2excel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dtb/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/validation-rule.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap3-typeahead.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    <script type="text/javascript">
        function showAlertsAsToasts() {
            jQuery('.alert').each(function () {
                var $el = jQuery(this);
                if ($el.hasClass('no-toast')) {
                    return;
                }
                if (!$el.is(':visible')) {
                    return;
                }
                var msg = $el.text().trim();
                if (!msg) {
                    $el.remove();
                    return;
                }
                var type = 'info';
                if ($el.hasClass('alert-success')) type = 'success';
                else if ($el.hasClass('alert-danger')) type = 'error';
                else if ($el.hasClass('alert-warning')) type = 'warning';
                else if ($el.hasClass('alert-info')) type = 'info';
                toastr[type](msg);
                $el.remove();
            });
        }

        jQuery(document).ready(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 4000
            };
            @if(Session::has('toast'))
                toastr[{{ json_encode(Session::get('toast.type', 'info')) }}](
                    {{ json_encode(Session::get('toast.message', '')) }}
                );
            @endif
            showAlertsAsToasts();
        });

        document.addEventListener('livewire:load', function () {
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', function () {
                    showAlertsAsToasts();
                });
            }
        });

        document.addEventListener('livewire:initialized', function () {
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('commit', function () {
                    setTimeout(showAlertsAsToasts, 0);
                });
            }
        });

        document.addEventListener('livewire:initialized', function () {
            if (window.Livewire && Livewire.on) {
                Livewire.on('toast', function (data) {
                    var type = (data && data.type) ? data.type : 'info';
                    var message = (data && data.message) ? data.message : '';
                    if (message) {
                        toastr[type](message);
                    }
                });
                Livewire.on('app-redirect', function (data) {
                    var url = (data && data.url) ? data.url : null;
                    if (url) {
                        setTimeout(function () {
                            window.location.href = url;
                        }, 1200);
                    }
                });
                Livewire.on('promotion-credits-updated', function (data) {
                    var credits = (data && data.credits !== undefined) ? parseInt(data.credits, 10) : 0;
                    if (isNaN(credits)) {
                        credits = 0;
                    }
                    document.querySelectorAll('[data-promotion-credits]').forEach(function (el) {
                        el.textContent = String(credits);
                    });
                });
            }
        });

        var alertObserver = new MutationObserver(function () {
            showAlertsAsToasts();
        });
        alertObserver.observe(document.body, { childList: true, subtree: true });
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.tp-banner').show().revolution({
                dottedOverlay: "none",
                delay: 5000,
                startwidth: 1170,
                startheight: 480,
                minHeight: 250,
                navigationType: "none",
                navigationArrows: "solo",
                navigationStyle: "preview1"
            });
        });
    </script>
    @stack('scripts')
    @livewireScripts
</body>
</html>
