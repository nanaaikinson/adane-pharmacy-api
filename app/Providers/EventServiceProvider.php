<?php

namespace App\Providers;

use App\Events\BrandsRealtimeEvent;
use App\Events\UpdateProductDetailEvent;
use App\Events\UpdateProductQuantityEvent;
use App\Listeners\BrandsEmitRealtimeListener;
use App\Listeners\UpdateProductDetailListener;
use App\Listeners\UpdateProductQuantityListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],
    BrandsRealtimeEvent::class => [
      BrandsEmitRealtimeListener::class
    ],
    UpdateProductQuantityEvent::class => [
      UpdateProductQuantityListener::class
    ],
    UpdateProductDetailEvent::class => [
      UpdateProductDetailListener::class
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
