<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'number', 'name',
    ];

    public function getRouteKeyName()
    {
        return 'number';
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class);
    }

    public static function getActiveTopics()
    {
        return Topic::whereHas('subscriptions', function ($query) {
                $query->where('start_date', '<=', Carbon::now())
                      ->where('end_date', '>=', Carbon::now());
            })->get();
    }

    public static function getInactiveTopics()
    {
        return Topic::whereDoesntHave('subscriptions', function ($query) {
                $query->where('start_date', '<=', Carbon::now())
                      ->where('end_date', '>=', Carbon::now());
            })->get();
    }

    public static function getTopicsByStatus(string $status)
    {
        if ($status =='active') {
            $topics = self::getActiveTopics();
        } elseif ($status == 'inactive') {
            $topics = self::getInactiveTopics();
        }

        return $topics;
    }

    public static function getTopicsForSelect($subscription = null)
    {
        $topics = Topic::orderBy('number')->get();
        $selectedTopics = $subscription->topics ?? null;

        foreach ($topics as $topic) {
            if ($subscription && $selectedTopics->contains($topic)) {
                $arr[] = [
                    'id' => $topic->id,
                    'name' => $topic->number . ' - ' . $topic->name,
                    'selected' => true,
                ];
            } else {
                $arr[] = [
                    'id' => $topic->id,
                    'name' => $topic->number . ' - ' . $topic->name,
                ];
            }
        }

        return $arr;
    }

    public function setActivity(string $event)
    {
        return activity('topics')
            ->causedBy(auth()->user())
            ->performedOn($this)
            ->withProperties([
                'attributes' => [
                    'Number' => $this->number,
                    'Name' => $this->name,
                ]
            ])
            ->log($event);
    }
}
