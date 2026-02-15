
<div class="contact-page">
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Contact Us</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="content-central">
        <div class="semiboxshadow text-center">
            <img src="img/img-theme/shp.png" class="img-responsive" alt="">
        </div>
        <div id="map" class="honmob"> </div>
        <div class="content_info">
            <div class="paddings-mini">
                <div class="container">
                    <p class="contact-intro">
                        
                    </p>
                    <div class="row">
                        <div class="col-md-4 contact-sidebar">
                            <aside>
                                <h4>The Office</h4>
                                <address>
                                    <strong>Home Services</strong><br>
                                    <i class="fa fa-map-marker"></i><strong>Address: </strong>Tutin, Serbia<br>
                                    <i class="fa fa-phone"></i><strong>Phone: </strong> +3816123456
                                </address>
                                <address>
                                    <strong>Home Services Emails</strong><br>
                                    <i class="fa fa-envelope"></i><strong>Email:</strong><a
                                        href="mailto:contact@homeservices.rs"> contact@homeservices.rs</a><br>
                                    <i class="fa fa-envelope"></i><strong>Email:</strong><a
                                        href="mailto:support@homeservices.rs"> support@homeservices.rs</a>
                                </address>
                            </aside>
                            <hr class="tall">
                        </div>
                        <div class="col-md-8 contact-panel">
                            <h3>Contact Form</h3>
                            <p class="lead contact-lead">
                                Imate pitanje ili želite ponudu? Pišite nam i javićemo se u najkraćem roku.
                            </p>
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                            @endif
                            <form id="contactform" class="form-theme" method="post" wire:submit.prevent="sendMessage">
                                <input type="text" placeholder="Name" name="name" id="name" required="" wire:model="name">
                                @error('name') 
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <input type="email" placeholder="Email" name="email" id="email" required="" wire:model="email">
                                @error('email') 
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <input type="text" placeholder="Phone" name="phone" id="phone" required="" wire:model="phone">
                                @error('phone') 
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <textarea placeholder="Your Message" name="message" id="message" wire:model="message" required=""></textarea>
                                @error('message') 
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <input type="submit" name="Submit" value="Send Message" class="btn btn-primary">
                            </form>
                            <div id="result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-twitter content_resalt border-top">
            <i class="fa fa-twitter icon-big"></i>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
