<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'price',
        'location',
        'availability',
    ];

    public function reviews(){
        return $this->hasMany(PropertyReview::class);
    }
}
