<?php
namespace App\Services;

use App\Models\ReturnSaleDetail;
use App\Models\SaleDetail;

class ReturnSaleService {

    public function insert_return_sale_details($data) {

        $returnSale = $data['returnSale'];
        $admin_id   = $data['admin_id'];

        $sale_detail_id  = request()->sale_detail_id;
        $return_amount   = request()->return_amount;
        $return_quantity = request()->return_quantity;

        $count = count($sale_detail_id);

        for ($i = 0; $i < $count; $i++) {
            $sale_detail        = SaleDetail::where('id', $sale_detail_id[$i])->first();
            $return_sale_detail = [
                'return_sale_id' => $returnSale->id,
                'sale_detail_id' => $sale_detail_id[$i],
                'item_id'        => $sale_detail->item_id,
                'item_name'      => $sale_detail->item_name,
                'price'          => $sale_detail->price,
                'quantity'       => $return_quantity[$i],
                'amount'         => $return_amount[$i],
            ];

            ReturnSaleDetail::create($return_sale_detail);

            $sale_detail_data = [
                'return_quantity'  => \DB::raw("return_quantity + {$return_quantity[$i]}"),
                'return_amount'    => \DB::raw("return_amount + {$return_amount[$i]}"),
            ];
            SaleDetail::where('id', $sale_detail_id[$i])->update($sale_detail_data);
        }

        return $this;

    }

}

?>
