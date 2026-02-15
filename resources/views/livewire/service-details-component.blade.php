<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_01_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>{{$service->name}}</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>{{$service->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="content-central">
        <div class="semiboxshadow text-center">
            <img src="img/img-theme/shp.png" class="img-responsive" alt="">
        </div>
        <div class="content_info">
            <div class="paddings-mini">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 single-blog">
                            <div class="post-item">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="post-header">
                                            <div class="post-format-icon post-format-standard"
                                                style="margin-top: -10px;">
                                                <i class="fa fa-image"></i>
                                            </div>
                                            <div class="post-info-wrap">
                                                <h2 class="post-title"><a href="#" title="Post Format: Standard"
                                                        rel="bookmark">{{$service->name}}: {{ $service->category->name }}</a></h2>
                                                <div class="post-meta" style="height: 10px;">
                                                </div>
                                                @auth
                                                    @if(auth()->user()->utype === 'CST')
                                                        <div style="margin-top: 6px; color: #666; font-size: 13px;">
                                                            Owner: <strong>{{ $service->serviceProvider?->user?->name ?? '—' }}</strong>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="single-carousel">
                                            <div class="img-hover">
                                                <img src="{{asset('images/services')}}/{{ $service->image }}" alt="{{ $service->name }}"
                                                    class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="post-content">
                                            <h3>{{$service->name}}</h3>
                                            <p>{{ $service->description }}</p>
                                            <h4>Inclusion</h4>
                                            <ul class="list-styles">
                                                @foreach (explode("|", $service->inclusion) as $inclusion)
                                                    <li><i class="fa fa-plus"></i>{{ $inclusion }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>Exclusion</h4>
                                            <ul class="list-styles">
                                                @foreach (explode("|", $service->exclusion) as $exclusion)
                                                    <li><i class="fa fa-minus"></i>{{ $exclusion }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <aside class="widget" style="margin-top: 18px;">
                                <div class="panel panel-default">
                                <div class="panel-heading">Booking Details</div>
                                <div class="panel-body">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    @endif
                                    <table class="table">
                                        <tr>
                                            <td style="border-top: none;">Price</td>
                                            <td style="border-top: none;"><span>&#36;</span> {{$service->price}}</td>
                                            </tr>
                                            <tr>
                                                <td>Quntity</td>
                                                <td>1</td>
                                            </tr>
                                            @php
                                                $total = $service->price;
                                            @endphp
                                            @if($service->discount)
                                                @if($service->discount_type == 'fixed')
                                                    <tr>
                                                        <td>Discount</td>
                                                        <td>${{ $service->discount }}</td>
                                                    </tr>
                                                    @php
                                                        $total = $total - $service->discount;
                                                    @endphp
                                                @elseif($service->discount_type == 'percent')
                                                    <tr>
                                                        <td>Discount</td>
                                                        <td>{{ $service->discount }}%</td>
                                                        @php
                                                            $total = $total - ($total * $service->discount / 100);
                                                        @endphp
                                                    </tr>
                                                    
                                                @endif
                                            @endif
                                            <tr>
                                                <td>Total</td>
                                                <td><span>&#36;</span> {{$total}}</td>
                                            </tr>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    @auth
                                        @if(auth()->user()->utype === 'SVP' && $service->serviceProvider && $service->serviceProvider->user_id === auth()->id())
                                            <a href="{{ route('sprovider.edit_service', ['service_slug' => $service->slug]) }}" class="btn btn-primary">Uredi servis</a>
                                        @elseif(auth()->user()->utype !== 'SVP')
                                            <form wire:submit.prevent="bookService">
                                                <div class="form-group" style="margin-bottom: 10px;">
                                                    <label>Choose Date</label>
                                                    <div class="calendar-grid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px;">
                                                        @foreach($calendar_days as $day)
                                                            <button
                                                                type="button"
                                                                wire:click="$set('date','{{ $day['date'] }}')"
                                                                class="btn btn-xs {{ $day['available'] ? 'btn-success' : 'btn-default' }}"
                                                                style="padding: 6px 4px; {{ !$day['available'] ? 'opacity: .45; cursor: not-allowed;' : '' }}"
                                                                @if(!$day['available']) disabled @endif
                                                            >
                                                                <div style="font-size: 11px; line-height: 1;">{{ $day['weekday'] }}</div>
                                                                <div style="font-size: 12px; line-height: 1.2;">{{ $day['label'] }}</div>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                    @if($date)
                                                        <div style="margin-top: 6px; font-size: 12px;">
                                                            Selected: <strong>{{ $date }}</strong>
                                                        </div>
                                                    @endif
                                                    @error('date') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group" style="margin-bottom: 10px;">
                                                    <label>Start Time</label>
                                                    <select class="form-control" wire:model="start_time" wire:change="onStartTimeChange" @if(!$date || count($available_start_times) === 0) disabled @endif>
                                                        <option value="">Select start time</option>
                                                        @foreach($available_start_times as $t)
                                                            <option value="{{ $t }}">{{ $t }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('start_time') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group" style="margin-bottom: 10px;">
                                                    <label>End Time</label>
                                                    <select class="form-control" wire:model="end_time" @if(!$start_time || count($available_end_times) === 0) disabled @endif>
                                                        <option value="">Select end time</option>
                                                        @foreach($available_end_times as $t)
                                                            <option value="{{ $t }}">{{ $t }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('end_time') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group" style="margin-bottom: 10px;">
                                                    <textarea class="form-control" rows="3" placeholder="Note (optional)" wire:model="note"></textarea>
                                                    @error('note') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                                    <input type="submit" class="btn btn-primary" value="Book Now">
                                                    <a href="{{ route('service.chat', ['service_slug' => $service->slug]) }}" class="btn btn-primary">Send message</a>
                                                </div>
                                            </form>
                                        @endif
                                    @else
                                        <form wire:submit.prevent="bookService">
                                            <div class="form-group" style="margin-bottom: 10px;">
                                                <label>Choose Date</label>
                                                <div class="calendar-grid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px;">
                                                    @foreach($calendar_days as $day)
                                                        <button
                                                            type="button"
                                                            wire:click="$set('date','{{ $day['date'] }}')"
                                                            class="btn btn-xs {{ $day['available'] ? 'btn-success' : 'btn-default' }}"
                                                            style="padding: 6px 4px; {{ !$day['available'] ? 'opacity: .45; cursor: not-allowed;' : '' }}"
                                                            @if(!$day['available']) disabled @endif
                                                        >
                                                            <div style="font-size: 11px; line-height: 1;">{{ $day['weekday'] }}</div>
                                                            <div style="font-size: 12px; line-height: 1.2;">{{ $day['label'] }}</div>
                                                        </button>
                                                    @endforeach
                                                </div>
                                                @if($date)
                                                    <div style="margin-top: 6px; font-size: 12px;">
                                                        Selected: <strong>{{ $date }}</strong>
                                                    </div>
                                                @endif
                                                @error('date') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="form-group" style="margin-bottom: 10px;">
                                                <label>Start Time</label>
                                                <select class="form-control" wire:model="start_time" wire:change="onStartTimeChange" @if(!$date || count($available_start_times) === 0) disabled @endif>
                                                    <option value="">Select start time</option>
                                                    @foreach($available_start_times as $t)
                                                        <option value="{{ $t }}">{{ $t }}</option>
                                                    @endforeach
                                                </select>
                                                @error('start_time') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="form-group" style="margin-bottom: 10px;">
                                                <label>End Time</label>
                                                <select class="form-control" wire:model="end_time" @if(!$start_time || count($available_end_times) === 0) disabled @endif>
                                                    <option value="">Select end time</option>
                                                    @foreach($available_end_times as $t)
                                                        <option value="{{ $t }}">{{ $t }}</option>
                                                    @endforeach
                                                </select>
                                                @error('end_time') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="form-group" style="margin-bottom: 10px;">
                                                <textarea class="form-control" rows="3" placeholder="Note (optional)" wire:model="note"></textarea>
                                                @error('note') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                                <input type="submit" class="btn btn-primary" value="Book Now">
                                                <a href="{{ route('login', ['status' => 'loginRequiredService']) }}" class="btn btn-primary">Send message</a>
                                            </div>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </aside>
                            <aside>
                                @if($r_service)
                                <h3>Related Service</h3>
                                <div class="col-md-12 col-sm-6 col-xs-12 bg-dark color-white padding-top-mini"
                                    style="max-width: 360px">
                                    <a href="{{ route('home.service_details', ['service_slug' => $r_service->slug]) }}">
                                        <div class="img-hover">
                                            <img src="{{asset('images/services/thumbnails')}}/{{ $r_service->thumbnail }}" alt="{{ $r_service->name }}"
                                                class="img-responsive">
                                        </div>
                                        <div class="info-gallery">
                                            <h3>
                                                {{$r_service->name}}
                                            </h3>
                                            <hr class="separator">
                                            <p>AC Wet Servicing</p>
                                            <div class="content-btn"><a href="{{ route('home.service_details', ['service_slug' => $r_service->slug]) }}"
                                                    class="btn btn-warning">View Details</a></div>
                                            <div class="price"><span>&#36;</span><b>From</b>{{$r_service->price}}</div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
    </section>
</div>
