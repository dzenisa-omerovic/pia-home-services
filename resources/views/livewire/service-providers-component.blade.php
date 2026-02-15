<div>
    <style>
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
                <h1>Service providers</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Service providers</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="content-central">
        <div class="container">
            <div class="row">
                <div class="titles">
                    <h2>Service <span>Providers</span></h2>
                    <i class="fa fa-plane"></i>
                    <hr class="tall">
                </div>
            </div>
            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="col-xs-12">
                    <div class="filters-row">
                        <button type="button" class="filter-trigger" onclick="document.getElementById('filtersModal').classList.add('is-open')">
                        <i class="fa fa-filter"></i> Filters
                        @if($category_id || $min_rating || $sort_rating !== 'desc')
                            <span class="filter-badge">Applied</span>
                        @endif
                        </button>
                    </div>
                </div>
            </div>
            <div id="filtersModal" class="filter-modal" onclick="if(event.target.id==='filtersModal'){this.classList.remove('is-open')}">
                <div class="filter-dialog" onclick="event.stopPropagation()">
                    <h4>Filter Service providers</h4>
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
                        <label for="filterRating" style="font-weight: 600;">Minimum rating</label>
                        <select id="filterRating" class="form-control" wire:model.defer="pending_min_rating">
                            <option value="">Any rating</option>
                            <option value="5">5 only</option>
                            <option value="4">4+ stars</option>
                            <option value="3">3+ stars</option>
                            <option value="2">2+ stars</option>
                            <option value="1">1+ stars</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sortRating" style="font-weight: 600;">Sort by rating</label>
                        <select id="sortRating" class="form-control" wire:model.defer="pending_sort_rating">
                            <option value="desc">Highest to lowest</option>
                            <option value="asc">Lowest to highest</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="button" class="btn btn-default" wire:click="resetFilters" onclick="document.getElementById('filtersModal').classList.remove('is-open')">Reset</button>
                        <button type="button" class="btn btn-primary" wire:click="applyFilters" onclick="document.getElementById('filtersModal').classList.remove('is-open')">Apply Filters</button>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        var modal = document.getElementById('filtersModal');
                        if (modal && modal.classList.contains('is-open')) {
                            modal.classList.remove('is-open');
                        }
                    }
                });
            </script>
            <div class="row" style="margin-top: 10px;">
                @foreach ($sproviders as $provider)
                    <div class="col-xs-12 col-sm-6 col-md-4" style="margin-bottom: 20px;">
                        <div class="card" style="border: 1px solid #e6e8ee; border-radius: 6px; padding: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); min-height: 180px;">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="width: 56px; height: 56px; border-radius: 50%; overflow: hidden; background: #f2f4f7; flex: 0 0 56px;">
                                    @if($provider->image)
                                        <img src="{{ asset('images/sproviders') }}/{{ $provider->image }}" alt="{{ $provider->user?->name ?? 'Provider' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 700;">{{ $provider->user?->name ?? 'Service Provider' }}</div>
                                    <div style="color: #6b7280; font-size: 13px;">
                                        {{ $provider->category?->name ?? 'General' }}
                                    </div>
                                    <div style="color: #6b7280; font-size: 13px;">
                                        {{ $provider->city ?? '—' }}
                                    </div>
                                    <div style="color: #6b7280; font-size: 13px;">
                                        Avg rating: {{ number_format($provider->avg_rating, 2) }} ({{ $provider->review_count }})
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 12px; color: #4b5563; font-size: 14px;">
                                {{ $provider->about ? \Illuminate\Support\Str::limit($provider->about, 90) : 'Trusted service provider.' }}
                            </div>
                            <div style="margin-top: 12px;">
                                <a href="{{ route('home.service_provider_details', ['provider_id' => $provider->id]) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if($sproviders->count() === 0)
                    <div class="col-md-12">
                        <div class="alert alert-info">No service providers found.</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
