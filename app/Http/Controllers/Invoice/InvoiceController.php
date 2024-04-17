<?php

namespace App\Http\Controllers\Invoice;

use App\Esewa;
use App\khalti;
use App\UserInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
     public function userInvoice()
    {
        $invoices=UserInvoice::where("user_id",Auth::user()->id)->get();
        return view('user.invoice.index',compact('invoices'));
    }
     public function userInvoiceDetail($id)
    {
        
        $payments=UserInvoice::find($id);
        return view('user.invoice.detail',compact('payments'));
    }
    public function esewa()
    {
        $esewa=Esewa::where('User_ID',Auth::user()->id)->orderby('created_at','asc')->get();
        return view('user.invoice.esewa',compact('esewa'));
    }
    public function Khalti(){
        $khalti=khalti::where('User_ID',Auth::user()->id)->orderby('created_at','asc')->get();
        return view('user.invoice.khalti',compact('khalti'));
    }
    public function storeToken(Request $request)
    {
        if (auth()->guard('admin')->check()) {
        auth()->guard('admin')->user()->update(['device_key'=>$request->token]);
        }
        elseif(auth()->guard('web')->check()){
            auth()->guard('web')->user()->update(['device_key'=>$request->token]);
        }
        return response()->json(['Token successfully stored.']);
    }

    public function getNotification(Request $request)
    {
        return view('user.layout.partials.notify');
    }
}
