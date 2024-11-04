<?php
namespace App\Repositories;

use App\Models\Property;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PropertyRepository{
     
       public function getModel(){
              return new Property();
       }
       
       public function getByFilters(Request $request): Builder|Property{
             return $this->getModel()
             ->when($request->input('location') , fn($query) => $query->where('location', $request->input('location')))
             ->when($request->input('price_range') , fn($query) => $query->whereBetween('price', $request->input('price_range')))
             ->when($request->input('availability') , fn($query) => $query->where('availability', $request->input('availability')))
             ->when($request->input('include') && $request->input('include') == "reviews" , fn($query) => $query->with('reviews'));
       }
}