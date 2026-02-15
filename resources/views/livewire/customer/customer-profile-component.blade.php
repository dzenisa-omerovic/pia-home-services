<div>
    <style>
        .popular-services-wrap {
            margin-top: 14px;
            padding: 12px;
            border: 1px solid #dce7f2;
            border-radius: 10px;
            background: #f8fbff;
        }
        .popular-services-title {
            font-weight: 700;
            color: #0b3b5b;
            margin-bottom: 10px;
        }
        .popular-service-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 4px 6px 4px 0;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid #cfe0ef;
            background: #fff;
            color: #123e66;
            font-size: 12px;
            font-weight: 600;
        }
        .popular-service-chip .score {
            background: #0b3b5b;
            color: #fff;
            border-radius: 999px;
            padding: 1px 8px;
            font-size: 11px;
        }
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Profile</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Profile</li>
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
                        <div class="col-md-8 col-md-offset-2 profile1">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Profile
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row customer-profile-row">
                                        <div class="col-md-4 customer-profile-photo">
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        </div>
                                        <div class="col-md-8 customer-profile-details">
                                            <div>
                                                <h3>Name: {{ $user->name }}</h3>
                                                <p><b>Email: </b>{{ $user->email }}</p>
                                                <p><b>Phone: </b>{{ $user->phone }}</p>
                                            </div>
                                            <div class="customer-profile-cta">
                                                <a href="{{ route('customer.edit_profile') }}" class="btn btn-info">Update Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
