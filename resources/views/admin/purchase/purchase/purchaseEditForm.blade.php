@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Purchase Form </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Update Purchase Form </li>
            </ol>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form"
                                action="{{ route('admin.purchase.update', $purchase->id) }}"
                                method="POST" enctype="multipart/form-data"
                                onsubmit="return createForm()">
                                @method('patch')
                                @csrf
                                <input type="hidden" name="total_item" id="total_item" value="0" >
                                <fieldset>
                                    <legend>Purchase Raw Raw Item </legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table ">
                                                <tr>
                                                    <th >Invoice No </th>
                                                    <td colspan="2">
                                                        <input type="text" name="invoice_no" id="invoice_no" placeholder="Purchase Invoice No" value="{{ $purchase->invoice_no }}"
                                                        class="form-control @error('invoice_no') is-invalid @enderror" >
                                                        @error('invoice_no') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th >Date</th>
                                                    <td colspan="2">
                                                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="form-control @error('date') is-invalid @enderror" required>
                                                        @error('date') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th >Supplier </th>
                                                    <td colspan="2">
                                                        <select name="supplier_id" id="supplier_id" class="form-control select2  @error('supplier_id') is-invalid @enderror" style="width: 100%" >
                                                            <option value="0" >Select Supplier </option>
                                                            @if ($suppliers->count())
                                                                @foreach ($suppliers as $supplier)
                                                                    <option value="{{ $supplier->id }}"
                                                                        data-name="{{ $supplier->name }}"
                                                                        data-contact_number="{{ $supplier->contact_number }}"
                                                                        data-address="{{ $supplier->address }}"
                                                                        @if($supplier->id == $purchase->supplier_id) selected="" @endif
                                                                    > {{ $supplier->name }}  - {{ $supplier->contact_number }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('supplier_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Supplier Name</th>
                                                    <td style="width: 5%"> : </td>
                                                    <td style="width: 55%">
                                                        <span id="view_supplier_name">{{ $purchase->supplier ?  $purchase->supplier->name : "Not Confirm"  }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Supplier Contact Number</th>
                                                    <td style="width: 5%"> : </td>
                                                    <td style="width: 55%">
                                                        <span id="view_supplier_contact_number">{{ $purchase->supplier ?  $purchase->supplier->contact_number : "Not Confirm"  }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Supplier Address</th>
                                                    <td style="width: 5%"> : </td>
                                                    <td style="width: 55%">
                                                        <span id="view_supplier_address">{{ $purchase->supplier ?  $purchase->supplier->address : "Not Confirm"  }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <textarea name="note" id="note"
                                                        class="form-control  @error('note') is-invalid @enderror"
                                                        placeholder="Purchase Note ">{{ $purchase->note }}</textarea>
                                                        @error('note') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table ">
                                                <tr>
                                                    <th colspan="3" class="text-center">
                                                        <h3> Invoice Summery </h3>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%"> Purchase Grand Amount</th>
                                                    <td style="width: 5%"> : </td>
                                                    <td style="width: 55%">
                                                        <input type="number" name="confirm_total_purchase_amount"  id="confirm_total_purchase_amount" placeholder="Purchase Grand Amount" value="0" class="form-control  @error('confirm_total_purchase_amount') is-invalid @enderror" readonly required style="text-align: right;">
                                                        @error('confirm_total_purchase_amount') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%"> Discount Amount</th>
                                                    <td style="width: 5%"> : </td>
                                                    <td style="width: 55%">
                                                        <input type="number" name="discount_amount"  id="discount_amount"
                                                        placeholder="Discount Amount" value="{{ $purchase->discount_amount }}"
                                                        class="form-control  @error('discount_amount') is-invalid @enderror"
                                                        required style="text-align: right;">
                                                        @error('discount_amount') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%"> Final Amount Amount</th>
                                                    <td style="width: 5%"> : </td>
                                                    <td style="width: 55%">
                                                        <input type="number" name="confirm_total_purchase_final_amount"  id="confirm_total_purchase_final_amount" placeholder="Final Amount Amount" value="0" class="form-control  @error('confirm_total_purchase_final_amount') is-invalid @enderror" readonly required style="text-align: right;">
                                                        @error('confirm_total_purchase_final_amount') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                                    </td>
                                                </tr>
                                            </table>

                                            <br> <br>

                                            <fieldset id="div_purchase_item" >
                                                <legend>Purchase Item </legend>
                                                <div class="row">
                                                    <div class="col-sm-12" id="show_cart_purchase_item">
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

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success" id="purchase_confirm_btn"> Confirm </button>
                                        <button type="reset" class="btn btn-primary">Reset</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-md-12 row" style="margin-top: 20px;">

                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" name="item_name"
                                    id="item_name"
                                    class="form-control search-box"
                                    placeholder="Enter Item Name / Code" >
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px;">
                                <button type="button" class="btn btn-info btn-block" onclick="return itemResult()">
                                    Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px;" id="rawMaterialItemTable">
                            <table class="table table-bordered table-striped"  style="background-color:white;width: 100%">
                                <thead>
                                    <tr  style="background-color: #a2bbca !important; font-family: Arial Black;font-size: 14px">
                                        <th width="5%" class="text-center">SL </th>
                                        <th width="20%" class="text-center">Code</th>
                                        <th width="25%" class="text-center">Name</th>
                                        <th width="15%" class="text-center">Quantity</th>
                                        <th width="15%" class="text-center">Price</th>
                                        <th width="10%" class="text-center">Amount</th>
                                        <th width="10%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="show_item">
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
                                                    data-iItem_id="{{ $item->id }}"
                                                    placeholder="Item Quantity" style="text-align: right; ">
                                                </td>
                                                <td class="text-center" >
                                                    <input type="number" name="item_price[]"
                                                    id="item_price{{ $item->id }}"
                                                    value="{{ $item->purchase_price }}"
                                                    data-iItem_id="{{ $item->id }}"
                                                    class="form-control"
                                                    placeholder="Item Price"
                                                    style="text-align: right; ">
                                                </td>
                                                <td class="text-center" >
                                                    <input type="number" name="item_amount[]"
                                                        id="item_amount{{ $item->id }}"
                                                        value="{{ $item->purchase_price }}"
                                                        class="form-control"
                                                        data-iItem_id="{{ $item->id }}"
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style_css')
<style>

</style>
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  <script>

    window.onload = function(){

        $('#supplier_id').on('change', function(){
            var supplier   = $("#supplier_id option:selected");
            var supplier_id   = supplier.val();

            if(supplier_id == 0 ){
                $("#view_supplier_name").html('Not Confirm');
                $("#view_supplier_contact_number").html('Not Confirm');
                $("#view_supplier_address").html('Not Confirm');
            } else{
                $("#view_supplier_name").html(supplier.data('name'));
                $("#view_supplier_contact_number").html(supplier.data('contact_number'));
                $("#view_supplier_address").html(supplier.data('address'));
            }

        });

        $('#item_name').keyup(function () {
            itemResult();
        });


        $(document).on('keyup', `input[name='item_quantity[]']`, function(){
            var rawMaterialItemId   = $(this).attr('data-iItem_id');
            var item_quantity       = returnNumber($(this).val());
            var item_price          = returnNumber($(`#item_price${rawMaterialItemId}`).val());
            var item_amount         = (item_quantity*item_price).toFixed(2);
            // console.log(rawMaterialItemId,item_quantity,item_price,item_amount);

            $(`#item_amount${rawMaterialItemId}`).val(item_amount);
        });

        $(document).on('keyup', `input[name='item_price[]']`, function(){
            var rawMaterialItemId   = $(this).attr('data-iItem_id');
            var item_price          = returnNumber($(this).val());
            var item_quantity       = returnNumber($(`#item_quantity${rawMaterialItemId}`).val());
            var item_amount         = (item_quantity*item_price).toFixed(2);
            // console.log(rawMaterialItemId,item_quantity,item_price,item_amount);

            $(`#item_amount${rawMaterialItemId}`).val(item_amount);
        });

        $(document).on('keyup', `input[name='item_amount[]']`, function(){
            var rawMaterialItemId   = $(this).attr('data-iItem_id');
            var item_amount         = returnNumber($(this).val());
            var item_quantity       = returnNumber($(`#item_quantity${rawMaterialItemId}`).val());
            var item_price          = 0;
            if(item_amount !=0 && item_quantity != 0){
                item_price          = (item_amount/item_quantity).toFixed(2);
            }
            // console.log(rawMaterialItemId,item_quantity,item_price,item_amount);

            $(`#item_price${rawMaterialItemId}`).val(item_price);
        });
    }

    setInterval(function(){
        var supplier_id         = $("#supplier_id").val();
        var cart_total_item     = returnNumber($("#cart_total_item").val());
        var cart_total_amount   = returnNumber($("#cart_total_amount").val());
        var discount_amount    = returnNumber($("#discount_amount").val());

        var final_amount_amount = cart_total_amount - discount_amount;

        $("#total_item").val(cart_total_item);
        $("#confirm_total_purchase_amount").val(cart_total_amount);
        $("#confirm_total_purchase_final_amount").val(final_amount_amount);


        if(cart_total_amount != 0 ){
            $("#purchase_confirm_btn").prop('disabled', false);
        }else{
            $("#purchase_confirm_btn").prop('disabled', true);
        }

    }, 300);

    function itemResult(){
        var item_name      = $("#item_name").val().trim();

        $.ajax({
            cache     : false,
            type      : "POST",
            data      : {
                item_name   : item_name,
                _token      : "{{ csrf_token() }}"
            },
            url       : "{{  route('admin.purchase.returnPurchaseItem') }}",
            error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
            success   : function(response){
                $("#show_item").html(response);
                return false;
            }
        });
    }

    function add_raw_item(id){
        var item_quantity   = $("#item_quantity"+id).val();
        var item_price      = $("#item_price"+id).val();

        if(item_quantity == '0'){
            toastr.error("Please Enter Item Quantity");
            return false;
        }

        if(item_price == '0' ){
            toastr.error("Please Enter Item Price");
            $("#item_price"+id).val();
            return false;
        }


        $.ajax({
            cache     : false,
            type      : "POST",
            data      : {
                item_id    : id,
                item_quantity           : item_quantity,
                item_price              : item_price,
                _token                  : "{{ csrf_token() }}"
            },
            url       : "{{  route('admin.purchase.purchaseItemAddCart') }}",
            error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
            success   : function(response){
                $("#show_cart_purchase_item").html(response);
                $("#item_quantity"+id).val(1);
                return false;
            }
        });
    }

    function delete_item(itemId){
        $.ajax({
            cache    : false,
            type     : 'POST',
            data     : {
                itemId           : itemId,
                _token          : "{{ csrf_token() }}",
            },
            url      : "{{ route('admin.purchase.purchaseItemDeleteCart') }}",
            error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
            success : function (response){
                $('#show_cart_purchase_item').html(response);
            }
        });
    }

    function update_item_quantity(itemId){
        var purchase_item_quantity = $("#purchase_item_quantity"+itemId).val();
        $.ajax({
            cache    : false,
            type     : 'POST',
            data     : {
                itemId    : itemId,
                quantity  : purchase_item_quantity,
                _token    : "{{ csrf_token() }}",
            },
            url      : "{{ route('admin.purchase.purchaseItemQtyUpdateCart') }}",
            error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
            success : function (response){
                $('#show_cart_purchase_item').html(response);
            }
        });
    }

    function update_item_price(itemId){
        var purchase_item_price = $("#purchase_item_price"+itemId).val();
        $.ajax({
            cache    : false,
            type     : 'POST',
            data     : {
                itemId      : itemId,
                price       : purchase_item_price,
                _token      : "{{ csrf_token() }}",
            },
            url      : "{{ route('admin.purchase.purchaseItemPriceUpdateCart') }}",
            error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
            success : function (response){
                $('#show_cart_purchase_item').html(response);
            }
        });
    }

    function createForm(){
        let total_item = $('#total_item').val();
        if(total_item == '0'){
            toastr.error("Please Add Item..");
            return false;
        }
    }

  </script>
@endpush
