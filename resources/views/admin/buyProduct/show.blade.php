<div class="row">
    <table class="table table-sm">
        <thead>
            <th>#Sl</th>
            <th>Purchase No</th>
            <th>Supplier Name</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Buy Bill</th>
            <th>Item Total Cost</th>
        </thead>
        <tbody>
            @php
                $totalBuyBill=0;
                $totalCost=0;
            @endphp
            @foreach ($data as $item)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$item->purchase_no}}</td>
                    <td>{{$item->supplier_name}}</td>
                    <td>{{$item->item_code}}</td>
                    <td>{{$item->item_name}}</td>
                    <td>{{$item->item_buy_bill}}</td>
                    <td>{{$item->total_cost}}</td>
                </tr>
                @php
                    $totalBuyBill+=$item->item_buy_bill;
                    $totalCost+=$item->total_cost;
                @endphp
            @endforeach
        </tbody>
        <hr>
        <tfoot class="mt-3">
            <td colspan="4"></td>
            <td>Total:</td>
            <td>{{$totalBuyBill}}</td>
            <td>{{$totalCost}}</td>
        </tfoot>

    </table>
</div>
