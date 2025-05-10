<?php

namespace App\Http\Controllers;

use App\Services\CountProductsByCategoryService;
use App\Services\ProductService;
use App\Services\QueryEntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Log;

class DialogFlowController extends Controller
{
    private QueryEntityService $queryEntityService;
    private CountProductsByCategoryService $countProductsByCategoryService;

    public function __construct(QueryEntityService $queryEntityService, CountProductsByCategoryService $countProductsByCategoryService)
    {
        $this->queryEntityService = $queryEntityService; 
        $this->countProductsByCategoryService = $countProductsByCategoryService;
    }

    public function __invoke(Request $request)
    {
        $intent = $request->input('queryResult.intent.displayName');
        $message = '';

        switch ($intent) {
            case 'QueryEntity':
                $message = $this->queryEntityService->handleQueryEntity($request);
                break;

            case 'CountProductsByCategory':
                $message = $this->countProductsByCategoryService->handleCountProductsByCategory($request);
                break;

            default:
                $message = 'Sorry, I didn’t understand that request.';
        }

        return response()->json([
            'fulfillmentText' => $message
        ]);
    }
}
