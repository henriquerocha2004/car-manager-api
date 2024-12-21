<?php

namespace App\Http\Controllers;

use App\Actions\Cars\FindCar;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CarsController extends Controller
{
    public function __construct(
      private readonly FindCar $findCar
    ) {
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $cars = $this->findCar->execute($request->get('search'));

            return response()->json(['cars' => $cars], Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error('FAILED_TO_SEARCH_CARS', [
                'message' => $exception,
                'context' => $exception->getTraceAsString(),
            ]);

            return response()->json(
                ['error' => 'ocorreu um erro ao obter os dados dos veículos'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
