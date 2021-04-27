<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
