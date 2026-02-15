<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_01_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Provider Details</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Provider Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="content-central">
        <div class="container">
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-8">
                    <div class="card" style="border: 1px solid #e6e8ee; border-radius: 6px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: #f2f4f7; flex: 0 0 80px;">
                                @if($provider->image)
                                    <img src="{{ asset('images/sproviders') }}/{{ $provider->image }}" alt="{{ $provider->user?->name ?? 'Provider' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                                        <i class="fa fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 style="margin: 0;">{{ $provider->user?->name ?? 'Service Provider' }}</h3>
                                <div style="display: flex; gap: 16px; margin-top: 6px; color: #6b7280;">
                                    <div>
                                        <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Category</div>
                                        <div style="font-weight: 600; color: #243245;">{{ $provider->category?->name ?? 'General' }}</div>
                                    </div>
                                    <div>
                                        <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">City</div>
                                        <div style="font-weight: 600; color: #243245;">{{ $provider->city ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 16px; color: #4b5563;">
                            {{ $provider->about ?? 'No additional information provided.' }}
                        </div>
                    </div>
                    <div class="card provider-services-preview" style="border: 1px solid #e6e8ee; border-radius: 6px; padding: 18px 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-top: 16px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px;">
                            <h4 style="margin: 0;">Services</h4>
                        </div>
                        @php $latestServices = $provider->services->sortByDesc('created_at')->take(2); @endphp
                        @if($latestServices->count() > 0)
                            <div class="row latest-services" style="margin: 0;">
                                @foreach($latestServices as $service)
                                    <div class="col-xs-12 col-sm-6 col-md-6 hsgrids" style="padding-right: 5px; padding-left: 5px;">
                                        <a class="g-list" href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}">
                                            <div class="img-hover">
                                                <img src="{{ asset('images/services/thumbnails') }}/{{ $service->thumbnail }}" alt="{{ $service->name }}" class="img-responsive">
                                            </div>
                                            <div class="info-gallery provider-card-body" style="padding: 14px 16px;">
                                                <h3>{{ $service->name }}</h3>
                                                <hr class="separator">
                                                <p>{{ $service->tagline }}</p>
                                                <div class="content-btn provider-card-cta">
                                                    <a href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}" class="btn btn-primary">Detalji</a>
                                                </div>
                                                <div class="price"><b>From</b>${{ $service->price }}</div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div style="margin-top: 14px; text-align: center;">
                                <a href="{{ route('home.service_provider_services', ['provider_id' => $provider->id]) }}" class="btn btn-info">Vidi sve servise</a>
                            </div>
                        @else
                            <div style="color: #6b7280;">No services listed.</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card rating-card" style="border: 1px solid #e6e8ee; border-radius: 6px; padding: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-top: 0;">
                        <h4>Ratings</h4>
                        <div class="rating-summary">
                            <div class="rating-box">
                                <div class="rating-label">Average rating</div>
                                <div class="rating-value">{{ number_format($avgRating, 2) }}</div>
                            </div>
                        </div>
                        <div class="rating-bars">
                            @foreach([5,4,3,2,1] as $star)
                                @php
                                    $count = $ratingCounts[$star] ?? 0;
                                    $total = array_sum($ratingCounts);
                                    $percent = $total > 0 ? round(($count / $total) * 100) : 0;
                                @endphp
                                <div class="rating-row">
                                    <div class="rating-star">{{ $star }} stars</div>
                                    <div class="rating-track">
                                        <div class="rating-fill" style="width: {{ $percent }}%;"></div>
                                    </div>
                                    <div class="rating-count">{{ $count }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
