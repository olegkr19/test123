<?php

namespace App\Domain\Clients\Service;

use App\Domain\Clients\Data\ClientsData;
use App\Domain\Clients\Repository\ClientsRepository;
use UnexpectedValueException;


class ClientsService
{
    private $repository;

    public function __construct(ClientsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function allClients()
    {
      $clients = $this->repository->getClients();

      return $clients;
    }
    public function getClientById($id)
    {
      $client = $this->repository->getClient($id);

      return $client;
    }

    public function createClient(ClientsData $client): int
    {
        // Validation
        if (empty($client->client_name)) {
            throw new UnexpectedValueException('Client name required');
        }

        // Insert client
        $clientId = $this->repository->insertClient($client);

        return $clientId;
    }
    public function updateClientById($id, $client)
    {
        // Update client
        $clientId = $this->repository->updateClient($id, $client);

        return $clientId;
    }

    public function deleteClientById($id)
    {
      //Delete client
      $clientId = $this->repository->deleteClient($id);

      return $clientId;
    }
}
