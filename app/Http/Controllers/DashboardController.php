<?php

namespace App\Http\Controllers;

use App\Repositories\LoggingRequestRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(public LoggingRequestRepository $loggingRequestRepository){
        //
    }

    public function listRequestsInfo(Request $request){

        try{
            $logs = $this->loggingRequestRepository->getLogsPaginated($request);

            return response()->json($logs);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}
