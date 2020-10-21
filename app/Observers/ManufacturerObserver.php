<?php

namespace App\Observers;

use App\Functions\Mask;
use App\Models\Manufacturer;

class ManufacturerObserver
{
    /**
     * Handle the Manufacturer "created" event.
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
     * Handle the Manufacturer "updated" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function updated(Manufacturer $Manufacturer)
    {
        //
    }

    /**
     * Handle the Manufacturer "deleted" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function deleted(Manufacturer $Manufacturer)
    {
        //
    }

    /**
     * Handle the Manufacturer "restored" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function restored(Manufacturer $Manufacturer)
    {
        //
    }

    /**
     * Handle the Manufacturer "force deleted" event.
     *
     * @param  \App\Models\Manufacturer  $Manufacturer
     * @return void
     */
    public function forceDeleted(Manufacturer $Manufacturer)
    {
        //
    }
}
