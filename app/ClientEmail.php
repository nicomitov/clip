<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientEmail extends Model
{
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['client'];

    protected $fillable = ['client_id', 'email'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function SUBSCRIPTIONS()
    {
        return $this->belongsToMany(Subscription::class, 'subscription_client_email');
    }
}
