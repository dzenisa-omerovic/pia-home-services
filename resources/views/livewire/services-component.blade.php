<div>
    <style>
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
        .filter-trigger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0b3b5b;
            color: #fff;
            border: 0;
            border-radius: 6px;
            padding: 8px 14px;
            font-weight: 600;
        }
        .filters-row {
            display: flex;
            justify-content: flex-end;
            margin-top: -56px;
        }
        .filter-badge {
            background: #f0f4f7;
            color: #0b3b5b;
            border-radius: 999px;
            padding: 2px 10px;
            font-size: 12px;
            margin-left: 8px;
        }
        .filter-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(12, 18, 24, 0.6);
            z-index: 9999;
        }
        .filter-modal.is-open {
            display: flex;
        }
        .filter-dialog {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            padding: 18px 20px;
        }
        .filter-dialog h4 {
            margin: 0 0 12px 0;
            font-weight: 700;
            color: #0b3b5b;
        }
        .filter-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 14px;
        }
        .filter-actions .btn {
            min-width: 120px;
        }
        .services-pagination {
            display: flex;
            justify-content: center;
            margin: 14px 0 6px;
            clear: both;
            width: 100%;
            float: none;
        }
        .services-pagination .pagination {
            margin: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 6px 14px rgba(0,0,0,0.08);
        }
        .services-pagination .pagination > li > a,
        .services-pagination .pagination > li > span {
            border: 0;
            color: #0b3b5b;
            padding: 6px 12px;
        }
        .services-pagination .pagination > .active > span,
        .services-pagination .pagination > .active > span:hover,
        .services-pagination .pagination > .active > span:focus {
            background: #0b3b5b;
            color: #fff;
            border: 0;
        }
        .services-pagination .pagination > li > a:hover {
            background: #eef3f7;
        }
        .services-pager {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f7f8fb;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.10);
        }
        .services-pager .btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #123e66;
            font-weight: 600;
        }
        .services-pager .btn[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .services-pager .btn:hover:not([disabled]) {
            background: #eaf0f6;
        }
        .services-pager .btn.page-btn.active,
        .services-pager .btn.page-btn.active:hover,
        .services-pager .btn.page-btn.active:focus {
            background: #0b3b5b;
            color: #fff;
        }
        @media (max-width: 575px) {
            .filter-dialog {
                max-width: 92%;
            }
            .filter-actions {
                flex-direction: column;
            }
            .filter-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="section-title-01 honmob">
        <div class="bg_parallax image_01_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Services</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="content-central">
        <div class="container">
            <div id="serviceFiltersModal" class="filter-modal" onclick="if(event.target.id==='serviceFiltersModal'){this.classList.remove('is-open')}">
                <div class="filter-dialog" onclick="event.stopPropagation()">
                    <h4>Filter Services</h4>
                    <div class="form-group">
                        <label for="filterCategory" style="font-weight: 600;">Category</label>
                        <select id="filterCategory" class="form-control" wire:model.defer="pending_category_id">
                            <option value="">All categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sortBy" style="font-weight: 600;">Sort by</label>
                        <select id="sortBy" class="form-control" wire:model.defer="pending_sort_by">
                            <option value="latest">Newest first</option>
                            <option value="name_asc">Name A-Z</option>
                            <option value="price_asc">Price low to high</option>
                            <option value="price_desc">Price high to low</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="button" class="btn btn-default" wire:click="resetFilters" onclick="document.getElementById('serviceFiltersModal').classList.remove('is-open')">Reset</button>
                        <button type="button" class="btn btn-primary" wire:click="applyFilters" onclick="document.getElementById('serviceFiltersModal').classList.remove('is-open')">Apply Filters</button>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        var modal = document.getElementById('serviceFiltersModal');
                        if (modal && modal.classList.contains('is-open')) {
                            modal.classList.remove('is-open');
                        }
                    }
                });
            </script>

            <div class="row">
                <div class="titles">
                    <h2>All <span>Services</span></h2>
                    <i class="fa fa-plane"></i>
                    <hr class="tall">
                </div>
            </div>

            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="col-xs-12">
                    <div class="filters-row">
                        <button type="button" class="filter-trigger" onclick="document.getElementById('serviceFiltersModal').classList.add('is-open')">
                            <i class="fa fa-filter"></i> Filters
                            @if($category_id || $sort_by !== 'latest')
                                <span class="filter-badge">Applied</span>
                            @endif
                        </button>
                    </div>
                </div>
            </div>

            <div class="portfolioContainer latest-services" style="margin-top: 0;">
                @forelse ($services as $service)
                    <div class="col-xs-6 col-sm-4 col-md-3 hsgrids" style="padding-right: 5px; padding-left: 5px;">
                        <a class="g-list" href="{{ route('home.service_details', ['service_slug' => $service->slug]) }}">
                            <div class="img-hover">
                                <img src="{{ asset('images/services/thumbnails') }}/{{ $service->thumbnail }}" alt="{{ $service->name }}" class="img-responsive">
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
                                <div class="price">
                                    <b>From</b>${{ number_format((float) $service->price, 2, '.', '') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-info">No services found.</div>
                    </div>
                @endforelse
            </div>

            <div class="clearfix"></div>
            <div class="services-pagination">
                <div class="services-pager">
                    <button type="button" class="btn btn-default" wire:click="previousPage" @if($services->onFirstPage()) disabled @endif aria-label="Previous page">
                        <i class="fa fa-angle-left"></i>
                    </button>
                    @for($page = 1; $page <= max($services->lastPage(), 1); $page++)
                        <button
                            type="button"
                            class="btn btn-default page-btn @if($services->currentPage() === $page) active @endif"
                            wire:click="gotoPage({{ $page }})"
                            aria-label="Page {{ $page }}">
                            {{ $page }}
                        </button>
                    @endfor
                    <button type="button" class="btn btn-default" wire:click="nextPage" @if(!$services->hasMorePages()) disabled @endif aria-label="Next page">
                        <i class="fa fa-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
