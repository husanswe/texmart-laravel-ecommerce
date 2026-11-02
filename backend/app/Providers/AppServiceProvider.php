<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
        Category::observe(CategoryObserver::class);
        Brand::observe(BrandObserver::class);
    }
}
