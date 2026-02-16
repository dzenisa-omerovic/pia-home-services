<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block !important;
        }
        .latest-services .img-hover {
            height: 180px;
            overflow: hidden;
        }
        .latest-services .img-hover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .latest-services .info-gallery {
            display: flex;
            flex-direction: column;
            min-height: 220px;
        }
        .latest-services .info-gallery .content-btn {
            margin-top: auto;
        }
        .latest-services .price {
            display: flex;
            align-items: baseline;
            gap: 6px;
        }
        .latest-services .price span {
            position: relative;
            top: 2px;
        }
        .content_info .services-lines li .item-service-line {
            border-right: 0 !important;
        }
        .row {
            border-right: 0 !important;
        }
        .filter-header #sform {
            display: flex;
            width: 100%;
            max-width: 980px;
            margin: 0 auto;
        }
        .filter-header #sform input[type="text"] {
            flex: 1 1 auto;
        }
        .filter-header #sform input[type="submit"] {
            min-width: 160px;
            flex: 0 0 auto;
        }
        @media (max-width: 767px) {
            .filter-header #sform {
                flex-direction: column;
                gap: 10px;
            }
            .filter-header #sform input[type="submit"] {
                width: 100%;
            }
        }
        .white-section {
            background: #fff;
            border-top: 1px solid #e6e8ee;
            padding: 25px 0 35px;
        }
        .howit-grid,
        .badge-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 12px;
        }
        .card-box {
            background: #fff;
            border: 1px solid #e6e8ee;
            border-radius: 6px;
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            min-height: 120px;
        }
        .card-box .icon-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0b3b5b;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
        .card-box .mini-title {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 6px;
        }
        .badge-grid {
            grid-template-columns: repeat(3, 1fr);
            margin-top: 16px;
            margin-bottom: 24px;
        }
        .badge-card {
            background: #fff;
            border: 1px solid #e6e8ee;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        @media (max-width: 767px) {
            .howit-grid,
            .badge-grid {
                grid-template-columns: 1fr;
            }
        }
        .card-box {
            align-items: center;
            text-align: center;
        }
        #sponsors {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 14px;
            padding: 8px 0;
        }
        #sponsors li {
            width: 72px;
            height: 72px;
            flex: 0 0 72px;
        }
        #sponsors li a {
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #e8edf3;
            border-radius: 10px;
            background: #fff;
        }
        #sponsors li a img {
            width: 72px !important;
            height: 72px !important;
            max-width: 72px !important;
            max-height: 72px !important;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .content_info .services-lines li .item-service-line {
            min-height: 132px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .content_info .services-lines li .item-service-line i.fa {
            width: 56px !important;
            height: 56px !important;
            line-height: 56px !important;
            padding: 0 !important;
            margin: 0 auto 8px auto;
            display: block !important;
            overflow: hidden;
            font-size: 0 !important;
        }
        .content_info .services-lines li .item-service-line .icon-img {
            width: 56px !important;
            height: 56px !important;
            max-width: 56px !important;
            max-height: 56px !important;
            object-fit: cover;
            object-position: center;
            display: block;
            border-radius: 8px;
        }
        .popular-services-grid .hsgrids {
            display: flex;
        }
        .popular-services-grid .g-list {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }
        .popular-services-grid .info-gallery {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 250px;
        }
        .popular-services-grid .info-gallery h3 {
            line-height: 1.3;
            min-height: 2.6em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .popular-services-grid .info-gallery p {
            line-height: 1.4;
            min-height: 2.8em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

    </style>
    <section class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                @foreach ($slides as $slide)
                    <li data-transition="slidevertical" data-slotamount="1" data-masterspeed="1000"
                        data-saveperformance="off" data-title="Slide">
                        <img src="{{ asset('images/slider')}}/{{ $slide->image }}" alt="{{$slide->title}}" data-bgposition="center center"
                            data-kenburns="on" data-duration="6000" data-ease="Linear.easeNone" data-bgfit="130"
                            data-bgfitend="100" data-bgpositionend="right center">
                    </li>
                @endforeach
            </ul>
            <div class="tp-bannertimer"></div>
        </div>
        <div class="filter-title">
            <div class="title-header">
                <h2 style="color:#fff;">BOOK A SERVICE</h2>
                <p class="lead">Book a service at very affordable price </p>
            </div>
            <div class="filter-header">
                <form id="sform" action="{{route('searchService')}}" method="post">
                    @csrf                        
                    <input type="text" id="q" name="q" required="required" placeholder="What services do you want?"
                        class="input-large typeahead" autocomplete="off">
                    <input type="submit" name="submit" value="Search">
                </form>
            </div>
        </div>
    </section>
    <section class="content-central">
        <div class="content_info">
            <div>
                <div class="container">
                    <div class="row">
                        <div class="titles">
                            <h2>Highlighted <span>Services</span></h2>
                            <i class="fa fa-plane"></i>
                            <hr class="tall">
                        </div>
                    </div>
                    <div class="portfolioContainer latest-services" style="margin-top: -50px; margin-bottom: 56px;">
                        @forelse ($promotedServices as $service)
                        <div class="col-xs-6 col-sm-4 col-md-3 hsgrids"
                            style="padding-right: 5px;padding-left: 5px;">
                            <a class="g-list" href="{{route('home.service_details', ['service_slug' => $service->slug])}}">
                                <div class="img-hover">
                                    <img src="{{ asset('images/services/thumbnails') }}/{{ $service->thumbnail }}" alt="{{ $service->name }}"
                                        class="img-responsive">
                                </div>
                                <div class="info-gallery">
                                    <h3>{{ $service->name }}</h3>
                                    <hr class="separator">
                                    <p>{{ $service->tagline }}</p>
                                    <div class="content-btn">
                                        @auth
                                            <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="btn btn-primary">Book Now</a>
                                        @else
                                            <a href="{{ route('login', ['status' => 'customerLoginRequired']) }}" class="btn btn-primary">Book Now</a>
                                        @endauth
                                    </div>
                                    <div class="price"><b>From</b>${{ $service->price }}</div>
                                </div>
                            </a>
                        </div>
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info no-toast">No highlighted services at the moment.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="content_info content_resalt">
            <div class="container" style="margin-top: 40px;">
                <div class="row">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul id="sponsors" class="tooltip-hover">
                            @foreach ($scategories as $scategory)
                                <li data-toggle="tooltip" title="" data-original-title="{{ $scategory->name }}">
                                    <a href="{{route('home.services_by_category', ['category_slug' => $scategory->slug])}}">
                                        <img src="{{ asset('images/categories') }}/{{ $scategory->image }}" alt="{{ $scategory->name }}" loading="lazy">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="semiboxshadow text-center">
            <img src="{{ asset('assets/img/img-theme/shp.png') }}" class="img-responsive" alt="">
        </div>
        <div class="content_info">
            <div>
                <div class="container">
                    <div class="row">
                        <div class="titles">
                            <h2>Popularne <span>Usluge</span></h2>
                            <i class="fa fa-plane"></i>
                            <hr class="tall">
                        </div>
                    </div>
                    <div class="portfolioContainer latest-services popular-services-grid" style="margin-top: -50px; margin-bottom: 72px;">
                        @foreach ($popularServices as $service)
                        <div class="col-xs-6 col-sm-4 col-md-3 hsgrids"
                            style="padding-right: 5px;padding-left: 5px;">
                            <a class="g-list" href="{{route('home.service_details', ['service_slug' => $service->slug])}}">
                                <div class="img-hover">
                                    <img src="{{ asset('images/services/thumbnails') }}/{{ $service->thumbnail }}" alt="{{ $service->name }}"
                                        class="img-responsive">
                                </div>
                                <div class="info-gallery">
                                    <h3>{{ $service->name }}</h3>
                                    <hr class="separator">
                                    <p>{{ $service->tagline }}</p>
                                    <div class="content-btn">
                                        @auth
                                            <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="btn btn-primary">Book Now</a>
                                        @else
                                            <a href="{{ route('login', ['status' => 'customerLoginRequired']) }}" class="btn btn-primary">Book Now</a>
                                        @endauth
                                    </div>
                                    <div style="margin-top: 6px; font-size: 12px; color: #0b3b5b; font-weight: 700;">
                                        Score: {{ number_format((float) $service->score, 2, '.', '') }}
                                    </div>
                                    <div class="price"><b>From</b>${{ $service->price }}</div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="content_info">
            <div class="bg-dark color-white border-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="services-lines-info">
                                <h2>WELCOME TO DIVERSIFIED</h2>
                                <p class="lead">
                                    Book best services at one place.
                                    <span class="line"></span>
                                </p>

                                <p>Find a wide variety of home services.</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <ul class="services-lines">
                                @foreach ($fscategories as $fscategory)
                                <li>
                                    <a href="{{route('home.services_by_category', ['category_slug' => $fscategory->slug])}}">
                                        <div class="item-service-line">
                                            <i class="fa"><img class="icon-img"
                                                    src="{{ asset('images/categories') }}/{{ $fscategory->image }}"
                                                    alt="{{ $fscategory->name }}" loading="lazy"></i>
                                            <h5>{{ $fscategory->name }}</h5>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content_info">
            <div class="white-section">
                <div class="container">
                    <div class="row">
                        <div class="titles">
                            <h2>How It <span>Works</span></h2>
                            <i class="fa fa-plane"></i>
                            <hr class="tall">
                        </div>
                    </div>
                    <div class="howit-grid">
                        <div class="card-box">
                            <div class="icon-circle"><i class="fa fa-search"></i></div>
                            <div class="mini-title">Choose a service</div>
                            <div>Find the best service for your home.</div>
                        </div>
                        <div class="card-box">
                            <div class="icon-circle"><i class="fa fa-calendar"></i></div>
                            <div class="mini-title">Schedule a time</div>
                            <div>Pick an available time that fits you.</div>
                        </div>
                        <div class="card-box">
                            <div class="icon-circle"><i class="fa fa-check"></i></div>
                            <div class="mini-title">Get confirmation</div>
                            <div>The provider confirms and the job is booked.</div>
                        </div>
                    </div>

                    <div class="badge-grid">
                        <div class="badge-card"><i class="fa fa-shield"></i> Verified providers</div>
                        <div class="badge-card"><i class="fa fa-lock"></i> Secure booking</div>
                        <div class="badge-card"><i class="fa fa-headphones"></i> 24/7 support</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div>
            <div class="container">
                <div class="row">
                    <div class="titles">
                        <h2><span>Appliance</span>Services</h2>
                        <i class="fa fa-plane"></i>
                        <hr class="tall">
                    </div>
                </div>
            </div>
            <div id="boxes-carousel">
                @foreach ($aservices as $aservice)
                <div>
                    <a class="g-list" href="{{ route('home.service_details', ['service_slug' => $aservice->slug]) }}">
                        <div class="img-hover">
                            <img src="{{ asset('images/services/thumbnails') }}/{{ $aservice->thumbnail }}" alt="{{$aservice->name}}" class="img-responsive">
                        </div>

                        <div class="info-gallery">
                            <h3>{{$aservice->name}}</h3>
                            <hr class="separator">
                            <p>{{$aservice->tagline}}</p>
                            <div class="content-btn">
                                @auth
                                    <a href="{{ route('home.service_details', ['service_slug' => $aservice->slug]) }}" class="btn btn-primary">Book Now</a>
                                @else
                                    <a href="{{ route('login', ['status' => 'customerLoginRequired']) }}" class="btn btn-primary">Book Now</a>
                                @endauth
                            </div>
                            <div class="price"><span>&#36;</span><b>From</b>{{$aservice->price}}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div> --}}
    </section>
</div>


@push('scripts')

    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
        $('input.typeahead').typeahead({
            source: function(query, process){
                return $.get(path, {query:query}, function(data){
                    return process(data);
                });
            }
        });

    
    </script>

@endpush
