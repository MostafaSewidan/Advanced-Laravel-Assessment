<?php
namespace App\Services;

use App\Repositories\PropertyRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropertyService{

       public function __construct(protected PropertyRepository $propertyRepository){}

       public function search(Request $request): mixed{
              try{
                     $cacheKey = $this->generateCacheKey($request->all());

                     if (Cache::has($cacheKey))
                            Cache::increment('cache_hit_counter');
                     else
                            Cache::add('cache_hit_counter', 0);
                     
                     return Cache::tags('properties_search')->remember(
                            $cacheKey,
                            now()->addMinutes(30), 
                            function () use($request) {
                                   return $this->propertyRepository->getByFilters($request)->get();
                     });
              }catch(Exception $e){
                     throw new Exception($e->getMessage());
              }
       }

       private function generateCacheKey(array $filters)
       {
           return 'properties_search_' . md5(json_encode($filters));
       }
}