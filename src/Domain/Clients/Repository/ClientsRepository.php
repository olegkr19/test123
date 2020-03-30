<?php

namespace App\Domain\Clients\Repository;

use App\Domain\Clients\Data\ClientsData;
use PDO;

class ClientsRepository
{

    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getClients()
    {
      $clients_list = $this->connection->query("SELECT * FROM clients")->fetchAll();
      return $clients_list;
    }

    public function getClient($id)
    {
      $stmt = $this->connection->prepare("SELECT * FROM clients WHERE client_id = :id LIMIT 1;");
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      $client = $stmt->fetch();
      return $client;
    }

    public function insertClient(ClientsData $client): int
    {
        $row = [
            'client_name' => $client->client_name,
            'client_phone' => $client->client_phone,
            'client_email' => $client->client_email,
            'client_card' => $client->client_card,
            'client_money' => $client->client_money,
            'client_data' => $client->client_data,
        ];

        $sql = "INSERT INTO clients SET
                client_name=:client_name,
                client_phone=:client_phone,
                client_email =:client_email,
                client_card=:client_card,
                client_money=:client_money,
                client_data=:client_data;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    public function updateClient($id, $client)
    {

        $sql = "UPDATE clients SET
                client_name=:client_name,
                client_phone=:client_phone,
                client_email=:client_email,
                client_card=:client_card,
                client_money=:client_money,
                client_data=:client_data
                WHERE client_id=:id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':client_name', $client->client_name);
        $stmt->bindValue(':client_phone', $client->client_phone);
        $stmt->bindValue(':client_email', $client->client_email);
        $stmt->bindValue(':client_card', $client->client_card);
        $stmt->bindValue(':client_money', $client->client_money);
        $stmt->bindValue(':client_data', $client->client_data);
        return $stmt->execute();
    }

    public function deleteClient($id)
    {
      $stmt = $this->connection->prepare("DELETE FROM clients WHERE client_id = :id;");
      $stmt->bindValue(':id', $id);
      return $stmt->execute();
    }
}
