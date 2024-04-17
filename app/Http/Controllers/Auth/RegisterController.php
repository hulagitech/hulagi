<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Rules\email_validator;
use App\Rules\phone_validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/trips';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
		
		// $this->middleware('accesspage', ['only' => ['showRegistrationForm']]); 
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'mobile' =>  ['required', new phone_validator],
            'email' => ['required', 'email', new email_validator],
            'password' => 'required|min:6s',
            'referral_code' => 'exists:users',
            'terms_conditions' => 'required'

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      
        try{
            if(strlen($data['referral_code'])>0){
                $refer_id=User::where('referral_code',$data['referral_code'])->select('id')->get()->first();
                $data = User::create([
                    'first_name' => $data['first_name'],
                    'company_name' => $data['company_name'],
                    'mobile' => $data['mobile'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'payment_mode' => 'CASH',
                    'refer_id' => $refer_id->id,
                    'Business_Person'=>$data['BORP'],
                    'VAT_PAN'=>$data['VAT/PAN'],
                    'user_type' => env('APP_NAME', 'Hulagi'),
                ]);
            }
            else{
                $data = User::create([
                    'first_name' => $data['first_name'],
                    'company_name' => $data['company_name'],
                    'mobile' => $data['mobile'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'Business_Person' => $data['BORP'],
                    'VAT_PAN' => $data['VAT/PAN'],
                    'payment_mode' => 'CASH',
                    'user_type' => env('APP_NAME', 'Hulagi'),
                ]);
            }
        
            $name=explode(" ",$data->first_name);
            $referral=strtolower($name[0]).$data->id;
            $data->referral_code=$referral;
            
            $data->save();
            // sendMail('Welcome',$data['email'],$data['first_name'],'Registration');
            // send welcome email here
            $this->sendWelcomeSMS($data['mobile'], $data['first_name']);
            Mail::send('emails.newuser', ['data'=> $data], function ($m) {
                $m->from('hulagimail@gmail.com', 'Hulagi');
    
                $m->to('innswift@gmail.com', 'Hulagi Marketing')->cc('hulagimarketing@gmail.com')->subject('New user sign up');
            });
            Mail::send('emails.newuserlogin', ['data'=> $data], function ($m) use ($data) {
                $m->from('hulagimail@gmail.com', 'Hulagi');
    
                $m->to($data['email'], $data['first_name'])->subject('Hulagi Accounts');
            });
                
            return $data;
        }
            catch (Exception $e) {
        
            return back()->with('flash_error', 'Registration Not Found');
        }
    }

    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    public function sendWelcomeSMS($to, $username) {
        $link = "https://api.sparrowsms.com/v2/sms/";
        $msg = "Congratulations! You have successfully signed up for Hulagi Logistics. You can start placing an order at hulagi.com / Call for more info 01-5912256/57 / 9803077739";

        $data = [
            'token' => env("SPARROW_TOKEN"),
            'from' => 'hulagi',
            'to' => $to,
            'text'=> $msg
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_exec($curl);
        curl_close($curl);

    }
}
