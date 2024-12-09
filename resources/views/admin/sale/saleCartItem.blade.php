<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" width="10%">
                <button type="button"
                    class="btn"
                    style="color:black;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </th>
            <th class="text-center" width="15%">{{ __('message.amount') }}</th>
            <th class="text-center" width="15%">{{ __('message.price') }} </th>
            <th class="text-center" width="10%">{{ __('message.quantity') }}</th>
            <th class="text-center" width="20%">{{ __('message.code') }} </th>
            <th class="text-center" width="30%">{{ __('message.name') }} </th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_unit_cost = 0;
        @endphp
        @foreach ($cart as $item)
            @php
                $total_unit_cost += $item->attributes->unit_cost;
            @endphp
            @if ($item->name != 'other_item')
                <tr >
                    <td class="text-center">
                        <button type="button"
                            class="btn remove_cart" data-id='{{ $item->id }}'
                            style="color:red;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <input type="number"  value="{{ $item->getPriceSum() }}" id="sale_item_amount{{ $item->id }}"
                        data-id="{{ $item->id }}"  class="form-control sale_item_amount text-center" placeholder="Sales Item Price">
                    </td>
                    <td class="text-center">
                        <input type="number" value="{{ $item->price }}" id="sale_item_price{{ $item->id }}"
                        data-id="{{ $item->id }}"  class="form-control sale_item_price text-center" placeholder="Sales Item Price">
                    </td>
                    {{-- <td class="text-center"> {{ $item->attributes->parcel_name }}</td> --}}
                    <td class="text-center">
                        <input type="number" value="{{ $item->quantity }}" id="sale_item_quantity{{ $item->id }}"
                        data-id="{{ $item->id }}"  class="form-control sale_item_quantity text-center" placeholder="Sales Item Quantity">
                    </td>
                    <td class="text-center">
                        {{ $item->associatedModel->code }}
                    </td>
                    <td class="text-center"> {{ $item->name }}</td>
                </tr>
            @else
                <tr style="line-height: 60px;">
                    <td class="text-center">
                        <button type="button"
                            class="btn remove_cart" data-id='{{ $item->id }}'
                            style="color:red;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <input style="height: 60px; font-size:24px;" type="number" value="{{ $item->getPriceSum() == 0 ? '' : $item->getPriceSum() }}" id="sale_item_amount{{ $item->id }}"
                        data-id="{{ $item->id }}" row="2"  class="form-control sale_item_amount text-center" placeholder="Sales Item Price">
                    </td>
                    <td class="text-center">
                        <input style="height: 60px; font-size:24px;" type="number" value="{{ $item->price == 0 ? '' : $item->price }}" id="sale_item_price{{ $item->id }}"
                        data-id="{{ $item->id }}"  row="2" class="form-control sale_item_price text-center" placeholder="Sales Item Price">
                    </td>
                    <td class="text-center">
                        <input style="height: 60px; font-size:24px;" type="number" value="{{ $item->quantity }}" id="sale_item_quantity{{ $item->id }}"
                        data-id="{{ $item->id }}"  class="form-control sale_item_quantity text-center" placeholder="Sales Item Quantity">
                    </td>
                    <td class="text-center">
                    </td>
                    <td class="text-center">
                        <input style="height: 60px; font-size:24px;" type="text" value="{{ $item->attributes->name }}" id="sale_item_name{{ $item->id }}"
                        data-id="{{ $item->id }}"  class="form-control sale_item_name" placeholder="Sales Item Name">
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<input type="hidden" id="cart_total_item" value="{{ $totalItem }}">
<input type="hidden" id="cart_total_amount" value="{{ $getTotal }}">
<input type="hidden" id="cart_total_unit_cost" value="{{ $total_unit_cost }}">
