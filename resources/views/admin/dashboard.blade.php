@extends('layouts.admin_layout.admin_layout')

@section('content')
    <!---<div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </div>
                    </div>----->
    <br>
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-10 col-sm-12">
                    <form role="form" action="{{ route('admin.sale.store') }}" method="POST"
                        enctype="multipart/form-data" . onsubmit="return formSaleValidation()" id="saleForm">
                        @csrf

                        <fieldset>
                            <legend>
                                {{ __('message.bill_information') }} ({{__('message.bill_information', [], $secondary_locale)}})
                            </legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <label> {{ __('message.search_bill') }} ({{__('message.search_bill', [], $secondary_locale)}})</label>
                                    <div class="input-group-append">
                                        {{-- <input  type="text" name="search_bill" id="search_bill"
                                        value="" class="form-control" placeholder="Search Bill ..."/> --}}
                                        <select name="search_sale_id" id="search_sale_id" class="form-control select2"
                                            data-placeholder="Select an Sale Bill" data-tags="true" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($sales as $sale)
                                                <option value="{{ $sale->id }}"> {{ $sale->bill_no }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2 mt-3">
                                    <button type="button" id="invoice_print" class="btn btn-success">
                                        {{ __('message.print') }} ({{__('message.print', [], $secondary_locale)}}) </button>
                                </div>

                                <div class="col-md-6">
                                    <label for="bill_type">{{ __('message.bill_type') }} ({{__('message.bill_type', [], $secondary_locale)}})</label>
                                    <select name="bill_type" id="bill_type" class="form-control select2"
                                        data-placeholder="Select an Bill Type" data-tags="true" data-allow-clear="true">
                                        <option value="Sales">Sales </option>
                                        <option value="Sales Returns">Sales Returns </option>
                                    </select>
                                </div>
                            </div>

                            <div id="sale_information_div">
                                <div class="row">

                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="bill_no">{{ __('message.bill_no') }} ({{__('message.bill_no', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">
                                        <input type="text" name="bill_no" id="bill_no" value="{{ $bill_no }}"
                                            class="form-control " readonly placeholder="{{ __('message.bill_no') }}">
                                    </div>

                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="bill_date">{{ __('message.bill_date') }} ({{__('message.bill_date', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">

                                        <input type="date" name="bill_date" id="bill_date"
                                            value="{{ old('bill_date') ?? date('Y-m-d') }}" class="form-control "
                                            placeholder="{{ __('message.bill_date') }}">
                                    </div>

                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="customer_id">{{ __('message.customer') }} ({{__('message.customer', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">

                                        <select name="customer_id" id="customer_id" class="form-control select2"
                                            data-placeholder="Select an Customer" data-tags="true" data-allow-clear="true">
                                            <option></option>
                                            <option value="0">New Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->phone }} - {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="customer_id">{{ __('message.branch') }} ({{__('message.branch', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">

                                        <select name="branch_id" id="branch_id" class="form-control select2"
                                            data-placeholder="Select an Branch" data-tags="true" data-allow-clear="true" required>
                                            <option></option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row" id="customer_information_div" style="margin-top: 5px; display:none">
                                        <div class="col-md-3">
                                            <label for="customer_name"> Customer Name </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="customer_name" id="customer_name"
                                                class="form-control" placeholder="Customer Name">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="customer_vat_no">Customer Vat No</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="customer_vat_no" id="customer_vat_no"
                                                class="form-control" placeholder="Customer Vat No">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="customer_phone">Customer Phone</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="customer_phone" id="customer_phone"
                                                class="form-control" placeholder="Customer Phone">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="customer_address">Customer Address</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="customer_address" id="customer_address"
                                                class="form-control" placeholder="Customer Address">
                                        </div>
                                    </div>


                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="note">{{ __('message.note') }} ({{__('message.note', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-10" style="margin-top: 5px">
                                        <input type="text" name="note" id="note" value="{{ old('note') }}"
                                            class="form-control " placeholder="{{ __('message.note') }}">
                                    </div>

                                    <div class="col-md-3" style="margin-top: 5px">
                                        <label>{{ __('message.scan_your_bar_code') }} ({{__('message.scan_your_bar_code', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 5px">

                                        <input style="background-color:#FFD700;" type="text" name="bar_code"
                                            id="bar_code" value="" class="form-control"
                                            placeholder="Scan Your Bar Code.." autofocus />
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <label> {{ __('message.item') }} ({{__('message.item', [], $secondary_locale)}})</label>
                                            </div>
                                            <div class="col-sm-8" style="margin-top: 5px">
                                                <select id="item_id" class="form-control select2"
                                                    data-placeholder="Select an Item" data-tags="true"
                                                    data-allow-clear="true">
                                                    <option></option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->code }} - {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-2" style="margin-top: 5px">
                                                <button type="button" class="btn btn-success btn-block"
                                                    id="item_add_button">
                                                    {{ __('message.add') }} ({{__('message.add', [], $secondary_locale)}})
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="bill_item_table" style="margin-top: 5px; margin-bottom: 10px">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="10%">
                                                    <button type="button" class="btn" style="color:black;">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </th>
                                                <th class="text-center" width="15%">{{ __('message.amount') }} ({{__('message.amount', [], $secondary_locale)}})</th>
                                                <th class="text-center" width="15%">{{ __('message.price') }} ({{__('message.price', [], $secondary_locale)}})</th>
                                                <th class="text-center" width="10%">{{ __('message.quantity') }} ({{__('message.quantity', [], $secondary_locale)}})</th>
                                                <th class="text-center" width="20%">{{ __('message.image') }}  ({{__('message.image', [], $secondary_locale)}})</th>
                                                <th class="text-center" width="30%">{{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}})</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <input type="hidden" id="cart_total_item" value="0">
                                    <input type="hidden" id="cart_total_amount" value="0">
                                    <input type="hidden" id="cart_total_tax_amount" value="0">
                                    <input type="hidden" id="cart_total_unit_cost" value="0">
                                </div>

                                <div class="row">
                                    {{-- subtotal_amount --}}
                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="subtotal_amount">{{ __('message.subtotal') }} ({{__('message.subtotal', [], $secondary_locale)}})</label>
                                    </div>

                                    <div class="col-md-4" style="margin-top: 5px">
                                        <input type="hidden" name="total_unit_cost" id="total_unit_cost"
                                            value="0">

                                        <input type="text" name="subtotal_amount" id="subtotal_amount"
                                            value="{{ old('subtotal_amount') }}" class="form-control" readonly
                                            placeholder="{{ __('message.sub_total_amount') }}">
                                    </div>
                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="total_item">{{ __('message.total_item') }} ({{__('message.total_item', [], $secondary_locale)}})</label>
                                    </div>
                                    {{-- total_item --}}
                                    <div class="col-md-4" style="margin-top: 5px">

                                        <input type="text" name="total_item" id="total_item"
                                            value="{{ old('total_item') }}" class="form-control " readonly
                                            placeholder="{{ __('message.total_item') }}">
                                    </div>
                                    {{-- discount_amount --}}
                                    <div class="col-md-3" style="margin-top: 5px">
                                        <label for="discount_amount">{{ __('message.discount_amount') }} ({{__('message.discount_amount', [], $secondary_locale)}})</label>
                                    </div>

                                    <div class="col-md-3" style="margin-top: 5px">

                                        <input type="text" name="discount_amount" id="discount_amount" value="0"
                                            class="form-control discount_amount"
                                            placeholder="{{ __('message.discount_amount') }}">
                                    </div>
                                    {{-- total_tax_amount --}}
                                    <div class="col-md-3" style="margin-top: 5px">
                                        <label for="total_tax_amount">{{ __('message.tax_amount') }} ({{__('message.tax_amount', [], $secondary_locale)}})
                                            ({{ $application->vat_percent }}%)</label>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 5px">

                                        <input type="text" name="total_tax_amount" id="total_tax_amount"
                                            value="{{ old('total_tax_amount') }}" class="form-control " readonly
                                            placeholder="{{ __('message.tax_amount') }}">
                                    </div>
                                    {{-- total_amount --}}
                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="total_amount">{{ __('message.total') }} ({{__('message.total', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">
                                        <input type="text" name="total_amount" id="total_amount"
                                            value="{{ old('total_amount') }}" class="form-control " readonly
                                            placeholder="{{ __('message.total_amount') }}">
                                    </div>

                                    {{-- pay_amount --}}
                                    <div class="col-md-2" style="margin-top: 5px; display: none;" id="pay_amount_label">
                                        <label for="pay_amount">{{ __('message.pay_amount') }} ({{__('message.pay_amount', [], $secondary_locale)}})</label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px; display:none;" id="pay_amount_input_div">
                                        <input type="text" name="pay_amount" id="pay_amount"
                                            value="{{ old('pay_amount') }}" class="form-control "
                                            placeholder="{{ __('Pay Amount') }}">
                                    </div>
                                    
                                    {{-- due_payment --}}
                                    <div class="col-md-2" style="margin-top: 5px; display:none" id="due_payment_label">
                                        <label for="due_payment">{{ __('message.due_payment') }} ({{__('message.due_payment', [], $secondary_locale)}}) </label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px; display:none" id="due_payment_input_div">
                                        <input type="text" name="due_payment" id="due_payment"
                                            value="{{ old('due_payment') }}" class="form-control " readonly
                                            placeholder="{{ __('Due Payment') }}">
                                    </div>
                                    
                                    <div class="col-md-6" style="margin-top: 5px">
                                        <button type="button"
                                            class="btn btn-danger delete-all-cart-item">{{ __('message.delete_all') }}</button>

                                    </div>

                                    <div class="col-md-12 text-center" style="margin-top: 5px">
                                        <p style="margin-bottom: 0px">{{ __('message.please_select_payment_type') }} ({{__('message.please_select_payment_type', [], $secondary_locale)}}):</p>
                                        <input type="radio" id="credit" name="payment_type" value="credit">
                                        <label for="credit">{{ __('message.credit') }} ({{__('message.credit', [], $secondary_locale)}})</label>
                                        <input type="radio" id="credit card" name="payment_type" value="credit card">
                                        <label for="credit card">{{ __('message.credit_card') }} ({{__('message.credit_card', [], $secondary_locale)}})</label>
                                        <input type="radio" id="Mada" name="payment_type" value="Mada">
                                        <label for="Mada">{{ __('message.mada') }} ({{__('message.mada', [], $secondary_locale)}})</label>
                                        <input type="radio" id="Cash" name="payment_type" value="Cash"
                                            checked="checked">
                                        <label for="Cash"> {{ __('message.cash') }} ({{__('message.cash', [], $secondary_locale)}})</label>
                                    </div>

                                    <div class="col-md-12 text-center mt-2">
                                        <button type="submit" name="btn" value="print"
                                            class="btn btn-success">{{ __('message.print') }} ({{__('message.print', [], $secondary_locale)}})</button>

                                        <button type="submit" name="btn" value="save_and_print"
                                            class="btn btn-success">{{ __('message.save_and_print') }} ({{__('message.save_and_print', [], $secondary_locale)}})</button>
                                    </div>
                                </div>
                            </div>
                            <div id="return_sale_information_div">
                            </div>

                        </fieldset>
                    </form>
                </div>

                <div class="col-lg-2 col-sm-12">
                    <div class="row" style="padding: 10px;">
                        <div class="col-md-12 text-left">

                            <span class="text-bold ">{{ __('message.edit') }}</span>

                            <input type="checkbox" value="1" id="edit_mode_checkbox" data-bootstrap-switch
                                data-on-text="{{ __('message.yes') }}" data-off-text="{{ __('message.no') }}"
                                data-off-color="danger" data-on-color="success" />
                        </div>
                    </div>

                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <div class=""
                            style="max-height: 100px; height: 80px; padding: 2px; width:132px; margin:2px">
                            <div class="small-box bg-danger text-center add-other-sale-item">
                                <div style="font-size:24px; max-height: 100px; height: 60px;">
                                    {{ __('message.other') }} ({{__('message.other', [], $secondary_locale)}})
                                </div>
                            </div>
                        </div>
                        @php
                            $color_array = ['1266F1', 'B23CFD', '00B74A', 'F93154', '39C0ED', '262626'];
                            $colorNumber = 0;
                        @endphp

                        {{-- @foreach ($easySaleItems as $easySaleItem)
                            <div class="" style="max-height: 100px; font-size:12px; height: 80px; width:132px; padding: 2px; margin:2px">
                                @if ($easySaleItem->item)
                                    <div class="small-box  text-center add-sale-item"
                                        style="background-color: #{{ $color_array[$colorNumber] }}; color:white"
                                        data-easy-sale-id="{{ $easySaleItem->id }}"
                                        data-item-id="{{ $easySaleItem->item->id }}"
                                        >
                                        <div style="font-size:12px;" >
                                            @if ($easySaleItem->item->image != null)
                                                <img src="{{ $easySaleItem->item->image_path }}"
                                                    class="img-fluid "
                                                    style="height: 50px; 90px" alt="Item"> <br>
                                            @endif
                                            {{ $easySaleItem->item->code }} <br> {{ $easySaleItem->item->name }} <br>Buy Price: {{ $easySaleItem->item->purchase_price }}
                                        </div>
                                    </div>
                                @else
                                    <div class="small-box text-center add-new-item"
                                    style="background-color: #{{ $color_array[$colorNumber] }}; color:white"
                                        data-easy-sale-id="{{ $easySaleItem->id }}"
                                        >
                                        <div class="inner" >
                                            <i class="fa fa-plus fa-3x" ></i>
                                        </div>
                                    </div>
                                @endif
                               @php
                                    $colorNumber++;
                                    if(count($color_array) -1  < $colorNumber){
                                        $colorNumber = 0;
                                    }
                               @endphp

                            </div>
                        @endforeach --}}
                    </div>
                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <a href="{{ route('admin.buy-product-entry.index') }}" class="btn btn-success"> ({{__('message.buy_product_report', [], $secondary_locale)}}) <br> {{ __('message.buy_product_report') }}</a>
                    </div>
                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <a href="{{ route('admin.expense-head.index') }}" class="btn btn-success"> ({{__('message.expense_head', [], $secondary_locale)}}) <br> {{ __('message.expense_head') }}</a>
                    </div>
                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <a href="{{ route('admin.expense.index') }}" class="btn btn-success">({{__('message.expense', [], $secondary_locale)}}) <br> {{ __('message.expense') }}</a>
                    </div>
                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <a href="{{ route('admin.customer.index') }}" class="btn btn-success">({{__('message.customer', [], $secondary_locale)}}) <br> {{ __('message.customer') }}</a>
                    </div>
                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <a href="{{ route('admin.due-payment.index') }}" class="btn btn-success">({{__('message.due_payment', [], $secondary_locale)}}) <br> {{ __('message.due_payment') }}</a>
                    </div>
                    <div class="row" style="padding: 2px; max-height: 750px;">
                        <a href="{{ route('admin.customer.ledger') }}" class="btn btn-success">({{__('message.customer_ledger', [], $secondary_locale)}}) <br> {{ __('message.customer_ledger') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="viewModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">{{ __('message.view') }} ({{__('message.view', [], $secondary_locale)}})</h4>
                    <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="showResult">
                    <div class="row" style="padding: 10px;">
                        <div class="col-md-12 text-right">
                            @if (auth_admin_user_permission('item.create'))
                                <a href="{{ route('admin.item.create') }}" target="_blank"
                                    class="btn btn-success float-right">
                                    <i class="fa fa-pencil-alt"></i>
                                    {{ __('message.add_item') }} ({{__('message.add_item', [], $secondary_locale)}})
                                </a>
                            @endif
                        </div>
                    </div>

                    <form role="form" action="{{ route('admin.easySaleItem.update') }}" method="POST"
                        enctype="multipart/form-data" . onsubmit="return formEasySaleValidation()">
                        @csrf
                        <input type="hidden" name="easy_sale_id" id="easy_sale_id">
                        <div class="card-body row" id="item_id_div">
                            <table class="table table-bordered table-striped ">
                                <tr>
                                    <th width="5%" class="text-center"> </th>
                                    <th width="20%" class="text-center">Code</th>
                                    <th width="25%" class="text-center">Name</th>
                                    <th width="20%" class="text-center">Price</th>
                                    <th width="30%" class="text-center">Image</th>
                                </tr>
                                @foreach ($items as $item)
                                    <tr>
                                        <th class="text-center">
                                            <div class="custom-control custom-radio text-center">
                                                <input class="custom-control-input item_id_checkbox" type="radio"
                                                    id="item_id{{ $item->id }}" name="item_id"
                                                    value="{{ $item->id }}">
                                                <label for="item_id{{ $item->id }}" class="custom-control-label">
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-center">{{ $item->code }}</th>
                                        <th class="text-center">{{ $item->name }}</th>
                                        <th class="text-center">{{ number_format($item->price, 2) }}</th>
                                        <th class="text-center">
                                            @if ($item->image != null)
                                                <img src="{{ $item->image_path }}" class="img-fluid img-thumbnail"
                                                    style="height: 100px" alt="Customer"> <br>
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            </table>

                            @error('item_id')
                                <span class="alert invalid-feedback" role="alert"
                                    style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-success">
                                {{ __('message.submit') }} ({{__('message.submit', [], $secondary_locale)}})
                            </button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal">
                        {{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="printPreviewModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body" id="showPrintPreviewResult">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-right " id="closePrintPreviewModal"
                        data-dismiss="modal">
                        {{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style_css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .content-header {
            font-size: 16px !important;
        }

        .content {
            font-size: 16px !important;
        }

        .form-control {
            font-size: 16px !important;
            height: calc(1.6rem + 2px)
        }

        .btn {
            font-size: 16px !important;
        }

        .select2-container .select2-selection--single {
            height: 24px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 16px !important;
        }
    </style>
@endpush


@push('script_js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <script>
        window.onload = function() {
            $(document).on("change", "#customer_id", function(e) {
                var customer_id = $("#customer_id option:selected").val();

                if (customer_id == 0 && customer_id != '') {
                    document.getElementById('customer_information_div').style.display = '';
                    document.getElementById('customer_name').required = true;
                    document.getElementById('customer_vat_no').required = true;
                    document.getElementById('customer_phone').required = true;
                    document.getElementById('customer_address').required = true;
                } else {
                    document.getElementById('customer_information_div').style.display = 'none';
                    document.getElementById('customer_name').required = false;
                    document.getElementById('customer_vat_no').required = false;
                    document.getElementById('customer_phone').required = false;
                    document.getElementById('customer_address').required = false;
                }
                console.log(customer_id);
            });

            $(document).on("click", ".add-new-item", function(e) {
                var easy_sale_id = $(this).data('easy-sale-id');
                $("#easy_sale_id").val(easy_sale_id);

                $("#viewModal").modal('show');
            });

            $(document).on("click", "#item_add_button", function(e) {
                var item_id = $('#item_id option:selected').val();
                if (item_id) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        data: {
                            item_id,
                        },
                        error: function(xhr) {
                            console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                        },
                        url: "{{ route('admin.sale.addCartSaleItem') }}",
                        success: function(response) {
                            $("#bill_item_table").html(response);
                            $('#bar_code').val('');
                            $('#search_bill').val('');
                            $('#item_id').val('').change();
                        }
                    });
                } else {
                    toastr.error("Please Select Item");
                }

            });

            $(document).on("click", ".add-other-sale-item", function(e) {
                $.ajax({
                    cache: false,
                    type: "POST",
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.addCartOtherSaleItem') }}",
                    success: function(response) {
                        $("#bill_item_table").html(response);
                    }
                });
            });

            $(document).on('click', '.add-sale-item', function() {
                var edit_mode_checkbox = $('#edit_mode_checkbox').is(":checked");
                if (edit_mode_checkbox) {
                    var easy_sale_id = $(this).data('easy-sale-id');
                    var item_id = $(this).data('item-id');

                    $(`.item_id_checkbox`).attr('checked', false);

                    $(`#item_id${item_id}`).attr('checked', true);


                    $("#easy_sale_id").val(easy_sale_id);
                    $("#viewModal").modal('show');
                    return false;
                }

                var easy_sale_id = $(this).data('easy-sale-id');
                $.ajax({
                    cache: false,
                    type: "POST",
                    data: {
                        easy_sale_id: easy_sale_id,
                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.addCartSaleItem') }}",
                    success: function(response) {
                        //alert(response);
                        $("#bill_item_table").html(response);
                    }
                });

            });

            $(document).on('click', '.delete-all-cart-item', function() {
                $.ajax({
                    cache: false,
                    type: "POST",
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.deleteAllCartSaleItem') }}",
                    success: function(response) {
                        //alert(response);
                        $("#bill_item_table").html(response);
                    }
                });

            });

            $(document).on('click', '.remove_cart', function() {
                var item_id = $(this).data('id');
                $.ajax({
                    cache: false,
                    type: "POST",
                    data: {
                        item_id: item_id,
                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.removeCartSaleItem') }}",
                    success: function(response) {
                        $("#bill_item_table").html(response);
                    }
                });
            });

            $(document).on('focusout', '.sale_item_price', function() {
                var item_id = $(this).data('id');
                var item_price = $(this).val();

                $.ajax({
                    cache: false,
                    type: "POST",
                    data: {
                        item_id: item_id,
                        item_price: item_price,
                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.updateCartSaleItemPrice') }}",
                    success: function(response) {
                        $("#bill_item_table").html(response);
                    }
                });
            });

            $(document).on('focusout', '.sale_item_quantity', function() {
                var item_id = $(this).data('id');
                var item_quantity = $(this).val();

                $.ajax({
                    cache: false,
                    type: "POST",
                    data: {
                        item_id: item_id,
                        item_quantity: item_quantity,
                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.updateCartSaleItemQuantity') }}",
                    success: function(response) {
                        $("#bill_item_table").html(response);
                    }
                });
            });

            $(document).on('focusout', '.sale_item_amount', function() {
                var item_id = $(this).data('id');
                var quantity = $(`#sale_item_quantity${item_id}`).val();
                var item_amount = $(this).val();

                $.ajax({
                    cache: false,
                    type: "POST",
                    data: {
                        item_id: item_id,
                        quantity: quantity,
                        item_amount: item_amount,
                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.updateCartSaleItemAmount') }}",
                    success: function(response) {
                        $("#bill_item_table").html(response);
                    }
                });
            });

            $(document).on('focusout', '.sale_item_name', function() {
                var item_id = $(this).data('id');
                var item_name = $(this).val();

                $.ajax({
                    cache: false,
                    type: "POST",
                    data: {
                        item_id: item_id,
                        item_name: item_name,
                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.updateCartSaleItemName') }}",
                    success: function(response) {
                        $("#bill_item_table").html(response);
                    }
                });
            });

            $(document).on('keyup', '.discount_amount', function() {
                var discount_amount = $(this).val();
                $('.discount_amount').val(discount_amount);
            });

            $(document).on('click', '#print_preview', function() {
                $("#printPreviewModal").modal('show');
                $.ajax({
                    cache: false,
                    type: "POST",
                    data: $('#saleForm').serialize(),
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: "{{ route('admin.sale.printPreview') }}",
                    success: function(response) {
                        $("#showPrintPreviewResult").html(response);
                    }
                });
            });

            $(document).on('keypress', function(e) {
                if (e.which == 13) {
                    e.preventDefault();

                    //var search_bill = $("#search_bill").val().trim();
                    var search_bill = '';
                    var bar_code = $('#bar_code').val().trim();


                    if (search_bill.length > 0 && bar_code.length > 0) {
                        toastr.error("Error");
                        $('#bar_code').val('');
                        $('#search_bill').val('');
                        return false;
                    }


                    if (search_bill.length > 0) {
                        /** product add to cart code */
                        $.ajax({
                            cache: false,
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                search_bill: search_bill,
                            },
                            error: function(xhr) {
                                console.log("An error occurred: " + xhr.status + " " + xhr
                                    .statusText);
                            },
                            url: "{{ route('admin.sale.searchBill') }}",
                            success: function(response) {
                                console.log(response);
                                if (response && response.id) {
                                    var id = response.id;
                                    var url = "{{ route('admin.sale.salePrint', [':id', 1]) }}";
                                    url = url.replace(':id', id);
                                    window.open(url, '_blank');
                                } else {
                                    toastr.error("Bill Information not found.");
                                }

                                $('#bar_code').val('');
                                $('#search_bill').val('');
                            }
                        });
                        return false;
                    }

                    if (bar_code.length > 0) {
                        /** product add to cart code */
                        $.ajax({
                            cache: false,
                            type: "POST",
                            data: {
                                bar_code: bar_code,
                            },
                            error: function(xhr) {
                                console.log("An error occurred: " + xhr.status + " " + xhr
                                    .statusText);
                            },
                            url: "{{ route('admin.sale.addCartSaleItemBarcode') }}",
                            success: function(response) {
                                $("#bill_item_table").html(response);
                                $('#bar_code').val('');
                                $('#search_bill').val('');
                            }
                        });
                        return false;
                    }
                }
            });

            $(document).on("change", "#search_sale_id", function(e) {
                // var sale_id = $("#search_sale_id option:selected").val();
                // if(sale_id){
                //     var id = sale_id;
                //     var url         = "{{ route('admin.sale.salePrint', [':id', 1]) }}";
                //     url = url.replace(':id', id);
                //     window.open(url, '_blank');
                // }
            });

            $(document).on("click", "#invoice_print", function(e) {
                var sale_id = $("#search_sale_id option:selected").val();
                if (sale_id) {
                    var id = sale_id;
                    var url = "{{ route('admin.sale.salePrint', [':id', 1]) }}";
                    url = url.replace(':id', id);
                    window.open(url, '_blank');
                }
            });

            $(document).on("change", "#bill_type", function(e) {
                var sale_id = $("#search_sale_id option:selected").val();
                var bill_type = $("#bill_type option:selected").val();

                if (bill_type == 'Sales Returns' && sale_id) {
                    var url = "{{ route('admin.sale.returnSaleConfirm', [':id']) }}";
                    url = url.replace(':id', sale_id);

                    $('#saleForm').attr('action', url);

                    var url = "{{ route('admin.sale.returnSale', [':id']) }}";
                    url = url.replace(':id', sale_id);
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: url,
                        error: function(xhr) {
                            console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                        },
                        success: function(response) {
                            $("#return_sale_information_div").show().html(response);
                            $("#sale_information_div").hide();
                            $(".select2").select2();

                        }
                    });
                } else {
                    $('#saleForm').attr('action', '{{ route('admin.sale.store') }}');
                    $("#return_sale_information_div").hide();
                    $("#sale_information_div").show();
                }

            });
        }



        function formSaleValidation(e) {
            if ($('#bill_type option:selected').val() == 'Sales Returns') {

            } else {
                if (!select_null_field_validation('bill_type', 'Please Select bill Type')) return false;
                if (!$("input:radio[name='payment_type']").is(":checked")) {
                    toastr.error("Please Select Payment Type");
                    return false;
                }
            }

        }


        function formEasySaleValidation() {
            var item_id = $("#item_id_div input[type='radio']:checked").val();
            if (!item_id) {
                toastr.error("Please Select Any Item");
                return false;
            }
            if (!input_field_validation('easy_sale_id', 'Something is wrong ')) return false;
        }

        $(document).on("change", "#customer_id", function(e) {
            const selectedOption = $(this).find(":selected");

            if ($(this).val()) {
                // Show the payment section if a customer is selected
                $("#pay_amount_input_div").css("display", "flex");
                $("#pay_amount_label").css("display", "flex");
                $("#due_payment_input_div").css("display", "flex");
                $("#due_payment_label").css("display", "flex");

            } else {
                // Hide the payment section if no customer is selected
                // $("#payment-section").css("display", "none");

                $("#pay_amount_input_div").css("display", "none");
                $("#pay_amount_label").css("display", "none");
                $("#due_payment_input_div").css("display", "none");
                $("#due_payment_label").css("display", "none");

                // Clear the input fields
                $("#pay_amount").val("");
                $("#due_payment").val("");
            }
        });

        setInterval(() => {
            var cart_total_item = returnNumber($(`#cart_total_item`).val());
            var cart_total_amount = returnNumber($(`#cart_total_amount`).val());
            var cart_total_unit_cost = returnNumber($(`#cart_total_unit_cost`).val());

            var discount_amount = returnNumber($(`#discount_amount`).val());
            var pay_amount = returnNumber($(`#pay_amount`).val());

            var grand_amount1 = cart_total_amount - discount_amount;
            var grand_amount = grand_amount1 - (grand_amount1 / 100 * {{ $application->vat_percent }});
            var total_tax_amount = 0;
            if (grand_amount1 != 0) {
                var total_tax_amount = grand_amount1 / 100 * {{ $application->vat_percent }};
            }
            var duePayment = grand_amount1 - pay_amount;
            var total_amount = grand_amount1

            var payAmount =
                $(`#final_price`).val(cart_total_amount.toFixed(2));
            $(`#subtotal_amount`).val(grand_amount.toFixed(2));
            $(`#total_item`).val(cart_total_item);
            $(`#total_tax_amount`).val(total_tax_amount.toFixed(2));
            $(`#total_amount`).val(total_amount.toFixed(2));
            $(`#total_unit_cost`).val(cart_total_unit_cost.toFixed(2));
            $(`#due_payment`).val(duePayment.toFixed(2));

            // console.log(cart_total_item, cart_total_amount, cart_total_tax_amount);

        }, 300);
    </script>
@endpush
