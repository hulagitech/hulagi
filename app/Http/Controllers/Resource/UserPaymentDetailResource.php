<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use App\User;
use App\KhaltiDetail;
use App\BankDetail;
// use App\UserPaymentDetail;


class UserPaymentDetailResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $payment_infos = UserPaymentDetail::all();

        // return view('user.account.wallet')->with('payment_infos', $payment_infos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createKhalti()
    {
        return view('user.paymentdetail.add_khalti');
    }

    public function createBank()
    {
        return view('user.paymentdetail.add_bank');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // try{
        //     if($request->khalti_id!=Null && $request->bank_name==Null)
        //     {
        //         $khalti = new KhaltiDetail;
        //         $khalti->user_id = Auth::user()->id;
        //         $khalti->khalti_id = $request->input('khalti_id');
        //         $khalti->Khalti_username = $request->input('khalti_username');
        //         $khalti->save();
        //     }else if($request->khalti_id==Null && $request->bank_name!=Null){

        //         $bank = new BankDetail;
        //         $bank->user_id = Auth::user()->id;
        //         $bank->bank_name = $request->input('bank_name');
        //         $bank->branch = $request->input('branch');
        //         $bank->ac_no = $request->input('ac_no');
        //         $bank->ac_name = $request->input('ac_name');
        //         $bank->save();
        //     }else if($request->khalti_id!=Null && $request->bank_name!=Null){
                
        //         $khalti = new KhaltiDetail;
        //         $khalti->user_id = Auth::user()->id;
        //         $khalti->khalti_id = $request->input('khalti_id');
        //         $khalti->Khalti_username = $request->input('khalti_username');
        //         $khalti->save();

        //         $bank = new BankDetail;
        //         $bank->user_id = Auth::user()->id;
        //         $bank->bank_name = $request->input('bank_name');
        //         $bank->branch = $request->input('branch');
        //         $bank->ac_no = $request->input('ac_no');
        //         $bank->ac_name = $request->input('ac_name');
        //         $bank->save();
        //     }else{
        //         return back()->with('flash_error', 'Incomplete Information!');
        //         // return back()->with('flash_success', 'Your Payment Information Save Successfully!');
        //     }

        //     return redirect('/wallet')->with('status', 'Payment information saved Successfully!!!');
        // }
        // catch (Exception $e) {
        //     return back()->with('flash_error', 'Submit Unsuccess!!!');
        // }
    }

    public function storeKhalti(Request $request)
    {   
        try{
            $khalti = new KhaltiDetail;
            $khalti->user_id = Auth::user()->id;
            $khalti->khalti_id = $request->input('khalti_id');
            $khalti->Khalti_username = $request->input('khalti_username');
            $khalti->save();
            
            return redirect('/wallet')->with('status', 'Payment information saved Successfully!!!');
        }
        catch (Exception $e) {
            return back()->with('flash_error', 'Submit Unsuccess!!!');
        }
    }

    public function storeBank(Request $request)
    {   
        try{
            $bank = new BankDetail;
            $bank->user_id = Auth::user()->id;
            $bank->bank_name = $request->input('bank_name');
            $bank->branch = $request->input('branch');
            $bank->ac_no = $request->input('ac_no');
            $bank->ac_name = $request->input('ac_name');
            $bank->save();
            
            return redirect('/wallet')->with('status', 'Payment information saved Successfully!!!');
        }
        catch (Exception $e) {
            return back()->with('flash_error', 'Submit Unsuccess!!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the Khalti Detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editKhaltiDetail(Request $request)
    {
        try{
            $user=Auth::user()->id;
            $khaltidetail = KhaltiDetail::where('user_id',$user)->first();

            $khaltidetail->khalti_id = $request->input('khalti_id');
            $khaltidetail->khalti_username = $request->input('khalti_username');
            $khaltidetail->update();

            return redirect('/wallet')->with('status', 'Khalti details update unsuccess!!!');
        }
        catch(Exception $e) {
            dd('Exception', $e);
            return back()->with('flash_error', 'Update Unsuccess');
        }
    }

    /**
     * Show the form for editing the Bank Detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editBankDetail(Request $request)
    {
        try{
            $user=Auth::user()->id;
            $bankdetail = BankDetail::where('user_id',$user)->first();

            $bankdetail->bank_name = $request->input('bank_name');
            $bankdetail->branch = $request->input('branch');
            $bankdetail->ac_no = $request->input('ac_no');
            $bankdetail->ac_name = $request->input('ac_name');
            $bankdetail->update();

            return redirect('/wallet')->with('status', 'Bank details update unsuccess!!!');
        }
        catch(Exception $e) {
            dd('Exception', $e);
            return back()->with('flash_error', 'Update Unsuccess');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
