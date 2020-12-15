<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Purchase;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  use ResponseTrait;

  public function monthReport(Request $request): JsonResponse
  {
    try {
      $date = $request->input("date", Carbon::now()->format("Y-m-d"));
      $month = Carbon::parse($date)->format("m");
      $year = Carbon::parse($date)->format("Y");

      // Purchases
      $purchases = Purchase::with("items")
        ->whereYear("purchase_date", $year)
        ->whereMonth("purchase_date", $month)->get();

      // Sales
      $sales = Order::with("items")
        ->whereYear("created_at", $year)
        ->whereMonth("created_at", $month)->get();

      $numberOfDaysInMonth = Carbon::parse($date)->daysInMonth;

      $data = [];
      for ($i = 1; $i <= $numberOfDaysInMonth; $i++) {
        $day = "{$year}-{$month}-{$i}";
        $totalPurchases = 0;
        $totalSales = 0;

        foreach ($purchases as $purchase) {
          $purchaseDay = Carbon::parse($purchase->purchase_date)->format("Y-m-d");
          if ($purchaseDay !== $day) continue;

          foreach ($purchase->items as $item) {
            $totalPurchases += ((int)$item->quantity * $item->cost_price);
          }
        }

        foreach ($sales as $sale) {
          $saleDay = Carbon::parse($sale->created_at)->format("Y-m-d");
          if ($saleDay !== $day) continue;

          foreach ($sale->items as $item) {
            $totalSales += ((int)$item->quantity * $item->price);
          }
        }

        $data[] = [
          "day" => $day,
          "purchase" => $totalPurchases,
          "sales" => $totalSales
        ];
      }

      return $this->dataResponse($data);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
