<?php

namespace App\Schedule;

use App\Client;
use Carbon\Carbon;

class DeactivateClients
{
    public function __invoke()
    {
        $clientsToDeactivate =
            Client::where('is_active', 1)
                  ->whereHas('subscriptions', function ($q) {
                        $q->where('end_date', '<', Carbon::now()->toDateString());
                    })->get();

        foreach ($clientsToDeactivate as $client) {
            $client->updateStatus(0);
        }
    }
}
