<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function storeOrUpdateClientIfExists(array $clientData): Client
    {
        $client = Client::whereEmail($clientData['email'])->first();

        if ($client) {
            $client->update($clientData);
            return $client;
        }

        $client = Client::create($clientData);
        return $client;
    }
}
