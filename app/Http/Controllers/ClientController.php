<?php

namespace App\Http\Controllers;

use App\Actions\CustomerService\Clients\DeleteClient;
use App\Actions\CustomerService\Clients\SearchClient;
use App\Http\Requests\ClientRequest;
use App\Services\CustomerServices\CreateClientService;
use App\Services\CustomerServices\UpdateClientService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function __construct(
        private readonly CreateClientService $createClientService,
        private readonly UpdateClientService $updateClientService,
        private readonly DeleteClient $deleteClient,
        private readonly SearchClient $searchClient
    ) {
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $clients = $this->searchClient->searchAll($request->all());

            return response()->json([
                'success' => true,
                'data' => $clients
            ], Response::HTTP_OK);

        } catch (Exception $exception) {
            Log::error('ERROR_GET_CLIENTS', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);

            return response()->json(
                ['status' => 'error', 'message' => 'failed to get clients'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function searchOne(string $id): JsonResponse
    {
        try {
            $client = $this->searchClient->searchOne($id);

            return response()->json(
                ['status' => 'success', 'data' => $client],
                Response::HTTP_OK
            );
        } catch (Exception $exception) {
            Log::error('ERROR_GET_CLIENT_SELECTED', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);

            return response()->json(
                ['status' => 'error', 'message' => 'failed to get client selected'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(ClientRequest $request): JsonResponse
    {
        try {
            $this->createClientService->execute($request->getData());

            return response()->json(
                ['status' => 'success'],
                Response::HTTP_CREATED
            );

        } catch (Exception $exception) {
            Log::error('ERROR_CREATE_CLIENT', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);

            return response()->json(
                ['status' => 'error', 'message' => 'failed to create client'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(ClientRequest $request, string $id): JsonResponse
    {
        try {
            $this->updateClientService->execute($id, $request->getData());

            return response()->json(['status' => 'success'], Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error('ERROR_UPDATE_CLIENT', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);

            return response()->json(
                ['status' => 'error', 'message' => 'failed to update client'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $this->deleteClient->execute($id);

            return response()->json(
                ['status' => 'success'],
                Response::HTTP_OK
            );

        } catch (Exception $exception) {
            Log::error('ERROR_DELETE_CLIENT', [
                'message' => $exception->getMessage(),
                'context' => $exception->getTraceAsString(),
            ]);

            return response()->json(
                ['status' => 'error', 'message' => 'failed to delete client'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
