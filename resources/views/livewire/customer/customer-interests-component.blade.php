<div>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_01_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Moji interesi</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Moji interesi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="content-central">
        <div class="container">
            <div class="row" style="margin-top: -30px;">
                <div class="titles">
                    <h2>Moji <span>Interesi</span></h2>
                    <i class="fa fa-plane"></i>
                    <hr class="tall">
                </div>
            </div>
        </div>
        <div class="content_info" style="margin-top: -70px;">
            <div class="categories-spacer"></div>
            <div class="row">
                <div class="col-md-12">
                    @if($interests->count() === 0)
                        <p class="text-center">Nema izabranih kategorija.</p>
                    @else
                        <ul class="services-lines full-services category-tile-grid">
                            @foreach($interests as $interest)
                                <li>
                                    <div class="item-service-line">
                                        <i class="fa">
                                            <a href="{{ route('home.services_by_category', ['category_slug' => $interest->slug]) }}">
                                                <img class="icon-img" src="{{ asset('images/categories') }}/{{ $interest->image }}" alt="{{ $interest->name }}">
                                            </a>
                                        </i>
                                        <h5>{{ $interest->name }}</h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
