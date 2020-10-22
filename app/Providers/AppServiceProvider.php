<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Shelf;
use App\Models\Supplier;
use App\Observers\CategoryObserver;
use App\Observers\ManufacturerObserver;
use App\Observers\ProductObserver;
use App\Observers\ShelfObserver;
use App\Observers\SupplierObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // Model Observers
    Supplier::observe(SupplierObserver::class);
    Category::observe(CategoryObserver::class);
    Manufacturer::observe(ManufacturerObserver::class);
    Product::observe(ProductObserver::class);
    Shelf::observe(ShelfObserver::class);
  }
}
