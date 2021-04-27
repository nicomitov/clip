<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'client_id', 'subscription_type_id', 'start_date', 'end_date', 'comments',
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'start_date' => 'datetime',
    //     'end_date' => 'datetime',
    // ];

    public function emails()
    {
        return $this->belongsToMany(ClientEmail::class, 'subscription_client_email');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function type()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function getActiveSubscriptions()
    {
        return Subscription::whereHas('client', function($query) {
                                $query->where('is_active', 1);
                           })
                           ->where('start_date', '<=', Carbon::now()->toDateString())
                           ->where('end_date', '>=', Carbon::now()->toDateString());
    }

    public static function getInactiveSubscriptions()
    {
        return Subscription::where('end_date', '<', Carbon::now()->toDateString())
                           ->orWhereHas('client', function($query) {
                                $query->where('is_active', 0);
                           });
    }

    public static function getExpiringSubscriptions()
    {
        return Subscription::whereHas('client', function($query) {
                                $query->where('is_active', 1);
                           })
                           ->where('end_date', '<=', Carbon::now()->addDays(7)->toDateString())
                           ->where('end_date', '>=', Carbon::now()->toDateString());
    }

    public static function getSubscriptionsByStatus($status)
    {
        if ($status =='active') {
            $subscriptions = self::getActiveSubscriptions()->get();
        } elseif ($status == 'inactive') {
            $subscriptions = self::getInactiveSubscriptions()->get();
        } elseif ($status == 'expiring') {
            $subscriptions = self::getExpiringSubscriptions()->get();
        }

        return $subscriptions;
    }

    public function setActivity(string $event)
    {
        return activity($this->type->name)
            ->causedBy(auth()->user())
            ->performedOn($this)
            ->withProperties([
                'attributes' => [
                    'Client' => $this->client->name,
                    // 'Type' => $this->type->name,
                    'E-Mails' => implode(',<br>', $this->emails->pluck('email')->toArray()),
                    'Topics' => implode(', ', $this->topics->pluck('number')->toArray()),
                    'Start Date' => $this->start_date->format('j M Y'),
                    'End Date' => $this->end_date->format('j M Y'),
                    'Comment' => $this->client->comment
                ]
            ])
            ->log($event);
    }
}
