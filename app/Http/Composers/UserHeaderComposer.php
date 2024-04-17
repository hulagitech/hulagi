<?php

namespace App\Http\Composers;

use App\PaymentHistory;
use App\UserRequests;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserHeaderComposer {
    public function compose(View $view){
        DB::beginTransaction();
        $user=Auth::user();
        //new wallet
        $totalOrder = UserRequests::where('user_id', $user->id)
            ->where('status', 'COMPLETED')
            ->where('created_at', '>=', '2020-10-15')
            ->select([DB::raw("SUM(cod) as sum_cod"),
                DB::raw("SUM(amount_customer) as sum_fare")])
            ->first();
        $totalReject = UserRequests::where('user_id', $user->id)
            ->where('status', 'REJECTED')
            ->where('created_at', '>=', '2020-10-15')
            ->select([DB::raw("SUM(amount_customer) as sum_fare")])
            ->first();
        $totalPaid = PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')
            ->where('remarks', 'NOT LIKE', '%adjustment%')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', '2020-10-15')
            ->select([
                DB::raw("SUM(changed_amount) as paid"),
            ])
            ->first();
        DB::commit();
        $newPayment = $totalOrder->sum_cod - $totalOrder->sum_fare - $totalReject->sum_fare + $totalPaid->paid;
        $view->with('user_wallet',$newPayment);
    }
    
}