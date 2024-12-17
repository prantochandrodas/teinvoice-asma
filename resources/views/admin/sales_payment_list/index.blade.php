@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('message.sale_payment_list') }} ({{__('message.sale_payment_list', [], $secondary_locale)}})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sale Payment-List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <table id="yajraDatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center"> {{ __('message.serial') }} ({{__('message.serial', [], $secondary_locale)}}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.voucher_number') }} ({{__('message.voucher_number', [], $secondary_locale)}})</th>
                                        <th width="10%" class="text-center"> {{ __('message.bill_no') }} ({{__('message.bill_no', [], $secondary_locale)}})</th>
                                        <th width="10%" class="text-center"> {{ __('message.payment_date') }} ({{__('message.payment_date', [], $secondary_locale)}})</th>
                                        <th width="20%" class="text-center">{{ __('message.customer') }} {{ __('message.name') }} ({{__('message.customer', [], $secondary_locale)}} {{__('message.name', [], $secondary_locale)}}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.customer') }} {{ __('message.phone') }} ({{__('message.customer', [], $secondary_locale)}} {{__('message.phone', [], $secondary_locale)}}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.payment_type') }} ({{__('message.payment_type', [], $secondary_locale)}})</th>
                                        <th width="10%" class="text-center"> {{ __('message.payment_amount') }} ({{__('message.payment_amount', [], $secondary_locale)}})</th>
                                        <th width="10%" class="text-center"> {{ __('message.action') }} ({{__('message.action', [], $secondary_locale)}})</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_js')
    <script>
        $(document).ready(function() {
            $('#yajraDatatable').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                ajax: '{{ route('admin.sale-payment.getdata') }}',
                columns: [{
                        data: null, // Use null to signify that this column does not map directly to any data source
                        name: 'serial_number',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1; // Calculate the serial number
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'voucher_number',
                        name: 'voucher_number',
                        class: "text-center"
                    },
                    {
                        data: 'bill_no',
                        name: 'bill_no',
                        class: "text-center"
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date',
                        class: "text-center",
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('en-GB') :
                                ''; // Format date as d/m/y
                        }
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        class: "text-center"
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone',
                        class: "text-center"
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type',
                        class: "text-center"
                    },
                    {
                        data: 'pay_amount',
                        name: 'pay_amount',
                        class: "text-center"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    }
                ]
            });
        });
    </script>
@endpush
