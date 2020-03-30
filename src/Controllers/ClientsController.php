<?php

namespace App\Controllers;

use App\Domain\Clients\Data\ClientsData;
use App\Domain\Clients\Service\ClientsService;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class ClientsController
{
   private $clientsService;

   public function __construct(ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
    }

   public function index(ServerRequest $request, Response $response)
    {
      //get all clients from service
      $clients = $this->clientsService->allClients();

      // Transform the result into the JSON representation
      $result = [
          'data' => $clients
        ];

      return $response->withJson($result);
    }

    public function show(ServerRequest $request, Response $response, $args)
     {
       //get client id from route
       $id = $args['id'];

       //get client from service
       $client = $this->clientsService->getClientById($id);

       // Transform the result into the JSON representation
       $result = [
           'data' => $client
         ];

       return $response->withJson($result);
     }

     public function store(ServerRequest $request, Response $response)
      {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Mapping (should be done in a mapper class)
        $client = new ClientsData();
        $client->client_name = $data['client_name'];
        $client->client_phone = $data['client_phone'];
        $client->client_email = $data['client_email'];
        $client->client_card = $data['client_card'];
        $client->client_money = $data['client_money'];
        $client->client_data = $data['client_data'];

        // Invoke the Domain with inputs and retain the result
        $clientId = $this->clientsService->createClient($client);

        // Transform the result into the JSON representation
        $result = [
            'message' => 'Created successfully',
            'client_id' => $clientId
        ];

        // Build the HTTP response
        return $response->withJson($result);
      }

      public function update(ServerRequest $request, Response $response, $args)
       {
         //get client id from route
         $id = $args['id'];

         // Collect input from the HTTP request
         $data = (array)$request->getParsedBody();

         // Mapping (should be done in a mapper class)
         $client = new ClientsData();
         $client->client_name = $data['client_name'];
         $client->client_phone = $data['client_phone'];
         $client->client_email = $data['client_email'];
         $client->client_card = $data['client_card'];
         $client->client_money = $data['client_money'];
         $client->client_data = $data['client_data'];

         // Invoke the Domain with inputs and retain the result
         $this->clientsService->updateClientById($id, $client);

         // Transform the result into the JSON representation
         $result = [
             'message' => 'Updated successfully'
         ];

         // Build the HTTP response
         return $response->withJson($result);
       }

       public function delete(ServerRequest $request, Response $response, $args)
        {
          //get client id from route
          $id = $args['id'];

          //delete client
          $this->clientsService->deleteClientById($id);

          // Transform the result into the JSON representation
          $result = [
              'message' => 'Deleted successfully'
          ];

          return $response->withJson($result);
        }

}
