<?php

namespace App\Observers;

use App\RegisteredClient;

class RegisteredClientObserver
{
    public function creating(RegisteredClient $client)
    {
        $client->status = "ACTIVE";
    }

    public function created(RegisteredClient $client)
    {

    }

    public function updating(RegisteredClient $client)
    {

    }

    public function updated(RegisteredClient $client)
    {

    }

    public function saving(RegisteredClient $client)
    {

    }

    public function saved(RegisteredClient $client)
    {

    }

    public function deleting(RegisteredClient $client)
    {

    }

    public function deleted(RegisteredClient $client)
    {

    }

    public function restoring(RegisteredClient $client)
    {

    }

    public function restored(RegisteredClient $client)
    {

    }

    public function retrieved(RegisteredClient $client)
    {

    }
}
