@if($items->count() > 0)
    @foreach($items as $item)
        <tr style="background-color: #f4f4f4;">
            <td class="text-center" >
                {{ $loop->iteration }}
            </td>
            <td class="text-center" >
                {{ $item->code }}
            </td>
            <td class="text-center" >
                {{ $item->name }}
            </td>
            <td class="text-center" >
                <input type="number" name="item_quantity[]"
                id="item_quantity{{ $item->id }}"
                value="1" class="form-control"
                data-raw_material_iItem_id="{{ $item->id }}"
                placeholder="Item Quantity" style="text-align: right; ">
            </td>
            <td class="text-center" >
                <input type="number" name="item_price[]"
                id="item_price{{ $item->id }}"
                value="{{ $item->purchase_price }}"
                data-raw_material_iItem_id="{{ $item->id }}"
                class="form-control"
                placeholder="Item Price"
                style="text-align: right; ">
            </td>
            <td class="text-center" >
                <input type="number" name="item_amount[]"
                    id="item_amount{{ $item->id }}"
                    value="{{ $item->purchase_price }}"
                    class="form-control"
                    data-raw_material_iItem_id="{{ $item->id }}"
                    placeholder="Item Amount" style="text-align: right;">
            </td>
            <td class="text-center" >
                <button class="btn btn-success" onclick="add_raw_item({{ $item->id }})">
                    <i class="fas fa-plus-square"></i>
                </button>
            </td>
        </tr>
    @endforeach
@endif
