<?php

namespace App\Observers;

use App\Functions\Mask;
use App\Models\Manufacturer;

class ManufacturerObserver
{
    /**
     * Handle the Brand "created" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function created(Manufacturer $Manufacturer)
    {
      $Manufacturer->mask = Mask::string($Manufacturer->id);
      $Manufacturer->save();
    }

    /**
     * Handle the Brand "updated" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function updated(Manufacturer $Manufacturer)
    {
        //
    }

    /**
     * Handle the Brand "deleted" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function deleted(Manufacturer $Manufacturer)
    {
        //
    }

    /**
     * Handle the Brand "restored" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function restored(Manufacturer $Manufacturer)
    {
        //
    }

    /**
     * Handle the Brand "force deleted" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function forceDeleted(Manufacturer $Manufacturer)
    {
        //
    }
}
