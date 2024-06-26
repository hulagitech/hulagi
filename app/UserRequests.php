<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRequests extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'provider_id',
        'user_id',
        'current_provider_id',
        'service_type_id',
        'status',
        'comment_status',
        'returned',
        'cancelled_by',
        'paid',
        'distance',
        'zone1',
        'zone2',
        'item_id',
        's_latitude',
        'd_latitude',
        's_longitude',
        'd_longitude',
        'paid',
        's_address',
        'd_address',
        'assigned_at',
        'schedule_at',
        'started_at',
        'amount_customer',
        'finished_at',
        'use_wallet',
        'user_rated',
        'provider_rated',
        'surge',
        'created_at',
        'special_note',
        'cod',
        'is_sign',
        'fare',
        'fare_half_kg',
        'weight',
        'cargo',
        'returned_to_hub',
        'return_rider',
        'dept_id',
        'rejected_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'assigned_at',
        'schedule_at',
        'started_at',
        'finished_at',
    ];

    /**
     * ServiceType Model Linked
     */
    public function service_type()
    {
        return $this->belongsTo('App\ServiceType');
    }

    /**
     * UserRequestPayment Model Linked
     */
    public function payment()
    {
        return $this->hasOne('App\UserRequestPayment', 'request_id');
    }

    public function riderLog()
    {
        return $this->hasOne('App\RiderLog', 'request_id');
    }

    public function reward()
    {
        return $this->hasOne('App\Reward', 'request_id');
    }

    public function referral()
    {
        return $this->hasOne('App\Referral', 'trip_id');
    }

    public function lost_item()
    {
        return $this->hasOne('App\LostItem', 'trip_id');
    }



    /**
     * UserRequestRating Model Linked
     */
    public function rating()
    {
        return $this->hasOne('App\UserRequestRating', 'request_id');
    }

    /**
     * UserRequestRating Model Linked
     */
    public function filter()
    {
        return $this->hasMany('App\RequestFilter', 'request_id');
    }
    public function comment()
    {
        return $this->hasMany('App\Comment', 'request_id', 'id')->orderBy('id', 'desc');
    }

    public function RecentComment(){
        return $this->hasOne('App\Comment', 'request_id', 'id')->orderBy('id', 'desc');
    }
    /**
     * The user who created the request.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function item()
    {
        return $this->belongsTo('App\Items');

        //return $this->belongsToMany('App\Items', 'item_has_images', 'item_id', 'image_id');

    }
    /**
     * The provider assigned to the request.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider', 'provider_id', 'id');
    }

    public function returnRider()
    {
        return $this->belongsTo('App\Provider', 'return_rider', 'id');
    }

    public function userrequestpayment()
    {
        return $this->belongsTo('App\UserRequestPayment');
    }

    public function provider_service()
    {
        return $this->belongsTo('App\ProviderService', 'provider_id', 'provider_id');
    }

    public function scopePendingRequest($query, $user_id)
    {
        return $query->where('user_id', $user_id)
            ->whereNotIn('status', ['CANCELLED', 'COMPLETED', 'SCHEDULED']);
    }

    public function scopeRequestHistory($query)
    {
        return $query->orderBy('user_requests.created_at', 'desc')
            ->with('user', 'payment', 'provider');
    }

    public function scopeUserTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)
            ->where('user_requests.status', '=', 'COMPLETED')
            ->orderBy('user_requests.created_at', 'desc')
            ->select('user_requests.*')
            ->with('payment', 'service_type');
    }

    public function scopeAllUserTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)
            // ->where('user_requests.status', '=', 'COMPLETED')
            ->orderBy('user_requests.created_at', 'desc')
            ->select('user_requests.*')
            ->with('payment', 'service_type');
    }

    public function scopeUserUpcomingTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)
            ->where('user_requests.status', '=', 'SCHEDULED')
            ->orderBy('user_requests.created_at', 'desc')
            ->select('user_requests.*')
            ->with('service_type', 'provider');
    }

    public function scopeProviderUpcomingRequest($query, $user_id)
    {
        return $query->where('user_requests.provider_id', '=', $user_id)
            ->where('user_requests.status', '=', 'SCHEDULED')
            ->select('user_requests.*')
            ->with('service_type', 'user', 'provider');
    }

    public function scopeUserTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)
            ->where('user_requests.id', '=', $request_id)
            ->where('user_requests.status', '=', 'COMPLETED')
            ->select('user_requests.*')
            ->with('payment', 'service_type', 'user', 'provider', 'rating', 'item.itemImage');
    }

    public function scopeAllUserTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)
            ->where('user_requests.id', '=', $request_id)
            // ->where('user_requests.status', '=', 'COMPLETED')
            ->select('user_requests.*')
            ->with('payment', 'service_type', 'user', 'provider', 'rating');
    }

    public function scopeUserOngoingTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)

            ->whereIn('user_requests.status', ['ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED'])
            ->select('user_requests.*')
            ->with('service_type', 'user', 'provider');
    }

    public function scopeUserUpcomingTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', '=', $user_id)
            ->where('user_requests.id', '=', $request_id)
            ->where('user_requests.status', '=', 'SCHEDULED')
            ->select('user_requests.*')
            ->with('service_type', 'user', 'provider', 'item.itemImage');
    }

    public function scopeUserRequestStatusCheck($query, $user_id, $check_status)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->where('user_requests.user_rated', 0)
            ->whereNotIn('user_requests.status', $check_status)
            ->select('user_requests.*')
            ->with('user', 'provider', 'service_type', 'provider_service', 'rating', 'payment', 'item.itemImage');
    }

    public function scopeUserRequestAssignProvider($query, $user_id, $check_status)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->where('user_requests.user_rated', 0)
            //->where('user_requests.provider_id',0)
            ->whereIn('user_requests.status', $check_status)
            ->select('user_requests.*')
            ->with('filter');
    }

    // User relationship with Ticket
    public function dept()
    {
        return $this->belongsTo('App\Department', 'dept_id');
    }

    public function zone_1()
    {
        return $this->belongsTo("App\Zones", 'zone1');
    }
    public function zone_2()
    {
        return $this->belongsTo("App\Zones", 'zone2');
    }
    public function dispatchList()
    {
        return $this->hasOne("App\ZoneDispatchList", 'request_id');
    }
}
