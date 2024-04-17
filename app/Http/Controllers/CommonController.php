<?php

namespace App\Http\Controllers;

use Session;
use App\Blog;
use App\Page;
use App\User;
use DateTime;
use App\LostItem;
use App\Provider;
use App\RiderLog;
use App\Complaint;
use App\ContactUs;
use \Carbon\Carbon;
use App\ServiceType;
use App\QuoteRequest;
use App\UserRequests;
use App\PasswordReset;
use App\ProviderProfile;
use App\ProviderService;
use App\ProviderDocument;
use App\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SendPushNotification;
use Illuminate\Support\Str;

class CommonController extends Controller
{
   

    public function index(Request $request) {
    	    
		$data['services'] 	=	ServiceType::all();   
		//$details 				=	$this->getIpDetails();
		//$data['services'] 		=	$details['services'];
		//$data['ip_details']		=	$details['ip_details'];
		$data['testimonials']	=	Testimonial::orderBy('id', 'desc')->take(8)->get();
	
		return view('index', ['data' => $data ]);
	}

    public function lang(){
         $locale = session()->get('locale');
        if($locale){

             return $locale;

           }else{

             return $locale = 'en';

        }
    }
     public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function reset(){
        return view('user.auth.reset');
    }
    public function complaint(){
        $data['message_cats'] = ['test1','test2','test3'];
        return view('pages.complaint', compact('data'));
    }

    public function contact_us(){
        $data['message_cats'] = ['test1','test2','test3'];
        return view('pages.contact_us', compact('data'));
    }
    public function lost_item(){
        return view('pages.lost_item');
    }


    public function getCountry($id){
        return view('pages.country',compact('id'));
    }
 /**
     * update password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request){
     
        $this->validate($request,[
            'token'     => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);
        try {
            $email=PasswordReset::where('token',$request->token)->pluck('email');
            User::where('email',$email)->update(['password' => bcrypt($request->password)]);
            PasswordReset::where('token',$request->token)->delete();
            return redirect('UserSignin')->with('flash_success','Password has been changed');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function provider_password_update(Request $request){
        $this->validate($request,[
            'email'     => 'required|email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);
        try {
            Provider::where('email',$request->email)->update(['password' => bcrypt($request->password)]);
             return redirect('provider/login');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        } 
    }

    public function trackMyOrder(Request $request){
        try{
            if($request->has('bookingID') && $request->has('dropoffNumber')){
                $bookingID=$request->bookingID;
                $dropoffNumber=$request->dropoffNumber;
                $order=UserRequests::where('user_requests.booking_id',$bookingID)
                        ->select([
                            "user_requests.id",
                            "user_requests.booking_id",
                            "user_requests.status",
                            "user_requests.item_id",
                            "user_requests.provider_id",
                            "user_requests.user_id",
                            "user_requests.created_at"
                        ])
                        ->where('i.rec_mobile',$dropoffNumber)
                        ->join("items as i","i.id","user_requests.item_id")
                        ->first();
                if($order && ($order->status=="REJECTED" || $order->status=="SCHEDULED")){
                    $order->log= RiderLog::where('request_id',$order->id)->first();
                }
                return view('pages.trackMyOrder', compact('bookingID','dropoffNumber','order'));
            }
            else{
                return view('pages.trackMyOrder');
            }
        }
        catch(Exception $e){
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function contact(Request $request) {
        // dd($request->all());
        $json = array();
        
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'message'   => 'required',
            
            ]);
            
        try{
            
            $message = new ContactUs();
            $message->name          =   $request->name;
            $message->email         =   $request->email;
            $message->message       =   $request->message;
                                    
            $message->save();
            
            
            $json['success'] = ( $message->id ) ? true : false;
        
            return redirect()->back()->with('message', 'We have received your request successfully.We will get back within 24 hours.');
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
        
    
    }

       public function complaint_form(Request $request) {

        $json = array();
        //$data = str_replace(url('/'), '', url()->previous());
        //dd($data);
        //$u = explode('?', $data);
        //$url = explode('=', $u[1]);
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'transfer'   => 'required',
            'message'   => 'required',
            // 'phone'     => 'required',
            
            ]);
            
        try{
            
            $message = new Complaint();
            $message->name          =   $request->name;
            $message->email         =   $request->email;        
            // $message->subject       =   $request->subject;
            $message->transfer       =   $request->transfer;
            $message->message       =   $request->message;
            //$message->type         =    $url[1];
            
            // if ($request->hasFile('attachment')) {
            //     $file = $request->file('attachment');
            //     $name = time().'.'.$file->getClientOriginalExtension();
            //     $destinationPath = public_path('/uploads');
            //     $file->move($destinationPath, $name);
            //     $message->attachment    =   $name;
            // }
            
            $message->save();
         
            
            $json['success'] = ( $message->id ) ? true : false;
        
        // sendMail('Support',$request->email,$request->name,'New Query Received');
        return redirect()->back()->with('message', 'Query Saved Successfully');
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
        
    
    }

     public function sendMessage(Request $request) {
        $json = array();
        
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required',
            'message'   => 'required',
            'phone'     => 'required',
            
            ]);
            
        try{
            
            $message = new ContactUs();
            $message->name          =   $request->name;
            $message->email         =   $request->email;        
            $message->subject       =   $request->subject;
            $message->message       =   $request->message;
            $message->phone         =   $request->phone;
            
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $name = time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $name);
                $message->attachment    =   $name;
            }
            
            $message->save();
            
            
            $json['success'] = ( $message->id ) ? true : false;
        
        // sendMail('Contact us',$request->email,$request->name,'New Query Received');
        return response()->json( $json );
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
        
    
    }

    public function lostItemForm(Request $request) {
        $json = array();
        
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'lost_item'   => 'required',
            'phone'     => 'required',
            ]);
            
        try{
            $message = new LostItem();
            $message->name          =   $request->name;
            $message->email         =   $request->email;        
            $message->lost_item       =   $request->lost_item;
            $message->phone       =   $request->phone;
            $message->save();
            $json['success'] = ( $message->id ) ? true : false;
        
        return response()->json( $json );
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
    
    }
     public function blogs(Request $request){
          $blogs =Blog::orderBy('id','desc')->get();
                    
          return view('pages.blog',compact('blogs'));    
        }

        public function blog_detail($id){
        $blog_detail = Blog::where('id',$id)->first();
          
            return view('pages.blogdetail',compact('blog_detail'));
    }
        public function fare_estimate()
    {
        $services   = ServiceType::all(); 
        $sessiondata = session()->all();
        return view('pages.fare_estimate', compact(['services', 'sessiondata']));

    }
	
    public function ride_overview(){
        return $this->commonpage('ride-overview');
       }
    
    public function rates(){
        return view('pages.rates');
    }

    public function ride_safety(){
        return $this->commonpage('ride-safety');
       
    }
    public function airports(){
       return $this->commonpage('airports');

    }
    public function drive_overview(){
       return $this->commonpage('drive-overview');

    }
    public function requirements(){
       return $this->commonpage('requirements');

    }
    public function driver_app(){
       return $this->commonpage('driver-app');

    }
    public function vehicle_solutions(){
       return $this->commonpage('vehicle-solutions');

    }
    public function drive_safety(){
       return $this->commonpage('drive-safety');

    }
    public function local(){
       return $this->commonpage('local');
    }
    public function mylift($id){     
        return $this->commonpage(str::slug(strtolower($id), '-'));
    }

    // public function myliftxl(){
    //     return $this->commonpage('drive-safety');
    // }

    // public function myliftxll(){
    //     return $this->commonpage('drive-safety');
    // }

    // public function myliftgox(){
    //     return $this->commonpage('drive-safety');
    // }

    // public function common($val,$page){
     
    //  $data = Page::select($locale.'_title',$locale.'_description')->where('slug',$val)->first(); 
    //   return view('pages.'.$page,compact('data')); 
    // }

    public function helpPage()
    {  
        $data =Page::where('en_title','faq')->get();

        return view('pages.help',compact('data'));

    }
    public function refund()
    { 
        return view('pages.refund');
        
    }
    public function user()
    {
        return view('pages.user');

    }

    public function driver()
    {
        return view('pages.driver');

    }

    public function cities()
    {
        return $this->commonpage('cities');

    }

    public function how_it_works()
    { 
        $data =Page::where('en_title','how it work')->get();

        return view('pages.how_it_works',compact('data'));

    }

    public function stories()
    {   

        return view('pages.story');

    }
    public function review()
    {   

        return view('pages.review');

    }
    
    public function about_us() {
      return  $this->commonpage('about-us');
    }
    public function privacy() {
       return $this->commonpage('privacy-policy');
    }
     public function refund_policy() {
       return $this->commonpage('refund-policy');
    }
     public function riderterms() {
       return $this->commonpage('rider-terms-and-condition');
    }
    public function vendorterms() {
        return $this->commonpage('vendor-terms-and-condition');
     }
     public function help() {
      return  $this->commonpage('help');
    }
     public function terms_condition() {
       return $this->commonpage('terms-conditions');
    }
    public function why_us() {
        // return view('user.layout.why_us');
       return $this->commonpage('why-us');
    }
    public function commonpage($val) {
        $locale = $this->lang();
        $data = Page::select($locale.'_title',$locale.'_description')->where('slug',$val)->first();
        return view('pages.static',compact('data'));
    }
    
    
    public function download_page()
    {
        return view('downloadpage');
    }
	
	 

    // public function help()
    // {
    //     return view('user.layout.help');		
    // }
    
    public function driver_story () {

        $providers = DB::table('providers')
            ->join('provider_profiles', 'providers.id', '=', 'provider_profiles.provider_id')
            ->select('providers.*', 'provider_profiles.description')
           ->where('providers.status', 'approved')
            ->whereNotNull('provider_profiles.description')
            ->paginate(4);


        return view('user.layout.driver_story', compact('providers') );			
    
    }


    public function locale(Request $request ) {

              
        if( $request->has('locale') ) {

            Session::put('locale', $request->input('locale', 'en')  );
            Session::save();
        }

        return redirect()->back();

    }

    public function getAQuote(Request $request){
        $this->validate($request,[
            'name' => "required",
            'email' => 'email|required',
            'phone' => 'required',
            'captcha' => 'required|captcha'
        ]);
        Mail::send('emails.replyQuotation', ['data'=> 'Hello'], function ($m) use ($request) {
            $m->from('hulagimail@gmail.com', 'Hulagi Quotation');

            $m->to($request->email, $request->name)->subject('Hulagi Quotation');

            $m->attach(public_path('asset/img/hulagiServices.pdf'),[
                'as' => 'pricing.pdf',
                'mime' => 'application/pdf',
            ]);
            $m->attach(public_path('asset/img/Hulagi_Export_Rates.pdf'),[
                'as' => 'Hulagi_Export_Rates.pdf',
                'mime' => 'application/pdf',
            ]);
        });
        Mail::send('emails.requestQuotationLog', ['data'=> $request], function ($m) {
            $m->from('hulagimail@gmail.com', 'Hulagi');

            $m->to('hulagimarketing@gmail.com', 'Hulagi Marketing')->subject('Request for Quotation');
        });
        $quotes = $request->all();
        $quotes = QuoteRequest::create($quotes);


        return back()->with('message','Quotation sent to mail');
    }


    public function calculate_price(Request $request ) {

        
        $services 	= ServiceType::all();    
        $ip 	=   \Request::getClientIp(true);
        $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));

        return view('user.layout.calculate_price', compact('services', 'ip_details' ) );	
    }

    public function searchingajax()
    {
        $allrequests  = DB::table('user_requests')->select('id','status','created_at')->where('status', 'PENDING')->get();
        
        // foreach($allrequests as $request)
        // {
        //     $time = new \DateTime($request->created_at);
        //     $diff = $time->diff(new DateTime());
        //     $minutes = ($diff->days * 24 * 60) +
        //                ($diff->h * 60) + $diff->i;
        //     if($minutes > 2)
        //     {
        //         DB::table('user_requests')
        //             ->where('status', 'PENDING')
        //             ->update(['status' => "CANCELLED"]);
        //         //return 1;
        //     }
        // }
    }
    
    public function ajaxforofflineprovider(Request $request)
    {
        $allrequests  = DB::table('providers')->select('updated_at','id')->where('status','!=', 'riding')->get();
        
        foreach($allrequests as $request)
        {
            $time = new \DateTime($request->updated_at);
            $diff = $time->diff(new DateTime());
            $minutes = ($diff->days * 24 * 60) +
                       ($diff->h * 60) + $diff->i;
            if($minutes > 2)
            {
                $data = ProviderService::where('provider_id',$request->id)->update(['status' =>'offline']);
            }
        }
        //return $expected;
    }
    
    public function providerDocumentExpiryNotification(){
        $docs = ProviderDocument::with('provider','document')->where('expires_at','>=', Carbon::now()->toDateString())->get();
        foreach($docs as $doc){
           if(!empty($doc->provider) && !empty($doc->document)){
               $days = Carbon::parse($doc->expires_at)->diffInDays(Carbon::parse(Carbon::now()->toDateString()));
              
               if($days<=$doc->document->expire){
                   $msg="Your document ".$doc->document->name." will expire in ".$days." days. Please update your document";
                   $title="Document Expiry Notification";
                    $notification = new PushNotification;
                    $notification->type = 2;
                    $notification->title = $title;
                    $notification->zone = 0;
                    $notification->notification_text = $msg;
                    $notification->from_user = 1;
                    $notification->to_user = $doc->provider->id;
                    $notification->expiration_date = Carbon::parse($doc->expires_at);
                    $notification->save();
                   (new SendPushNotification)->notifyProvider($doc->provider->id,$title,$msg,'admin','');
                   
               }
                  
           }
        }
        
    }

    public function internationalQuote()
    {
        return \File::get(public_path('internationalrates') . '/internationalrates.html');
    }

}
