<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Esewa;
use App\Items;
use Validator;
use App\Comment;
use App\Provider;
use App\BankDetail;
use App\KhaltiDetail;
use App\UserRequests;
use App\PaymentHistory;
use App\PaymentRequest;
use Illuminate\Http\Request;

class NewUserApiController extends Controller
{
    public function resetForgetPassword(Request $request){
        
        try{
            $validator = Validator::make($request->all(), [
                'otp' => 'required|exists:users,otp|min:6',
                'password' => 'required|min:6',
            ]);
            // $this->validate($request, [
            //     'otp' => 'required|exists:users,otp|min:6',
            //     'password' => 'required|min:6',
            // ]);
        if($validator->fails()){
            return response()->json(['msg' => 'please check your Otp']);
        }

            $User = User::where('otp',$request->otp)->first();
            $User->password = bcrypt($request->password);
            $User->otp=0;
            $User->save();
            return response()->json(['msg' => 'Password Reset']);

        }catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
            
        }
    }
    public function storeKhalti(Request $request)
    {   
        try{
            $this->validate($request, [
                'khalti_id' => 'required',
                'khalti_username' => 'required',
            ]);
            $already=KhaltiDetail::where('user_id',Auth::user()->id)
                        ->first();
            if(!$already){
                $khalti = new KhaltiDetail;
                $khalti->user_id = Auth::user()->id;
                $khalti->khalti_id = $request->khalti_id;
                $khalti->Khalti_username = $request->khalti_username;
                $khalti->save();
                return response()->json(['message' => 'Khalti Added Successfully']);
            }else{
                $already->khalti_id=$request->khalti_id;
                $already->khalti_username=$request->khalti_username;
                $already->save();
                return response()->json(['message' => 'Khalti Updated Successfully']);
            }        
        }
        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }
    
    public function storeBank(Request $request){
        try{
            $already=BankDetail::where('user_id',Auth::user()->id)
                        ->first();
            if(!$already){

                $bank = new BankDetail;
                $bank->user_id = Auth::user()->id;
                $bank->bank_name = $request->bank_name;
                $bank->branch = $request->branch;
                $bank->ac_no = $request->ac_no;
                $bank->ac_name = $request->ac_name;
                $bank->save();
                return response()->json(['message' => 'Bank Added Successfully']);
            }
            else{
                $already->bank_name = $request->bank_name;
                $already->branch = $request->branch;
                $already->ac_no = $request->ac_no;
                $already->ac_name = $request->ac_name;
                $already->save();
                return response()->json(['message' => 'Bank Updated Successfully']);
                
            }       
        }
        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function addComment(Request $request,$id){
        try{
        $this->validate($request,[
            'comment'=> 'required',
        ]);

         $comment = Comment::create([
                'request_id' => $id,
                'comments' => $request->comment ,
                'authorised_type' => 'User',
                'authorised_id' => Auth::user()->id,
            ]);
        return response()->json(['message' => 'Comment Added Successfully']);
        }
        catch(Exception $e){
            return response()->json(['error' =>"Something Went Wrong"]);
        }

    }
    public function request_money(Request $request)
    {
        $id=Auth::user()->id;
        $user=User::findOrFail($id);
        $existsRequest= PaymentRequest::where('user_id',$id)->where('is_paid',false)->count();
        if($existsRequest==0){
            $paymentRequest = new PaymentRequest();
            $paymentRequest->user_id = $id;
            $paymentRequest->requested_amt = $request->requested_amt;
            $paymentRequest->save();
            
            return response()->json(['message' => 'Your Request Has been Submitted Successfully']);
        }
        else{
            return response()->json(['message' => 'Reuqest Has already been Submitted']);
        }
    }
    public function openComment()
    {
        try {
            // $order=UserRequests::where('id',137)->get();
            // return $order;
            $UserRequests = UserRequests::where('user_id', Auth::user()->id)->whereHas('comment', function ($query) {
                $query->where('comment_status', 1);
            })->paginate(50);
            $data=[];
            $index=0;
            foreach($UserRequests as $key => $value)
            {
                $data[$index]['ride']=$value;
                $data[$index]['item']=Items::where('id',$value->item_id)->first();
                if($value->status!="PENDING" && $value->status!="COMPLETED" && $value->status!="REJECTED" && $value->status!="CANCELLED"){
                    $data[$index]['rider']=Provider::where('id',$value->provider_id)
                    ->select(array('first_name','mobile'))
                    ->first();
                    }
                    else{
                        $data[$index]['rider']=array('first_name'=>null,'mobile'=>null);
                    }
                   
                $data[$index]['comment']=Comment::where('request_id',$value->id)->orderby('id','asce')->select('comments')->first();
                 $index++;
            }
            return $data;
                // return response()->json([
                //     'comments' => $data,
                // ]);
            
           
        } 
        catch (Exception $e) 
        {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function allComments($id)
    {
        $comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();
        return $comments;
        // return response()->json([
        //     'comments' => $comments
        // ]);
    }

    public function getBankDetail(){
        try{

            $BankDetail=BankDetail::where('user_id',Auth::user()->id)->get();
            return response()->json(['BankDetail' => $BankDetail]);
        }
        catch (Exception $e) {
            return response()->json(['error' =>"something went wrong"]);
        }
    }
    public function paymentWebsite(Request $request){
    try{
         $this->validate($request, [

                'amt' 	=> 'required',
                'oid' 	=> 'required',
                'refId' 	=> 'required',
                'device_id' => 'required',
            
            ]);
            $paymentHistory = new PaymentHistory;
            $paymentHistory->user_id = Auth::user()->id;
            $paymentHistory->changed_amount = $request->amt*95.5/100;
            $paymentHistory->remarks ="PAYMENT DONE FROM WEBSITE THROUGH ESEWA";
            $paymentHistory->save();
            Auth::user()->wallet_balance =Auth::user()->wallet_balance + $request->amt;
            Auth::user()->save();
            // dd($user->wallet_balance);
            // dd($user);
            $esewa= null;
            $esewa['User_ID']=Auth::user()->id;
            $esewa['User_Name']=Auth::user()->first_name;
            $esewa['Load_Amount']=$request->amt*95.5/100;
            $esewa['Payment_ID']=$request->oid;
            $esewa['Reference_ID']=$request->refId;

        //to create esewa table

        $esewa=Esewa::create($esewa);
        return \response()->json(['message' => 'Payment Successful']);
    }
    catch(Exception $e){            
        return response()->json(['error' =>"Something Went Wrong"]);
    }

    }
    
}