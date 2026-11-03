<?php

namespace App\Providers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Observers\AttributeObserver;
use App\Observers\AttributeValueObserver;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;



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
        Attribute::observe(AttributeObserver::class);
        AttributeValue::observe(AttributeValueObserver::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        if (app()->isLocal()) {
            DB::listen(function ($query) {
                Log::info("SQL ({$query->time}ms): {$query->sql} | Bindings: " . implode(', ', $query->bindings));
            });
        }
    }
}
