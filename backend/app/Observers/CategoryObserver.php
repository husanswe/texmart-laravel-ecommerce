<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;


class CategoryObserver
{
    public function created(Category $category): void
    {
        $this->clearCategoryCache();
    }


    public function updated(Category $category): void
    {
        $this->clearCategoryCache();
    }


    public function deleted(Category $category): void
    {
        $this->clearCategoryCache();
    }


    public function restored(Category $category): void
    {
        $this->clearCategoryCache();
    }


    public function forceDeleted(Category $category): void
    {
        $this->clearCategoryCache();
    }

    protected function clearCategoryCache(): void
    {
        Cache::forget('categories.tree');
    }
}
