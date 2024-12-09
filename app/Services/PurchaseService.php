<?php
namespace App\Services;

use App\Models\FinishItemDetail;
use App\Models\IntactStockDetail;
use App\Models\PurchaseItem;
use App\Models\StockFinishRawMaterialItem;
use App\Models\StockItem;
use App\Models\StockProductionRawMaterialItem;

class PurchaseService {

    public function insert_purchase_items_and_update_stock($data) {
        $purchase_id = $data['purchase_id'];
        $admin_id    = $data['admin_id'];

        // Purchase Details
        $cart = \Cart::session($admin_id)->getContent();
        $cart = $cart->sortBy('id');

        foreach ($cart as $item) {
            $item_id            = $item->id;
            $purchase_item_data = [
                'purchase_id'      => $purchase_id,
                'item_id'          => $item_id,
                'quantity'         => $item->quantity,
                'price'            => $item->price,
                'amount'           => $item->getPriceSum(),
                'created_admin_id' => $admin_id,
            ];
            PurchaseItem::create($purchase_item_data);

            // Update Stock Item
            $stockItem = StockItem::where('item_id', $item_id)->first();

            if ($stockItem) {
                $total_stock_amount = $stockItem->stock_amount + $item->getPriceSum();
                $total_quantity     = $stockItem->quantity + $item->quantity;
                $unit_cost          = $total_stock_amount / $total_quantity;

                StockItem::where('item_id', $item_id)->update([
                    'quantity'  => $total_quantity,
                    'unit_cost' => $unit_cost,
                    'admin_id'  => $admin_id,
                ]);
            } else {
                StockItem::create([
                    'item_id'   => $item_id,
                    'quantity'  => $item->quantity,
                    'unit_cost' => $item->price,
                    'admin_id'  => $admin_id,
                ]);
            }

        }

        return $this;
    }

    public function delete_purchase_items_and_update_stock($data) {

        $purchase_id      = $data['purchase_id'];
        $purchase_items = $data['purchase_items'];
        $admin_id         = $data['admin_id'];

        foreach ($purchase_items as $purchase_item) {
            $stock = StockItem::where('item_id', $purchase_item->item_id)->first();

            if ($stock) {
                $total_quantity     = $stock->quantity - $purchase_item->quantity;
                $total_stock_amount = ($stock->quantity * $stock->unit_cost) - $purchase_item->total_amount;
                $unit_cost          = 0;
                if ($total_quantity != 0) {
                    $unit_cost = $total_stock_amount / $total_quantity;
                }

                StockItem::where('item_id', $purchase_item->item_id)->update([
                    'quantity'         => $total_quantity,
                    'unit_cost'        => $unit_cost,
                    'admin_id' => $admin_id,
                ]);
            }

        }

        PurchaseItem::where('purchase_id', $purchase_id)->delete();

        return $this;
    }

    public function insert_intact_stock_details_and_update_stock($data) {
        $intact_stock_id = $data['intact_stock_id'];
        $date            = $data['date'];
        $admin_id        = $data['admin_id'];

        // Intact Stock Details
        $cart                         = \Cart::session($admin_id)->getContent();
        $cart                         = $cart->sortBy('id');
        $all_intact_stock_detail_data = [];

        foreach ($cart as $item) {

            $item_id = $item->associatedModel->item_id;
            $amount  = $item->getPriceSum();

            $intact_stock_detail_data = [
                'intact_stock_id'          => $intact_stock_id,
                'stock_production_item_id' => $item->id,
                'item_id'                  => $item_id,
                'quantity'                 => $item->quantity,
                'price'                    => $item->price,
                'amount'                   => $item->getPriceSum(),
                'created_admin_id'         => $admin_id,
            ];
            $all_intact_stock_detail_data[] = $intact_stock_detail_data;

            // Update Stock Item

            $stock_production_raw_material_item_data = [
                'quantity'     => \DB::raw("quantity - $item->quantity"),
                'stock_amount' => \DB::raw("stock_amount - $amount"),
            ];
            StockProductionRawMaterialItem::where('id', $item->id)->update($stock_production_raw_material_item_data);

            $stock_raw_material_item_data = [
                'unit_cost'    => \DB::raw("(stock_amount + $amount) / (quantity + $item->quantity)"),
                'quantity'     => \DB::raw("quantity + $item->quantity"),
                'stock_amount' => \DB::raw("stock_amount + $amount"),
            ];
            StockItem::where('item_id', $item_id)->update($stock_raw_material_item_data);
        }

        if (count($all_intact_stock_detail_data) > 0) {
            IntactStockDetail::insert($all_intact_stock_detail_data);
        }

        return $this;
    }

    public function delete_intact_stock_details_and_update_stock($data) {
        $intact_stock_id      = $data['intact_stock_id'];
        $date                 = $data['date'];
        $admin_id             = $data['admin_id'];
        $intact_stock_details = IntactStockDetail::where('intact_stock_id', $intact_stock_id)->get();

        foreach ($intact_stock_details as $intact_stock_detail) {

            $stock_production_raw_material_item_data = [
                'quantity'     => \DB::raw("quantity + $intact_stock_detail->quantity"),
                'stock_amount' => \DB::raw("stock_amount + $intact_stock_detail->amount"),
            ];
            StockProductionRawMaterialItem::where('id', $intact_stock_detail->stock_production_item_id)->update($stock_production_raw_material_item_data);

            $stock_raw_material_item_data = [
                'unit_cost'    => \DB::raw("
                    (stock_amount - $intact_stock_detail->amount) / (quantity - $intact_stock_detail->quantity)
                    "),
                'quantity'     => \DB::raw("quantity + $intact_stock_detail->quantity"),
                'stock_amount' => \DB::raw("stock_amount + $intact_stock_detail->amount"),
            ];
            StockItem::where('item_id', $intact_stock_detail->item_id)->update($stock_raw_material_item_data);
        }

        IntactStockDetail::where('intact_stock_id', $intact_stock_id)->delete();

        return $this;
    }

    public function insert_finish_item_details_and_update_stock($data) {
        $finish_item_id = $data['finish_item_id'];
        $date           = $data['date'];
        $admin_id       = $data['admin_id'];

        // Intact Stock Details
        $cart                        = \Cart::session($admin_id)->getContent();
        $cart                        = $cart->sortBy('id');
        $all_finish_item_detail_data = [];

        foreach ($cart as $item) {

            $item_id = $item->associatedModel->item_id;
            $amount  = $item->getPriceSum();

            $finish_item_detail_data = [
                'finish_item_id'           => $finish_item_id,
                'stock_production_item_id' => $item->id,
                'item_id'                  => $item_id,
                'quantity'                 => $item->quantity,
                'price'                    => $item->price,
                'amount'                   => $amount,
                'created_admin_id'         => $admin_id,
            ];
            $all_finish_item_detail_data[] = $finish_item_detail_data;

            $stock_production_raw_material_item_data = [
                'quantity'     => \DB::raw("quantity - $item->quantity"),
                'stock_amount' => \DB::raw("stock_amount - $amount"),
            ];
            StockProductionRawMaterialItem::where('id', $item->id)->update($stock_production_raw_material_item_data);

            $stockFinishRawMaterial = StockFinishRawMaterialItem::where('item_id', $item_id)->first();

            if ($stockFinishRawMaterial) {
                $stock_finish_raw_material_item_data = [
                    'unit_cost'        => \DB::raw("(stock_amount + $amount) / (quantity + $item->quantity)"),
                    'quantity'         => \DB::raw("quantity + $item->quantity"),
                    'stock_amount'     => \DB::raw("stock_amount + $amount"),
                    'updated_admin_id' => $admin_id,
                ];
                StockFinishRawMaterialItem::where('item_id', $item_id)->update($stock_finish_raw_material_item_data);
            } else {
                $stock_finish_raw_material_item_data = [
                    'item_id'          => $item_id,
                    'quantity'         => $item->quantity,
                    'unit_cost'        => $item->price,
                    'stock_amount'     => $amount,
                    'created_admin_id' => $admin_id,
                ];
                StockFinishRawMaterialItem::insert($stock_finish_raw_material_item_data);

            }

        }

        if (count($all_finish_item_detail_data) > 0) {
            FinishItemDetail::insert($all_finish_item_detail_data);
        }

        return $this;
    }

    public function delete_finish_item_details_and_update_stock($data) {
        $finish_item_id      = $data['finish_item_id'];
        $date                = $data['date'];
        $admin_id            = $data['admin_id'];
        $finish_item_details = FinishItemDetail::where('finish_item_id', $finish_item_id)->get();

        foreach ($finish_item_details as $finish_item_detail) {
            $stock_production_raw_material_item_data = [
                'quantity'     => \DB::raw("quantity + $finish_item_detail->quantity"),
                'stock_amount' => \DB::raw("stock_amount + $finish_item_detail->amount"),
            ];
            StockProductionRawMaterialItem::where('id', $finish_item_detail->stock_production_item_id)->update($stock_production_raw_material_item_data);

            $stock_finish_raw_material_item_data = [
                'unit_cost'    => \DB::raw("
                    (stock_amount - $finish_item_detail->amount) / (quantity - $finish_item_detail->quantity)
                    "),
                'quantity'     => \DB::raw("quantity + $finish_item_detail->quantity"),
                'stock_amount' => \DB::raw("stock_amount + $finish_item_detail->amount"),
            ];
            StockFinishRawMaterialItem::where('item_id', $finish_item_detail->item_id)->update($stock_finish_raw_material_item_data);
        }

        FinishItemDetail::where('finish_item_id', $finish_item_id)->delete();

        return $this;
    }

}

?>
