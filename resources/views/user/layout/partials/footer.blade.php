<div class="row footer no-margin">
    <div class="container-fluid">
        <div class="col-md-6 text-left">
            <p>{{ Setting::get('site_copyright', '&copy; '.date('Y').' Appoets') }}</p>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="{{Setting::get('store_link_ios','#')}}" class="app">
                <img src="{{asset('asset/img/appstore.png')}}">
            </a>
            <a href="{{Setting::get('store_link_android','#')}}" class="app">
                <img src="{{asset('asset/img/playstore.png')}}">
            </a>
        </div>
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
    }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
attribution="setup_tool"
page_id="141556857638183">
</div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5d9d7783db28311764d7fa68/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
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