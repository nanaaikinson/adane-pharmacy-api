<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Observers\CategoryObserver;
use App\Observers\ManufacturerObserver;
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
    Supplier::observe(SupplierObserver::class);
    Category::observe(CategoryObserver::class);
    Manufacturer::observe(ManufacturerObserver::class);
  }
}
