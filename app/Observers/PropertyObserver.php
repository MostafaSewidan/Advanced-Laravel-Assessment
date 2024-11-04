<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Facades\Cache;

class PropertyObserver
{
    public function created(Property $property)
    {
        $this->clearCache();
    }

    public function updated(Property $property)
    {
        $this->clearCache();
    }

    public function deleted(Property $property)
    {
        $this->clearCache();
    }

    private function clearCache()
    {
        Cache::tags('properties_search')->flush();
    }
}
