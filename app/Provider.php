<?php

namespace App;

use App\Notifications\ProviderResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Provider extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type',
        'mobile',
        'address',
        'picture',
        'gender',
        'latitude',
        'device_id',
        'device_token',
        'longitude',
        'status',
        'avatar',
        'social_unique_id',
        'fleet','term_n',
        'logged_in',
        'zone_id',
        'earning',
        'payable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'updated_at'
    ];
     public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The services that belong to the user.
     */
    public function service()
    {
        return $this->hasOne('App\ProviderService');
    }

    /**
     * The services that belong to the user.
     */
    public function incoming_requests()
    {
        return $this->hasMany('App\RequestFilter')->where('status', 0);
    }

    /**
     * The services that belong to the user.
     */
    public function requests()
    {
        return $this->hasMany('App\RequestFilter');
    }

    /**
     * The services that belong to the user.
     */
    public function profile()
    {
        return $this->hasOne('App\ProviderProfile');
    }

    /**
     * The services that belong to the user.
     */
    public function device()
    {
        return $this->hasOne('App\ProviderDevice');
    }

    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany('App\UserRequests');
    }

    /**
     * The services accepted by the provider
     */
    public function accepted()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                    ->where('status','!=','CANCELLED');
    }
    public function provider_Accepted()
    {
        return $this->hasMany('App\UserRequests','provider_id')
        ->where('status','ACCEPTED');
    }

    /**
     * service cancelled by provider.
     */
    public function cancelled()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','CANCELLED');
    }
    public function cancelledRemaining()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','CANCELLED')->where('returned_to_hub',0)
                ->where('returned',0);
    }
    public function rejected()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','REJECTED');
            }
    
    public function rejectedRemaining(){
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','REJECTED')->where('returned_to_hub',0)
                ->where('returned',0);
                
    }
    public function rejectedreturned(){
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','REJECTED')->where('returned_to_hub',1);
    }
    public function schedule()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','SCHEDULED');
    }
    public function delivering()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','DELIVERING');
    }
    public function assigned()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','ASSIGNED');
    }
    public function Pickedup()
    {
        return $this->hasMany('App\UserRequests','provider_id')
                ->where('status','PICKEDUP');
    }


    /**
     * The services that belong to the user.
     */
    public function documents()
    {
        return $this->hasMany('App\ProviderDocument');
    }

    /**
     * The services that belong to the user.
     */
    public function document($id)
    {
        return $this->hasOne('App\ProviderDocument')->where('document_id', $id)->first();
    }

    /**
     * The services that belong to the user.
     */
    public function pending_documents()
    {
        return $this->hasMany('App\ProviderDocument')->where('status', 'ASSESSING')->count();
    }

    public function pickedLog(){
        return $this->hasMany('App\RiderLog','pickup_id');
    }

    public function completedLog(){
        return $this->hasMany('App\RiderLog','complete_id');
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ProviderResetPassword($token));
    }

    public function zone(){
        return $this->belongsTo('App\Zones', 'zone_id');
    }

    public function zones(){
        return $this->hasOne('App\Zones','id', 'zone_id');
    }

    public function settlement(){
        return $this->hasOne('App\settlementLog','provider_id')->where('type','=','Rider');
    }

     public function activeProvider(){
        return $this->hasMany('App\UserRequests','provider_id');
    }
}
