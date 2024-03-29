<?php

namespace App\Observers;

use App\Functions\Mask;
use App\Models\Category;

class CategoryObserver
{
  /**
   * Handle the category "created" event.
   *
   * @param \App\Models\Category $category
   * @return void
   */
  public function created(Category $category)
  {
    $category->mask = Mask::string($category->id);
    $category->save();
  }

  /**
   * Handle the category "updated" event.
   *
   * @param \App\Models\Category $category
   * @return void
   */
  public function updated(Category $category)
  {
    //
  }

  /**
   * Handle the category "deleted" event.
   *
   * @param \App\Models\Category $category
   * @return void
   */
  public function deleted(Category $category)
  {
    //
  }

  /**
   * Handle the category "restored" event.
   *
   * @param \App\Models\Category $category
   * @return void
   */
  public function restored(Category $category)
  {
    //
  }

  /**
   * Handle the category "force deleted" event.
   *
   * @param \App\Models\Category $category
   * @return void
   */
  public function forceDeleted(Category $category)
  {
    //
  }
}
