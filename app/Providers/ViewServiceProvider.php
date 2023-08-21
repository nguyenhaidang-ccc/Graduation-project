<?php

namespace App\Providers;
 
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Brand;
 
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }
 
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::composer(['frontend.layout.master','frontend.shop'], function (View $view) {
            $categories = Category::all();
            $brands = Brand::all();

            $cartQty = collect(session('cart', []))->flatten(1)->count();

            $view->with(compact('categories', 'brands','cartQty'));
        });
    }
}