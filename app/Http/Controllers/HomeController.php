<?php

namespace App\Http\Controllers;

use App\Client;
use App\Subscription;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalSubscriptions = Subscription::count();

        $activeSubscriptions = Subscription::getActiveSubscriptions()->count();
        $expiringSubscriptions = Subscription::getExpiringSubscriptions()->count();
        $inactiveSubscriptions = Subscription::getInactiveSubscriptions()->count();

        $dnSubscriptions =
            Subscription::getActiveSubscriptions()
                        ->where('subscription_type_id', 1)
                        ->count();
        $clipSubscriptions =
            Subscription::getActiveSubscriptions()
                        ->where('subscription_type_id', 2)
                        ->count();

        if ($totalSubscriptions && $activeSubscriptions) {
            $activeStat = round(100 / ($totalSubscriptions / $activeSubscriptions), 1);
        } else {
            $activeStat = 0;
        }

        if ($totalSubscriptions && $expiringSubscriptions) {
            $expiringStat = round(100 / ($totalSubscriptions / $expiringSubscriptions));
        } else {
            $expiringStat = 0;
        }

        if ($activeSubscriptions && $dnSubscriptions) {
            $dnStat = round(100 / ($activeSubscriptions / $dnSubscriptions));
        } else {
            $dnStat = 0;
        }

        if ($activeSubscriptions && $clipSubscriptions) {
            $clipStat = round(100 / ($activeSubscriptions / $clipSubscriptions));
        } else {
            $clipStat = 0;
        }

        $clients = Client::with('subscriptions')->latest('updated_at')->take(8)->get();

        $subscriptions = Subscription::with('emails')->with('client')->with('topics')->latest('updated_at')->take(8)->get();

        return view('home', compact('activeSubscriptions', 'totalSubscriptions', 'expiringSubscriptions', 'dnSubscriptions', 'clipSubscriptions', 'activeStat', 'expiringStat', 'dnStat', 'clipStat', 'clients', 'subscriptions'));
    }
}
