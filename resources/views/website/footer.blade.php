<?php 
$datas = top_countries();
 ?>
<footer>
    <div class="container">
        <div class="footer-topborder">
            <div class="row">
                <div class="col-md-4 footer-uber">
                    <div class="footer-topheading"> <img src="{{ url(Setting::get('site_email_logo')) }}" width="30%" height="30%" /> </div>
                </div>
                <div class="col-md-4 footer-signup">
                    <div class="footer-topbtn"> <a href="{{ url('/register') }}" class="btn btn-default button-shadow">{{ trans('footer.signup_for_ride') }}</a> </div>
                </div>
                <div class="col-md-4 footer-becomedriver">
                    <div class="footer-topbtn"> <a href="{{ url('/provider/register') }}" class="btn btn-default button-shadow">{{ trans('footer.become_a_driver') }}</a> </div>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <div class="row">
                <div class="col-md-4">
                    <div class="location-footer" style="color:white;">
                        <h4>{{ trans('footer.download_to_ride') }}</h4>
                        <ul class="app">
                            {{-- <li>
                                <a href="{{Setting::get('store_link_ios','#')}}"> <img src="{{asset('asset/front/img/appstore.png')}}" width="30%" height="30%"> </a>
                            </li> --}}
                            <li>
                                <a href="{{Setting::get('store_link_user')}}"  target="_blank"> <img src="{{asset('asset/front/img/playstore.png')}}" width="30%" height="30%"> </a>
                            </li>
                        </ul>
                        <h4>{{ trans('footer.download_to_drive') }}</h4>
                        <ul class="app">
                            {{-- <li>
                                <a href="{{Setting::get('store_link_ios','#')}}"> <img src="{{asset('asset/front/img/appstore.png')}}" width="30%" height="30%"> </a>
                            </li> --}}
                            <li>
                                <a href="{{Setting::get('store_link_provider')}}" target="_blank"> <img src="{{asset('asset/front/img/playstore.png')}}" width="30%" height="30%"> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="social-media">
                        <ul>
                            <li>
                                <a href="#"><img src="{{ url('asset/front_dashboard/img/facebook.png') }}" alt="facebook" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ url('asset/front_dashboard/img/google-plus.png') }}" alt="facebook" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ url('asset/front_dashboard/img/twitter.png') }}" alt="facebook" /></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution="setup_tool"
        page_id="141556857638183">
      </div>
                <div class="col-md-4">
                    <div class="footer-manu">
                        <ul>
                            @foreach(getPages() as $list)
                                @if($list->slug == 'about-us')
									<li><a href="{{ url('').'/'.$list->slug }}">{{ trans('footer.about_puryau') }}</a></li>
                                    @endif
								@endforeach
							@foreach(getPages() as $list)
                            @if($list->slug == 'why-us')
								<li><a href="{{ url('').'/'.$list->slug }}">{{ trans('footer.why_puryau') }}</a></li>
                                @endif
							@endforeach
                            <li><a href="{{ url('/how_it_works') }}">{{ trans('footer.how_it_works') }}</a></li>
                            <li><a href="{{ url('/blogs') }}">{{ trans('footer.blog') }}</a></li>
                            @foreach(getPages() as $list)
                            @if($list->slug == 'privacy-policy')
								<li><a href="{{ url('').'/'.$list->slug }}">{{ trans('footer.policy') }}</a></li>
                                @endif
							@endforeach
							@foreach(getPages() as $list)
                            @if($list->slug == 'refund-policy')
								<li><a href="{{ url('').'/'.$list->slug }}">{{ trans('footer.refund') }}</a></li>
                                @endif
							@endforeach
							@foreach(getPages() as $list)
                            @if($list->slug == 'terms-conditions')
								<li><a href="{{ url('').'/'.$list->slug }}">{{ trans('footer.terms_conditions') }}</a></li>
                                @endif
							@endforeach
							<!--@foreach(getPages() as $list)
                            @if($list->slug == 'about-us' || $list->slug == 'refund-policy' || $list->slug == 'why-us' || $list->slug == 'privacy-policy' || $list->slug == 'terms-conditions')
								<li><a href="{{ url('').'/'.$list->slug }}">{{ucfirst($list->title)}}</a></li>
                                @endif
							@endforeach-->
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="menu-right">
                        <ul>
                            <li><a href="{{ url('/fare_estimate') }}">{{ trans('footer.fare_estimation') }}</a></li>
                            <li><a href="{{ url('/helppage') }}">{{ trans('footer.help') }}</a></li>
                             <!-- <li><a href="{{ url('/support') }}">Suppo</a></li> -->
                            <li><a href="{{ url('/support/complaint') }}">{{ trans('footer.complaint') }}</a></li>
                            <li><a href="{{ url('/contact_us') }}">{{ trans('footer.contact_us') }}</a></li>
                            <!-- <li><a href="{{ url('/lost-item') }}">Lost Item</a></li> -->
                            <li><a href="{{ url('/register') }}">{{ trans('footer.signup') }}</a></li>
                            <li><a href="{{ url('/trackMyOrder') }}">Track My Order</a></li>
                            <!-- <li><a href ="{{ url('/internationalquote') }}" target="_blank" rel="noopener noreferrer" >International Quote</a><li> -->
                            <!--<li><img src="{{asset('asset/front_dashboard/img/cimage.png')}}"  width="100%"></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="citesandcountries">
			<div class="footer-left">
				<ul>
					<li><small>{{ trans('footer.top_countries') }}</small></li>
				</ul>
			</div>

            <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution="page_inbox"
        page_id="141556857638183">
      </div>


            
			<div class="footer-right" >
				<div class="top-cities">
					<ul>
						@foreach($datas as $data)
                        <li><a href="{{ url('/country/'.$data->country) }}">{{ $data->country }}</a></li>
                        @endforeach
						<!-- <li>Cape Coral</li>
						<li>Punta Gorda</li>
						<li>Port Charlotte</li>
						<li>Naples</li>
						<li>Bonita Springs</li>
						<li>Pine Island</li> -->
					</ul>
				</div>
				
			</div>  --}}
			<br/>                   
		</div>
    </div>
</footer>
