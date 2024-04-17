<?php $__env->startSection('title', 'Contact Us '); ?>

<?php $__env->startSection('content'); ?>

<?php
$locale = session()->get('locale');
   if($locale){

      $locale;

   }else{

      $locale = 'en';

   }
 ?>
<style type="text/css">
    .form-control{
        background-color: #ffff !important;
    }
</style>
<div id="contact-page" class="page">    
    <section class="page-content">
        <div class="container">
            <div class="row">                   
                <div class="col-sm-12">
                    <h3> We're the Future of Eccommerce Logistics.</h3>
                </div>
            </div>
            <br>
            <div class="row">                   
                <div class="col-sm-6">
                    <h4>Our supply chain solutions bring people and technology together
to deliver the service and capacity you need.
</h4>
<br>
                    <p>{{ trans('contact_us.para') }}</p>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div id="contact-form">
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="{{route('contact.us')}}">
                                    <?php echo e(csrf_field()); ?>
                                
                                <div class="form-group">
                                    <label for="your_name">{{ trans('contact_us.name') }}*</label>
                                    <input type="text"  name="name" id="input-name" required  <?php if( Auth::check() ): ?> value="<?php echo e(Auth::user()->first_name); ?>"  <?php endif; ?> class="form-control" placeholder="{{ trans('contact_us.name') }}*" />                           
                                </div>
                                <div class="form-group">
                                    <label for="your_email">{{ trans('contact_us.email') }}*</label>
                                    <input type="email"  name="email" required <?php if( Auth::check() ): ?> value="<?php echo e(Auth::user()->email); ?>"  <?php endif; ?>  id="input-email" class="form-control" placeholder="{{ trans('contact_us.email') }}*" />                                                
                                </div>
                                
                                <div class="form-group">
                                    <label for="your_message">{{ trans('contact_us.description') }}*</label>
                                    <textarea class="form-control" required name="message" id="input-message" rows="8" placeholder="{{ trans('contact_us.enter_description') }}*"></textarea>                                                      
                                </div>
                                
                                <div class="buttons">
                                    <input  type="submit"  value="{{ trans('contact_us.send_message') }}" data-loading-text="Sending..."  class="btn btn-info" style="float: right;">
                                </div>
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="contact-info">
                        <h2> We're here to help.</h2>    
                        <br>                    
                        <ul class="ul">
                            <li>
                                <h4><i class="fa fa-map-marker"></i><b> </b>  Head Office : </b> </h4>
                                <p>Dillibazar, Kathmandu Nepal</p>
                            </li>
                            <br>
                            <li>
                                <h4><i class="fa fa-phone"></i>  {{ trans('contact_us.contact_no') }} ( Marketing Purpose )</h4>
                                <p>+01-5912257 </p>
                            </li>
                             <br>  

                             <li>
                                <h4><i class="fa fa-phone"></i>  {{ trans('contact_us.contact_no') }} ( Customer Support )</h4>
                                
                                    
                                <p> + 01 - 5912256 </p>
                            </li>
                             <br>  


                            <li>
                                <h4><i class="fa fa-envelope"></i> {{ trans('contact_us.email_addr') }}</h4>
                                <p>hulagilogistics@gmail.com</p>
                            </li>
                            <!--li>
                                <h3>Our Social Profile</h3>
                                <div class="social-icons">
                                    <ul class="ul">
                                        <li><a href="https://www.facebook.com/schoollinfo" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/schoollinfo" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/in/schoollinfo-india-2194a3163/"  target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a></li>                                    
                                        <li><a href="https://plus.google.com/118049402364890676625"  target="_blank" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </li-->                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">var route='<?php echo (route("contact")); ?>';</script>
<script type="text/javascript" src="<?php echo e(url('/asset/front/js/contact.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('website.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>