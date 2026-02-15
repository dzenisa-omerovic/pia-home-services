<div>
    <style>
        .reviews-page-title {
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .panel-heading.fancy-heading {
            background: linear-gradient(90deg, #0b3b5b, #1e5f8a);
            color: #fff;
            border-radius: 6px 6px 0 0;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-align: center;
        }
        .panel-heading.fancy-heading small {
            opacity: 0.8;
            font-weight: 500;
            margin-left: 6px;
        }
        .review-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }
        .review-card {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 14px 16px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.05);
            text-align: center;
        }
        .review-card .label {
            font-size: 12px;
            text-transform: uppercase;
            color: #7a7a7a;
            letter-spacing: 0.04em;
        }
        .review-card .value {
            font-size: 22px;
            font-weight: 700;
            color: #0b3b5b;
            margin-top: 4px;
        }
        .review-dist {
            margin-top: 10px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }
        .review-dist li {
            display: grid;
            grid-template-columns: 70px 1fr 40px;
            align-items: center;
            gap: 8px;
            margin: 6px 0;
            font-size: 13px;
        }
        .dist-bar {
            height: 8px;
            background: #eef2f7;
            border-radius: 999px;
            overflow: hidden;
        }
        .dist-bar > span {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, #0b3b5b, #4aa3df);
        }
        .review-table th {
            white-space: nowrap;
        }
        .review-table td {
            vertical-align: middle;
        }
        .per-service-table td,
        .per-service-table th {
            text-align: left;
        }
        .per-service-table td:nth-child(2),
        .per-service-table td:nth-child(3),
        .per-service-table td:nth-child(4) {
            text-align: center;
        }
        .service-score-list {
            display: grid;
            gap: 14px;
        }
        .service-score-card {
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 14px 16px;
            background: #fff;
            box-shadow: 0 8px 18px rgba(0,0,0,0.05);
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            align-items: center;
            justify-items: center;
            text-align: center;
        }
        .service-score-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: conic-gradient(#0b3b5b var(--pct), #e9eef5 0);
            position: relative;
        }
        .service-score-ring::after {
            content: "";
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: #fff;
            box-shadow: inset 0 0 0 1px #eef2f7;
        }
        .service-score-ring span {
            position: absolute;
            font-size: 12px;
            font-weight: 700;
            color: #0b3b5b;
            text-align: center;
            line-height: 1.1;
        }
        .service-score-name {
            font-weight: 600;
            color: #0b3b5b;
            margin-bottom: 4px;
        }
        .service-score-meta {
            font-size: 12px;
            color: #6b7280;
        }
        .service-score-foot {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px 16px;
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }
        .service-score-pill {
            background: #f6f8fb;
            border: 1px solid #e3e8ef;
            border-radius: 999px;
            padding: 4px 10px;
            font-weight: 600;
            color: #0b3b5b;
        }
        .all-reviews-list {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        @media (max-width: 991px) {
            .all-reviews-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 600px) {
            .all-reviews-list {
                grid-template-columns: 1fr;
            }
        }
        .review-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e9f2fb;
            color: #0b3b5b;
            border: 1px solid #cfe3f5;
            border-radius: 999px;
            padding: 4px 10px;
            font-weight: 600;
            font-size: 12px;
        }
        .review-card-item {
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 12px 14px;
            background: #fff;
            box-shadow: 0 6px 14px rgba(0,0,0,0.04);
        }
        .review-card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }
        .review-card-title {
            font-weight: 700;
            color: #0b3b5b;
        }
        .review-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 12px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .review-card-comment {
            background: #f7fafc;
            border: 1px solid #e6eef7;
            border-radius: 10px;
            padding: 8px 10px;
            color: #334155;
        }
        .weekly-chart-wrap {
            max-width: 820px;
            margin: 0 auto;
            border: 1px solid #e7edf4;
            border-radius: 12px;
            padding: 14px 14px 10px;
            background: linear-gradient(180deg, #fbfdff, #f5f9fd);
        }
        .weekly-chart-grid {
            display: grid;
            grid-template-columns: 58px 1fr;
            gap: 10px;
        }
        .weekly-chart-area {
            display: grid;
            grid-template-rows: 240px auto;
            gap: 8px;
        }
        .weekly-y-axis {
            height: 240px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 11px;
            color: #6b7280;
            text-align: right;
            padding-right: 4px;
        }
        .weekly-plot {
            height: 240px;
            border-left: 1px solid #cfe0ef;
            border-bottom: 1px solid #cfe0ef;
            padding: 0 8px 0;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            align-items: end;
            position: relative;
        }
        .weekly-grid-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }
        .weekly-grid-lines span {
            position: absolute;
            left: 0;
            right: 0;
            border-top: 1px solid #d6e0ec;
        }
        .weekly-bar-col {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
            height: 100%;
            position: relative;
            z-index: 2;
        }
        .weekly-bar {
            width: 42px;
            max-width: 42px;
            min-height: 0;
            border-radius: 10px 10px 4px 4px;
            background: linear-gradient(180deg, #2e89c9 0%, #0b3b5b 100%);
            box-shadow: 0 6px 14px rgba(11, 59, 91, 0.22);
            position: absolute;
            left: 50%;
            bottom: 0;
            transform-origin: bottom center;
            animation: weeklyBarGrow 0.7s ease-out both;
        }
        .weekly-bar.no-data {
            display: none;
        }
        .weekly-x-axis {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            padding: 0 8px 2px;
        }
        .weekly-x-tick {
            text-align: center;
            color: #184e79;
        }
        .weekly-x-label {
            font-size: 11px;
            font-weight: 700;
            color: #184e79;
        }
        .weekly-x-value {
            font-size: 11px;
            color: #0b3b5b;
            font-weight: 700;
            margin-top: 1px;
        }
        .weekly-periods {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 6px 12px;
            margin-top: 10px;
        }
        .weekly-period-item {
            font-size: 12px;
            color: #4b5563;
            background: #ffffff;
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            padding: 6px 8px;
        }
        .weekly-period-item strong {
            color: #0b3b5b;
        }
        .weekly-price-note {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            margin-top: 10px;
        }
        @keyframes weeklyBarGrow {
            from {
                transform: translateX(-50%) scaleY(0);
                opacity: 0.55;
            }
            to {
                transform: translateX(-50%) scaleY(1);
                opacity: 1;
            }
        }
        .weekly-period-actions {
            text-align: center;
            margin-top: 10px;
        }
        .period-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(11, 18, 27, 0.55);
            z-index: 1060;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 14px;
        }
        .period-modal-backdrop.is-open {
            display: flex;
        }
        .period-modal {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
            overflow: hidden;
        }
        .period-modal-head {
            background: linear-gradient(90deg, #0b3b5b, #1e5f8a);
            color: #fff;
            padding: 12px 16px;
            font-weight: 700;
        }
        .period-modal-body {
            padding: 14px 16px;
            display: grid;
            gap: 8px;
            max-height: 52vh;
            overflow-y: auto;
        }
        .period-modal-item {
            border: 1px solid #e4ebf3;
            border-radius: 8px;
            padding: 8px 10px;
            background: #fafcff;
            color: #334155;
            font-size: 13px;
        }
        .period-modal-item strong {
            color: #0b3b5b;
        }
        .period-modal-actions {
            padding: 12px 16px 16px;
            text-align: right;
        }
        @media (max-width: 767px) {
            .weekly-plot {
                gap: 6px;
                padding: 6px 4px 0;
            }
            .weekly-x-axis {
                gap: 6px;
                padding: 0 4px 2px;
            }
            .weekly-periods {
                grid-template-columns: 1fr;
            }
            .weekly-bar {
                max-width: 28px;
            }
        }
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1 class="reviews-page-title">My Reviews</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>My Reviews</li>
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
                        <div class="col-md-10 col-md-offset-1 profile1">
                            <div class="panel panel-default">
                                <div class="panel-heading fancy-heading">Weekly Average Ratings <small>last {{ $weeklyRatings->count() }} weeks</small></div>
                                <div class="panel-body">
                                    @php
                                        $axisValues = [5, 4, 3, 2, 1];
                                    @endphp

                                    <div class="weekly-chart-wrap">
                                        <div class="weekly-chart-grid">
                                            <div class="weekly-y-axis">
                                                @foreach($axisValues as $tick)
                                                    <span>{{ $tick }}&#9733;</span>
                                                @endforeach
                                            </div>
                                            <div class="weekly-chart-area">
                                                <div class="weekly-plot">
                                                <div class="weekly-grid-lines" aria-hidden="true">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <span style="top: {{ $i * 25 }}%;"></span>
                                                    @endfor
                                                </div>
                                                @foreach($weeklyRatings as $week)
                                                    @php
                                                        $rating = max(1, min(5, (float) $week['avg_rating']));
                                                        $heightPct = (($rating - 1) / 4) * 100;
                                                    @endphp
                                                    <div class="weekly-bar-col">
                                                        <div class="weekly-bar @if($week['count'] < 1) no-data @endif" style="height: {{ max($heightPct, 0) }}%; animation-delay: {{ ($loop->iteration - 1) * 0.08 }}s;"></div>
                                                    </div>
                                                @endforeach
                                                </div>
                                                <div class="weekly-x-axis">
                                                    @foreach($weeklyRatings as $week)
                                                        <div class="weekly-x-tick">
                                                            <div class="weekly-x-label">P{{ $loop->iteration }}</div>
                                                            <div class="weekly-x-value">{{ number_format($week['avg_rating'], 2, '.', '') }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="weekly-period-actions">
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('weeklyPeriodsModal').classList.add('is-open')">
                                            Otvori periode
                                        </button>
                                    </div>
                                    <div class="weekly-price-note">
                                        Prosecna ocena po nedelji (1-5).
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading fancy-heading">Review Statistics <small>overview</small></div>
                                <div class="panel-body">
                                    <div class="review-grid">
                                        <div class="review-card">
                                            <div class="label">Average Rating</div>
                                            <div class="value">{{ $avg }}</div>
                                        </div>
                                        <div class="review-card">
                                            <div class="label">Total Reviews</div>
                                            <div class="value">{{ $total }}</div>
                                        </div>
                                    </div>
                                    <ul class="review-dist">
                                        @php $t = max($total, 1); @endphp
                                        <li>
                                            <span>5 stars</span>
                                            <div class="dist-bar"><span style="width: {{ ($distribution[5] / $t) * 100 }}%"></span></div>
                                            <span>{{ $distribution[5] }}</span>
                                        </li>
                                        <li>
                                            <span>4 stars</span>
                                            <div class="dist-bar"><span style="width: {{ ($distribution[4] / $t) * 100 }}%"></span></div>
                                            <span>{{ $distribution[4] }}</span>
                                        </li>
                                        <li>
                                            <span>3 stars</span>
                                            <div class="dist-bar"><span style="width: {{ ($distribution[3] / $t) * 100 }}%"></span></div>
                                            <span>{{ $distribution[3] }}</span>
                                        </li>
                                        <li>
                                            <span>2 stars</span>
                                            <div class="dist-bar"><span style="width: {{ ($distribution[2] / $t) * 100 }}%"></span></div>
                                            <span>{{ $distribution[2] }}</span>
                                        </li>
                                        <li>
                                            <span>1 star</span>
                                            <div class="dist-bar"><span style="width: {{ ($distribution[1] / $t) * 100 }}%"></span></div>
                                            <span>{{ $distribution[1] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading fancy-heading">Per Service Analysis <small>breakdown</small></div>
                                <div class="panel-body">
                                    <div class="service-score-list">
                                        @forelse($perService as $row)
                                            @php
                                                $scoreMax = max($perService->max('score'), 1);
                                                $scorePct = min(100, ($row->score / $scoreMax) * 100);
                                            @endphp
                                            <div class="service-score-card">
                                                <div class="service-score-ring" style="--pct: {{ $scorePct }}%;">
                                                    <span>{{ round($row->avg_rating, 2) }}★<br>{{ $scorePct ? intval($scorePct) : 0 }}%</span>
                                                </div>
                                                <div>
                                                    <div class="service-score-name">{{ $row->name }}</div>
                                                    <div class="service-score-meta">Score index (relative to your top service)</div>
                                                    <div class="service-score-foot">
                                                        <div class="service-score-pill">Avg: {{ round($row->avg_rating, 2) }}</div>
                                                        <div class="service-score-pill">Reviews: {{ $row->cnt }}</div>
                                                        <div class="service-score-pill">Score: {{ $row->score }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div>No data yet.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading fancy-heading">All Reviews <small>recent</small></div>
                                <div class="panel-body">
                                    <div class="all-reviews-list">
                                        @forelse($reviews as $review)
                                            <div class="review-card-item">
                                                <div class="review-card-head">
                                                    <div class="review-card-title">{{ $review->service ? $review->service->name : '-' }}</div>
                                                    <div class="review-chip">★ {{ $review->rating }}</div>
                                                </div>
                                                <div class="review-card-meta">
                                                    <div>Customer: <strong>{{ $review->customer ? $review->customer->name : '-' }}</strong></div>
                                                    <div>Date: <strong>{{ $review->created_at }}</strong></div>
                                                </div>
                                                <div class="review-card-comment">
                                                    {{ $review->comment }}
                                                </div>
                                            </div>
                                        @empty
                                            <div>No reviews yet.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="weeklyPeriodsModal" class="period-modal-backdrop" onclick="if(event.target.id==='weeklyPeriodsModal'){this.classList.remove('is-open')}">
        <div class="period-modal" onclick="event.stopPropagation()">
            <div class="period-modal-head">Periodi (zadnjih {{ $weeklyRatings->count() }} nedelja)</div>
            <div class="period-modal-body">
                @foreach($weeklyRatings as $week)
                    <div class="period-modal-item">
                        <strong>Period {{ $loop->iteration }}:</strong> {{ $week['range'] }}
                    </div>
                @endforeach
            </div>
            <div class="period-modal-actions">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('weeklyPeriodsModal').classList.remove('is-open')">
                    Zatvori
                </button>
            </div>
        </div>
    </div>
</div>
