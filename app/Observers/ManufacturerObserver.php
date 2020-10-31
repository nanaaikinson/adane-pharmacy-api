<?php

namespace App\Observers;

use App\Functions\Mask;
use App\Models\Brand;

class ManufacturerObserver
{
    /**
     * Handle the Brand "created" event.
     *
     * @param  \App\Models\Brand  $Manufacturer
     * @return void
     */
    public function created(Brand $Manufacturer)
    {
      $Manufacturer->mask = Mask::string($Manufacturer->id);
      $Manufacturer->save();
    }

    /**
     * Handle the Brand "updated" event.
     *
     * @param  \App\Models\Brand  $Manufacturer
     * @return void
     */
    public function updated(Brand $Manufacturer)
    {
        //
    }

    /**
     * Handle the Brand "deleted" event.
     *
     * @param  \App\Models\Brand  $Manufacturer
     * @return void
     */
    public function deleted(Brand $Manufacturer)
    {
        //
    }

    /**
     * Handle the Brand "restored" event.
     *
     * @param  \App\Models\Brand  $Manufacturer
     * @return void
     */
    public function restored(Brand $Manufacturer)
    {
        //
    }

    /**
     * Handle the Brand "force deleted" event.
     *
     * @param  \App\Models\Brand  $Manufacturer
     * @return void
     */
    public function forceDeleted(Brand $Manufacturer)
    {
        //
    }
}
