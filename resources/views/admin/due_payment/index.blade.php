@extends('layouts.admin_layout.admin_layout')

@section('content')
    <br>
    <div class="content" >
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-sm-12">
                    <form role="form" action="{{ route('admin.due-payment.adjustment') }}" method="POST" enctype="multipart/form-data" .
                        onsubmit="return formSaleValidation()" id="saleForm">
                        @csrf

                        <fieldset>
                            <legend>
                                {{ __('message.due_payment') }} ({{__('message.due_payment', [], $secondary_locale)}})
                            </legend>


                            <div id="sale_information_div">
                                <div class="row">
                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="customer_id">{{ __('message.customer') }} ({{__('message.customer', [], $secondary_locale)}}) </label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">

                                        <select name="customer_id" id="customer_id" class="form-control select2"
                                            data-placeholder="Select an Customer" data-tags="true" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->phone }} - {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 5px">
                                        <label for="branch_id">{{ __('message.branch') }} ({{__('message.branch', [], $secondary_locale)}}) </label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px">

                                        <select name="branch_id" id="branch_id" class="form-control select2"
                                            data-placeholder="Select an Branch" data-tags="true" data-allow-clear="true" required>
                                            <option></option>
                                            @foreach ($branches as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- due_payment --}}
                                    <div class="col-md-2" style="margin-top: 5px;" id="due_payment_label">
                                        <label for="due_payment">{{ __('message.due_payment') }} ({{__('message.due_payment', [], $secondary_locale)}}) </label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px;" id="due_payment_input_div">
                                        <input type="text" name="due_payment" id="due_payment"
                                            value="{{ old('due_payment') }}" class="form-control " readonly
                                            placeholder="{{ __('message.due_payment') }} ({{__('message.due_payment', [], $secondary_locale)}})">
                                    </div>

                                    {{-- pay_amount --}}
                                    <div class="col-md-2" style="margin-top: 5px;" id="pay_amount_label">
                                        <label for="pay_amount">{{ __('message.pay_amount') }} ({{__('message.pay_amount', [], $secondary_locale)}}) </label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px;" id="pay_amount_input_div">
                                        <input type="text" name="pay_amount" id="pay_amount"
                                            value="{{ old('pay_amount') }}" class="form-control "
                                            placeholder="{{ __('message.pay_amount') }} ({{__('message.pay_amount', [], $secondary_locale)}})">
                                    </div>

                                    <div class="col-md-2" style="margin-top: 5px;" id="received_by_label">
                                        <label for="received_by">{{ __('message.received_by') }} ({{__('message.received_by', [], $secondary_locale)}}) </label>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px;" id="received_by_input_div">
                                        <input type="text" name="received_by" id="received_by" required
                                            value="{{ old('received_by') }}" class="form-control "
                                            placeholder="{{ __('message.received_by') }} ({{__('message.received_by', [], $secondary_locale)}})">
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

                                   
                                </div>
                                <div class="col-md-12 text-center mt-2">

                                    <button type="submit" name="btn"
                                        class="btn btn-success">{{ __('message.pay') }} ({{__('message.pay', [], $secondary_locale)}})</button>
                                </div>
                            </div>
                            <div id="return_sale_information_div">
                            </div>

                        </fieldset>
                    </form>
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
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // On customer selection change
            $('#customer_id').on('change', function() {
                const customerId = $(this).val();
               

                if (customerId) {
                    $.ajax({
                        url: `/admin/customer/due-payment/${customerId}`,
                        type: 'GET',
                        success: function(response) {
                            if (response.due_payment) {
                                $('#due_payment').val(response.due_payment);
                            } else {
                                $('#due_payment').val('');
                            }
                        },
                        error: function() {
                            $('#due_payment').val('');
                            alert('Error fetching due payment. Please try again.');
                        }
                    });
                } else {
                    $('#due_payment').val('');
                }
            });
        });
    </script>
@endpush
