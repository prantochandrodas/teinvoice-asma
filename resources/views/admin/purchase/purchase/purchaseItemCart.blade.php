@if(!empty($cart) )
    <table class="table table-bordered table-stripede"  style="background-color:white;width: 100%">
        <thead>
            <tr  style="background-color: #a2bbca !important; font-family: Arial Black;font-size: 14px">
                <th width="10%" class="text-center">SL </th>
                <th width="35%" class="text-center">Item</th>
                <th width="15%" class="text-center">Quantity</th>
                <th width="15%" class="text-center">Price</th>
                <th width="15%" class="text-center">Amount</th>
                <th width="10%" class="text-center">
                    <span>
                        <i class="fas fa-trash  text-dark fa-2x"></i>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
                <tr style="background-color: #f4f4f4;">
                    <td class="text-center" >
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center" >
                        ({{ $item->associatedModel->code }}) - {{ $item->name }}
                    </td>
                    <td class="text-center" >
                        <input type="number" id="purchase_item_quantity{{ $item->id }}"   value="{{ $item->quantity }}" onchange="return update_raw_material_item_quantity({{ $item->id }})" class="form-control" placeholder="Item Quantity" style="text-align: right; ">
                    </td>
                    <td class="text-center" >
                        <input type="number" id="purchase_item_price{{ $item->id }}"  value="{{ $item->price }}" onchange="return update_raw_material_item_price({{ $item->id }})" class="form-control" placeholder="Item Price" style="text-align: right; ">
                    </td>
                    <td class="text-center" >
                        <input type="number" id="purchase_item_amount{{ $item->id }}"  value="{{ $item->getPriceSum() }}" class="form-control" style="text-align: right; " readonly>
                    </td>
                    <td class="text-center" >
                        <span style="cursor: pointer;" onclick="return delete_item({{ $item->id }})">
                            <i class="fas fa-trash-alt text-danger fa-lg"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden"  id="cart_total_item" value="{{ $totalItem }}">
    <input type="hidden"  id="cart_total_amount" value="{{ $getTotal }}">
@endif
