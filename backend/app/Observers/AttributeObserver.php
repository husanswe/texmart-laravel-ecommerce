<?php

namespace App\Observers;

use App\Models\Attribute;
use Illuminate\Support\Facades\Cache;


class AttributeObserver
{
    public function created(Attribute $attribute): void
    {
        $this->clearFilterCache();
    }


    public function updated(Attribute $attribute): void
    {
        $this->clearFilterCache();
    }

    public function deleted(Attribute $attribute): void
    {
        $this->clearFilterCache();
    }

    public function restored(Attribute $attribute): void
    {
        $this->clearFilterCache();
    }


    public function forceDeleted(Attribute $attribute): void
    {
        $this->clearFilterCache();
    }

    protected function clearFilterCache(): void
    {
        Cache::forget('filter.options');
    }
}
