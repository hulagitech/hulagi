<?php

namespace App;

use Auth;
use App\Ticket;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'company_name', 'email', 'mobile', 'picture', 'password', 'device_type','device_token','login_by', 'payment_mode','social_unique_id','device_id','wallet_balance','refer_id','referral_code', 'total_points', 'referral_used','device_key','Business_Person','VAT_PAN'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    public function reward()
    {
        return $this->hasOne('App\Reward', 'user_id');
    }

    public function referral()
    {
        return $this->hasOne('App\Referral', 'user_id');
    }

    public function payment_info(){
        return $this->hasOne('App\UserPaymentDetail','user_id');
    }
    public function payment_request(){
        return $this->hasMany('App\PaymentRequest','user_id');
    }
    public function unreadComments($id){
        $unread= UserRequests::where('user_id', $id)->where('comment_status',1)->count();
        return $unread;
    }

    public function openTicket(){
        $open= Ticket::where('user_id', Auth::user()->id)->where('status','open')->count();
        return $open;
    }

    public function unreadTicketComment($id){
        $unreadNo = TicketComment::join('tickets', 'tickets.id', '=', 'ticket_comments.ticket_id')
                    ->where('tickets.user_id', '=', $id)
                    ->where('is_read_user', "1")->count();
        return $unreadNo;
    }
    public function khaltiDetail(){
        return $this->hasOne('App\KhaltiDetail','user_id');
    }
    public function bankDetail(){
        return $this->hasOne('App\BankDetail','user_id');
    }
    public function Settlement(){
        return $this->hasOne('App\settlementLog','provider_id')->where('type','=','User');
    }

    public function new_wallet($id){
        DB::beginTransaction();
        //new wallet
        $totalOrder = UserRequests::where('user_id', $id)
            ->where('status', 'COMPLETED')
            ->where('created_at', '>=', '2020-10-15')
            ->select([DB::raw("SUM(cod) as sum_cod"),
                DB::raw("SUM(amount_customer) as sum_fare")])
            ->first();
        $totalReject = UserRequests::where('user_id', $id)
            ->where('status', 'REJECTED')
            ->where('created_at', '>=', '2020-10-15')
            ->select([DB::raw("SUM(amount_customer) as sum_fare")])
            ->first();
        $totalPaid = PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')
            ->where('remarks', 'NOT LIKE', '%adjustment%')
            ->where('user_id', $id)
            ->where('created_at', '>=', '2020-10-15')
            ->select([
                DB::raw("SUM(changed_amount) as paid"),
            ])
            ->first();
        DB::commit();
        $newPayment = $totalOrder->sum_cod - $totalOrder->sum_fare - $totalReject->sum_fare + $totalPaid->paid;
        return $newPayment;
    }

    public function domain(){
        return $this->hasOne('App\NextUserDashboard','APP_NAME','user_type');
    }

}
