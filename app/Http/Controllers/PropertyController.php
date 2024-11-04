<?php

namespace App\Http\Controllers;

use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

    public function __construct(public PropertyService $propertyService){

    }

    public function search(Request $request){

        try{
            $properties = $this->propertyService->search($request);
            return response()->json([$properties]);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
