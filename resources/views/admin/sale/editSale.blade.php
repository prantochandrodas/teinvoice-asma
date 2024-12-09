<div class="row" >
    <div class="col-md-2" style="margin-top: 5px">
        <label for="bill_no">{{ __('message.bill_no') }}</label>
        </div>
        <div class="col-md-4" style="margin-top: 5px">
        <input type="text" name="bill_no" id="bill_no"
            value="{{ $sale->bill_no }}"
            class="form-control "
            readonly
            placeholder="{{ __('message.bill_no') }}">
    </div>

    <div class="col-md-2" style="margin-top: 5px">
        <label for="return_date">Return Date </label>
    </div>
    <div class="col-md-4" style="margin-top: 5px">

        <input type="date" name="return_date" id="return_date"
            value="{{ date('Y-m-d') }}"
            class="form-control "
            placeholder="Return Date">
    </div>

    <div class="col-md-2" style="margin-top: 5px">
    <label for="customer_id">{{ __('message.customer') }} </label>
    </div>
    <div class="col-md-10" style="margin-top: 5px; pointer-events:none;" >
        <select name="customer_id" id="customer_id" class="form-control select2"
        data-placeholder="Select an Customer"
        data-tags="true"
        data-allow-clear="true"
        >
            <option></option>
            <option value="0">New Customer</option>
            @foreach ($customers as $customer)

                <option value="{{ $customer->id }}"@if($sale->customer_id == $customer->id) selected @endif >
                    {{ $customer->phone }} - {{ $customer->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2" style="margin-top: 5px">
    <label for="note">{{ __('message.note') }} </label>
    </div>
    <div class="col-md-10" style="margin-top: 5px">
        <input type="text" name="note" id="note"
            class="form-control "
            placeholder="{{ __('message.note') }}">
    </div>
</div>

<div class="row"  style="margin-top: 5px; margin-bottom: 10px">

    <table class="table table-bordered" style="font-size: 13px;">
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
                $total_amount = 0;
            @endphp
            @foreach ($sale->sale_details as $sale_detail)
                @if ($sale_detail->current_quantity > 0)
                    @php
                        $total_amount +=  $sale_detail->price  *  $sale_detail->quantity ;
                    @endphp
                    <tr >
                        <td class="text-center">
                            <button type="button"
                                class="btn remove_return_cart"
                                style="color:red;">
                                <i class="fa fa-trash"></i>
                            </button>
                            <input type="hidden"  value="{{ $sale_detail->id }}" name="sale_detail_id[]" >
                            <input type="hidden"  value="{{ $sale_detail->price }}" id="return_price{{ $sale_detail->id }}"
                            name="return_price[]"  data-id="{{ $sale_detail->id }}"  class="return_price ">
                        </td>
                        <td class="text-center">
                            <input type="number"  value="{{ $sale_detail->amount }}" id="return_amount{{ $sale_detail->id }}"
                            name="return_amount[]"
                            readonly
                            data-id="{{ $sale_detail->id }}"  class="form-control return_amount text-center" placeholder="Sales Item Price">
                        </td>
                        <td class="text-center">
                            {{ $sale_detail->price }}

                        </td>
                        <td class="text-center">
                            <input type="number"  value="{{ $sale_detail->quantity }}" id="return_quantity{{ $sale_detail->id }}"
                            name="return_quantity[]"
                            data-max="{{ $sale_detail->quantity }}"
                            data-id="{{ $sale_detail->id }}"  class="form-control return_quantity text-center" placeholder="Sales Item Price">
                        </td>
                        <td class="text-center">
                            {{ $sale_detail->item->code }}
                        </td>
                        <td class="text-center">
                            {{ $sale_detail->item->name }}
                        </td>
                    </tr>
                @endif

            @endforeach
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-2" style="margin-top: 5px">
        <label for="subtotal_amount">{{ __('message.subtotal') }}  </label>
        </div>
    <div class="col-md-4" style="margin-top: 5px">
        <input type="hidden" name="total_unit_cost" id="total_unit_cost" value="0" >

        <input type="text" name="return_subtotal_amount" id="return_subtotal_amount"
            value="{{ $total_amount }}"
            class="form-control"
            readonly
            placeholder="{{ __('message.sub_total_amount') }}">
    </div>
    <div class="col-md-2" style="margin-top: 5px">
        <label for="total_item">{{ __('message.total_item') }} </label>
        </div>
    <div class="col-md-4" style="margin-top: 5px">

        <input type="text" name="return_total_item" id="return_total_item"
            value="{{ $sale->total_quantity  }}"
            class="form-control "
            readonly
            placeholder="{{ __('message.total_item') }} ">
    </div>


    <div class="col-md-12 text-center" style="margin-top: 5px">
        <p style="margin-bottom: 0px">Please select Payment Type:</p>
        <input type="radio" id="credit" name="payment_type" value="credit">
        <label for="credit">Credit</label>
        <input type="radio" id="credit card" name="payment_type" value="credit card">
        <label for="credit card">Credit Card</label>
        <input type="radio" id="Mada" name="payment_type" value="Mada">
        <label for="Mada">Mada</label>
        <input type="radio" id="Cash" name="payment_type" value="Cash">
        <label for="Cash"> Cash</label>
    </div>

    <div class="col-md-12 text-center mt-2">
        <button type="submit" name="btn" value="print"
        class="btn btn-success">Return</button>
    </div>
</div>

<script>
    $(".remove_return_cart").on('click', function(){
        $(this).parent().parent().remove();
        return_calculation();

    });
    $(".return_price").on('change', function(){
        return_calculation();
    });
    $(".return_price").on('key', function(){
        return_calculation();
    });
    $(".return_quantity").on('change', function(){
        return_calculation();
    });
    $(".return_quantity").on('key', function(){
        return_calculation();
    });

    function return_calculation(){
        var  total_return_amount = 0;
        var  return_total_item = 0;

        $(".return_price").map(function(){
            var id  = $(this).data('id');

            var return_price        = returnNumber($(`#return_price${id}`).val());
            var return_quantity     = returnNumber($(`#return_quantity${id}`).val());
            var max                 = returnNumber($(`#return_quantity${id}`).data('max'));

            if(max < return_quantity){
                $(`#return_quantity${id}`).val(max);
                return_quantity = max;
            }
            if(return_quantity == 0){
                $(this).parent().parent().remove();
            }
            else{
                $(`#return_amount${id}`).val(return_quantity * return_price);
                total_return_amount += return_quantity * return_price;
                return_total_item += return_quantity;
            }

        });

        $(`#return_subtotal_amount`).val(total_return_amount);
        $(`#return_total_item`).val(return_total_item);
    }

</script>
