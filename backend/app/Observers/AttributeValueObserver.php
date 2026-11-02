<?php

namespace App\Observers;

use App\Models\AttributeValue;
use Illuminate\Support\Facades\Cache;


class AttributeValueObserver
{
    public function created(AttributeValue $attributeValue): void
    {
        $this->clearFilterCache();
    }


    public function updated(AttributeValue $attributeValue): void
    {
        $this->clearFilterCache();
    }

    public function deleted(AttributeValue $attributeValue): void
    {
        $this->clearFilterCache();
    }

    public function restored(AttributeValue $attributeValue): void
    {
        $this->clearFilterCache();
    }


    public function forceDeleted(AttributeValue $attributeValue): void
    {
        $this->clearFilterCache();
    }

    protected function clearFilterCache(): void
    {
        Cache::forget('filters.options');
    }
}
