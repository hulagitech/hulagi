<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Exception;

use App\User;
use App\KhaltiDetail;


class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $details = KhaltiDetail::where('status', true)->paginate(100);

            return view('account.wallet.khalti_detail', compact('details'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('account.wallet.create_khaltiDetail', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $khalti = new KhaltiDetail;
            $khalti->user_id = $request->input('user_id');
            $khalti->khalti_id = $request->input('khalti_id');
            $khalti->Khalti_username = $request->input('khalti_username');
            $khalti->createdby_ac = 1;
            $khalti->save();

            //return back()->with('flash_success', 'Your Payment Information Save Successfully!');
            return redirect('/account/khalti_infos')->with('status', 'Payment information saved Successfully!!!');
        }
        catch (Exception $e) {
            //dd("Exception", $e);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $users = User::all();
            $detail = KhaltiDetail::findOrFail($id);
            // $depts = Department::all();
            
            return view('account.wallet.edit_khaltiDetail', compact('detail', 'users'));
        } catch (ModelNotFoundException $e) {
            return $e;
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
        try {
            $bank = KhaltiDetail::findOrFail($id);
            $bank->user_id = $request->user_id;
            $bank->khalti_id = $request->khalti_id;
            $bank->khalti_username = $request->khalti_username;
            $bank->status = $request->status;
            // $bank->createdby_ac = 1;
            $bank->save();

            // return back()->with('flash_success', 'Branch Manager Updated Successfully!');
            return redirect('/account/khalti_infos')->with('status', 'Payment information saved Successfully!!!');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Branch Manager Not Found!');
        }
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
