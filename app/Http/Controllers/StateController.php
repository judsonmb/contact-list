<?php

namespace App\Http\Controllers;

use App\Services\StateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct(private StateService $stateService)
    {
    }

    public function index(): JsonResponse
    {
        $states = $this->stateService->list();

        return response()->json(['data' => $states]);
    }
}
