<?php

namespace App\Http\Controllers;

use App\User;
use App\Esewa;
use App\PaymentHistory;
use Illuminate\Http\Request;
use App\EsewaPaymentTroughMail;

class EmailEsewa extends Controller
{
    public function index($token){
        $esewa=EsewaPaymentTroughMail::where('EsewaToken',$token)->first();
        if($esewa==null)
        {
            return redirect('/');
        }
        $count=Esewa::where('Payment_ID',$token)->count();
        
        if($count==0){
            return  view('pages.esewa',compact('esewa'));
        }
        else{
            return redirect('/');
        }
    }
    public function pay(Request $request,$id)
    {
        // dd($id);
        $status = $request->q;
        // dd($status);
        $oid = $request->oid;
        $refId = $request->refId;
        $amt = $request->amt;
        // dump($oid, $refId, $amt);

        if ($status == 'su') {
            $url = "https://esewa.com.np/epay/transrec";
            $data = [
                'amt' => $amt,
                'rid' => $refId,
                'pid' => $oid,
                'scd' => env('Merchant_Key'),
            ];

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            if (strpos($response, "Success") == true) {
                $this->validate($request, [
                    'amt'=>'required',
                    'oid' => 'required',
                    'refId' => 'required',

                ]);
                try{
                    $user = User::findOrFail($id);
                    $paymentHistory = new PaymentHistory;
                    $paymentHistory->user_id = $user->id;
                    $paymentHistory->changed_amount = $request->amt;
                    $paymentHistory->remarks ="PAID THROUGH ESEWA Via Mail";
                    $paymentHistory->save();
                    $user->wallet_balance =$user->wallet_balance + $request->amt;
                    $user->save();
                    // dd($user->wallet_balance);
                    // dd($user);
                    $esewa= null;
                    $esewa['User_ID']=$user->id;
                    $esewa['User_Name']=$user->first_name;
                    $esewa['Amount']=$request->amt;
                    $esewa['Payment_ID']=$request->oid;
                    $esewa['Reference_ID']=$request->refId;

                    //to create esewa table

                    $esewa=Esewa::create($esewa);



                    return redirect('/')->with('flash_Success', 'Your Pyamnet Has been done');
                }
                catch (Exception $e) {
                    return redirect('/')->with('flash_error', 'Transaction Failed');
                }

            } else {
                return redirect('/')->with('flash_error', 'Transaction Failed');
            }
        } else {
            return redirect('/')->with('flash_error', 'Transaction Failed');
        }
    }
}
