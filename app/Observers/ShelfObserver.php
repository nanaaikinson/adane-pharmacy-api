<?php

namespace App\Observers;

use App\Functions\Mask;
use App\Models\Shelf;

class ShelfObserver
{
  /**
   * Handle the shelf "created" event.
   *
   * @param \App\Models\Shelf $shelf
   * @return void
   */
  public function created(Shelf $shelf)
  {
    $shelf->update(['mask' => Mask::string($shelf->id)]);
  }

  /**
   * Handle the shelf "updated" event.
   *
   * @param \App\Models\Shelf $shelf
   * @return void
   */
  public function updated(Shelf $shelf)
  {
    //
  }

  /**
   * Handle the shelf "deleted" event.
   *
   * @param \App\Models\Shelf $shelf
   * @return void
   */
  public function deleted(Shelf $shelf)
  {
    //
  }

  /**
   * Handle the shelf "restored" event.
   *
   * @param \App\Models\Shelf $shelf
   * @return void
   */
  public function restored(Shelf $shelf)
  {
    //
  }

  /**
   * Handle the shelf "force deleted" event.
   *
   * @param \App\Models\Shelf $shelf
   * @return void
   */
  public function forceDeleted(Shelf $shelf)
  {
    //
  }
}
