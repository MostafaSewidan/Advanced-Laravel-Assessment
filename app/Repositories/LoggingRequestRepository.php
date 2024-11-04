<?php
namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class LoggingRequestRepository{
     
       const FETCH_SEPARATOR = "|*|";
       
       public function create($ipAddress, $payloads, $headers): void{
              try{
                     $encryptedData = Crypt::encrypt([[
                            "ip_address" => $ipAddress,
                            "payloads" => $payloads,
                            "headers" => $headers,
                     ]]);
                     
                     Log::channel('access_log')
                     ->info(self::FETCH_SEPARATOR . "$encryptedData");
                     
              }catch(Exception $e){
                     throw new Exception($e->getMessage());
              }
       }

       public function getLogsPaginated($request): LengthAwarePaginator{

              try{
                     $logsFile = file(storage_path('logs/access_log.log'));

                     //paginationData
                     $perPage = 10;
                     $currentPage = $request->page ?? 1;
                     $totalLogs = count($logsFile);

                     $lineOffset = ($currentPage - 1) * $perPage;

                     $encryptedLogs = array_slice($logsFile, $lineOffset, $perPage);
                     $logs = [];

                     foreach($encryptedLogs as $log){
                            $hash = explode(self::FETCH_SEPARATOR, $log);

                            if(isset($hash[1])){
                                   $logs[] = Crypt::decrypt($hash[1]);
                            }
                     }

                     return new LengthAwarePaginator(
                            $logs,
                            $totalLogs,
                            $perPage,
                            $currentPage,
                            ['path' => request()->url(), 'query' => request()->query()]
                     );

              }catch(Exception $e){
                     throw new Exception($e->getMessage());
              }
       }
}