<?php
namespace App\Services;

use App\Models\SaleDetail;
use App\Models\StockItem;
use App\Models\Sale;

class SaleService {

    public function insert_sale_details($data) {
        $sale     = $data['sale'];
        $admin_id = $data['admin_id'];

        $cart = \Cart::session($admin_id)->getContent();
        $cart = $cart->sortBy('id');

        $total_unit_cost   = 0;
        foreach ($cart as $item) {
            $item_id   = $item->id;
            $item_name = null;
            $unit_cost   = 0;

            if ($item->name == 'other_item') {
                $item_id   = 0;
                $item_name = $item->attributes->name;
            }

            // Update Stock Item
            $stockItem = StockItem::where('item_id', $item_id)->first();

            if ($stockItem) {
                $total_quantity     = $stockItem->quantity - $item->quantity;
                $unit_cost          = $stockItem->unit_cost;

                StockItem::where('item_id', $item_id)->update([
                    'quantity'  => $total_quantity,
                    'admin_id'  => $admin_id,
                ]);
            }


            $details_data = [
                'sale_id'          => $sale->id,
                'item_id'          => $item_id,
                'item_name'        => $item_name,
                'quantity'         => $item->quantity,
                'unit_cost'        => $unit_cost,
                'price'            => $item->price,
                'tax'              => $item->price / 100 * 15,
                'amount'           => $item->getPriceSum(),
                'created_admin_id' => $admin_id,
            ];

            SaleDetail::create($details_data);
            $total_unit_cost   += $unit_cost;
        }

        return $this;

    }

}

?>
