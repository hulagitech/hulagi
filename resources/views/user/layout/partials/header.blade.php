<!-- Header -->
{{-- <style>
   .comment{
      padding:17px 0px 0px 7px;
   }
   .comment a i{
      font-size:20px;
   }
   .comment a:hover{
      text-decoration:none;
   }
   .soo-top{
      top:-12px;
   }
</style> --}}


<div class="site-header">

   <nav class="navbar navbar-light">

      <div class="container-fluid">

         <div class="col-sm-1 col-xs-1">

            <div class="hamburger hamburger--3dy-r">

               <div class="hamburger-box">

                  <div class="hamburger-inner"></div>

               </div>

            </div>

         </div>

         <div class="col-sm-2 col-xs-2">

            <div class="navbar-left" style="background-color: #fff;">

               <a class="navbar-brand" href="{{url('dashboard')}}" style="background:white;">

                  <div class="logo">

                     <img  style="width: 132px;height: 40px;" src=" {{ url(Setting::get('site_logo', asset('logo-black.png'))) }}">

                  </div>

               </a>

            </div>

         </div>

         <div class="col-sm-9 col-xs-9">

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

               <ul class="nav navbar-nav navbar-right">

                  <li class="menu-drop">
                     <div class="dropdown">
                        <a href="{{url('wallet')}}" class="btn btn-primary" style="padding-top: 24px;"> My Wallet {{currency($user_wallet)}}</a>
                       
                     </div>
                  </li>

                  {{-- User Comment notification icon --}}
                  <li class="nav-item">
                     <a class="nav-link" href="{{url('/comments')}}"   aria-expanded="false">
                     <i class="ti-comment"></i>
                   
                     <span class="tag tag-danger top">{{Auth::user()->unreadComments(Auth::user()->id)}}</span>
                     Comments </a>
                  </li> {{-- End of Comment notification --}}

                  {{-- Ticket Comment notification icon --}}
                  <li class="nav-item dropdown">
                     <a class="nav-link" href="{{url('/ticket')}}" aria-expanded="false">
                     <i class="ti-ticket"></i>
                     <span class="tag tag-danger top">{{Auth::user()->unreadTicketComment(Auth::user()->id)}}</span>
                     Tickets</a>
                  </li> {{-- End of "Ticket" Comment notification --}}
                  
               </ul>
            </div>
         </div>
      </div>
   </nav>
</div>
