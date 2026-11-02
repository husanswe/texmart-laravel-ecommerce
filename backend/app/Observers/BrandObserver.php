<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;


class BrandObserver
{
    public function created(Brand $brand): void
    {
        $this->clearBrandCache();
    }


    public function updated(Brand $brand): void
    {
        $this->clearBrandCache();
    }


    public function deleted(Brand $brand): void
    {
        $this->clearBrandCache();
    }


    public function restored(Brand $brand): void
    {
        $this->clearBrandCache();
    }


    public function forceDeleted(Brand $brand): void
    {
        $this->clearBrandCache();
    }

    protected function clearBrandCache(): void 
    {
        Cache::forget('brands.list');
    }
}
