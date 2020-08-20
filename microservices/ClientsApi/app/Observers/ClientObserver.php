<?php

namespace App\Observers;

use App\Client;

class ClientObserver
{
    public function creating(Client $client)
    {
        $client->client_number = str_random(8);
        $client->status = "ACTIVE";
    }

    public function created(Client $client)
    {

    }

    public function updating(Client $client)
    {

    }

    public function updated(Client $client)
    {

    }

    public function saving(Client $client)
    {

    }

    public function saved(Client $client)
    {

    }

    public function deleting(Client $client)
    {

    }

    public function deleted(Client $client)
    {

    }

    public function restoring(Client $client)
    {

    }

    public function restored(Client $client)
    {

    }

    public function retrieved(Client $client)
    {

    }
}
