<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
  public $incrementing = true;
  public $timestamps;
  public $table = "purchase_items";

  protected $guarded = [];
}
