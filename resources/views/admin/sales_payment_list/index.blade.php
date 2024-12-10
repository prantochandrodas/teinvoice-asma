@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Sale Payment-List</h1>
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
                                        <th width="5%" class="text-center"> SL </th>
                                        <th width="20%" class="text-center">Customer Name </th>
                                        <th width="10%" class="text-center"> Customer Phone </th>
                                        <th width="10%" class="text-center"> Payment Type </th>
                                        <th width="10%" class="text-center"> Voucher Number</th>
                                        <th width="10%" class="text-center"> Payment Date</th>
                                        <th width="10%" class="text-center"> Payment Amount</th>

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
                        data: 'voucher_number',
                        name: 'voucher_number',
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
                        data: 'pay_amount',
                        name: 'pay_amount',
                        class: "text-center"
                    }
                ]
            });
        });
    </script>
@endpush
