<div>
    <style>
        .category-search-wrap {
            display: flex;
            justify-content: center;
            margin: -26px 0 34px;
        }
        .category-search {
            width: 100%;
            max-width: 640px;
            background: #fff;
            border: 1px solid #e6e8ee;
            border-radius: 8px;
            padding: 10px 12px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.08);
            position: relative;
            z-index: 2;
            transform: translateY(-28px);
        }
        .categories-spacer {
            height: 28px;
        }
        .category-search label {
            font-weight: 700;
            color: #0b3b5b;
            margin-bottom: 6px;
        }
        .category-search .input-group {
            display: flex;
            gap: 8px;
        }
        .category-search .form-control {
            flex: 1 1 auto;
            height: 38px;
        }
        .category-search .btn {
            height: 38px;
            min-width: 120px;
        }
        .category-pagination {
            display: flex;
            justify-content: center;
            margin: 10px 0 6px;
            clear: both;
            width: 100%;
        }
        .category-pager {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f7f8fb;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.10);
        }
        .category-pager .btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #0b3b5b;
            font-weight: 600;
        }
        .category-pager .btn[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .category-pager .btn:hover:not([disabled]) {
            background: #eaf0f6;
        }
        .category-pager .btn.page-btn.active,
        .category-pager .btn.page-btn.active:hover,
        .category-pager .btn.page-btn.active:focus {
            background: #0b3b5b;
            color: #fff;
            border: 0;
        }
        @media (max-width: 575px) {
            .category-search .input-group {
                flex-direction: column;
            }
            .category-search .btn {
                width: 100%;
            }
        }
    </style>
    <div class="section-title-01 honmob">
            <div class="bg_parallax image_01_parallax"></div>
            <div class="opacy_bg_02">
                <div class="container">
                    <h1>Service Categories</h1>
                    <div class="crumbs">
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li>/</li>
                            <li>Service Categories</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="content-central">
            <div class="container">
                <div class="row" style="margin-top: -30px;">
                    <div class="titles">
                        <h2>Service  <span>Categories</span></h2>
                        <i class="fa fa-plane"></i>
                        <hr class="tall">
                    </div>
                </div>
                @if($canUseSearchAndPagination)
                    <div class="category-search-wrap">
                        <div class="category-search">
                            <form wire:submit.prevent="applySearch">
                                <label for="categorySearch">Search categories</label>
                                <div class="input-group">
                                    <input id="categorySearch" type="text" class="form-control" placeholder="Type a keyword..."
                                        wire:model.defer="pending_search">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            <div class="content_info" style="margin-top: -70px;">
                <div class="categories-spacer"></div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="services-lines full-services">
                            @foreach($scategories as $scategory)
                                <li>
                                    <div class="item-service-line">
                                        <i class="fa"><a href="{{ route('home.services_by_category', ['category_slug' => $scategory->slug]) }}"><img class="icon-img"
                                                    src="{{asset('images/categories')}}/{{ $scategory->image }}" alt="{{$scategory->name}}"></a></i>
                                                    
                                        <h5>{{$scategory->name}}</h5>
                                    </div>
                                </li>
                            @endforeach
                            
                        </ul>
                        @if($canUseSearchAndPagination)
                            <div class="category-pagination">
                                <div class="category-pager">
                                    <button type="button" class="btn btn-default" wire:click="previousPage" @if($scategories->onFirstPage()) disabled @endif aria-label="Previous page">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                    @for($page = 1; $page <= max($scategories->lastPage(), 1); $page++)
                                        <button
                                            type="button"
                                            class="btn btn-default page-btn @if($scategories->currentPage() === $page) active @endif"
                                            wire:click="gotoPage({{ $page }})"
                                            aria-label="Page {{ $page }}">
                                            {{ $page }}
                                        </button>
                                    @endfor
                                    <button type="button" class="btn btn-default" wire:click="nextPage" @if(!$scategories->hasMorePages()) disabled @endif aria-label="Next page">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
</div>
