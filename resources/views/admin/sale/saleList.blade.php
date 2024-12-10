@extends('layouts.admin_layout.admin_layout')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Sale List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Sales List</li>
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
                        <div class="card-header">
                            <h3 class="card-title"> Sale List </h3>
                            <div class="row input-daterange" style="margin-top: 40px">
                                <div class="col-md-3">
                                    <label for="payment">{{ __('Payment Type') }} </label>
                                    <select  id="payment" class="form-control select2"
                                        data-placeholder="Select a Branch"
                                        data-tags="true"
                                        data-allow-clear="true">
                                        <option></option>
                                        <option value="Cash">Cash</option>
                                        <option value="Mada">Mada</option>
                                        <option value="credit card"> Credit Card</option>
                                        <option value="credit">credit</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="branch_name">{{ __('Branch Name') }} </label>
                                    <select  id="branch_name" class="form-control select2"
                                        data-placeholder="Select a Branch"
                                        data-tags="true"
                                        data-allow-clear="true">
                                        <option></option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">
                                             {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="customer_id">{{ __('message.customer') }} </label>
                                    <select  id="customer_id" class="form-control select2"
                                        data-placeholder="Select a Customer"
                                        data-tags="true"
                                        data-allow-clear="true">
                                        <option></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->phone }} - {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="to_date">Date</label>
                                    <div class="input-group">
                                        <input type="date" id="from_date" class="form-control" value=""/>
                                        <input type="date" id="to_date" class="form-control" value=""/>
                                    </div>
                                </div>

                                <div class="col-md-2" style="margin-top: 20px">
                                    <button type="button" name="filter" id="filter" class="btn btn-success">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-info">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <form action="{{ route('admin.sale.printAll') }}" method="post" target="_blank" class="float-right">
                                        @csrf
                                        <input type="hidden" name="customer_id" id="print_customer_id" >
                                        <input type="hidden" name="from_date" id="print_from_date" >
                                        <input type="hidden" name="to_date" id="print_to_date" >
                                        <button type="submit" class="btn btn-info"  title="Print Sales List">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 text-left text-bold" style="font-size: 20px;">SHOP NAME : {{ $application->name }} </div>
                                <div class="col-sm-6 text-right text-bold" style="font-size: 20px;">VAT NUMBER: {{ $application->vat_number }} </div>
                                <div class="col-sm-6 text-left text-bold" style="font-size: 20px;">DATE: <span>{{ date('d-F-Y ') }} to {{ date('d-F-Y') }} </span></div>
                            </div>
                            <div class="table-responsive">
                                <table id="yajraDatatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th  class="text-center"> SL </th>
                                            <th  class="text-center"> Date</th>
                                            <th  class="text-center"> Bill No </th>
                                            <th  class="text-center"> Bill Type</th>
                                            <th  class="text-center"> Quantity </th>
                                            <th  class="text-center"> Grand Amount </th>
                                            <th  class="text-center"> Discount Amount </th>
                                            <th  class="text-center"> Tax Amount </th>
                                            <th  class="text-center"> Final Amount  </th>
                                            <th  class="text-center"> Purchase  Amount  </th>
                                            <th  class="text-center"> Purchase  TAX Amount  </th>
                                            <th  class="text-center"> Purchase Final Amount  </th>
                                            <th  class="text-center"> Action </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center" colspan="4"> Total </th>
                                            <th class="text-center">
                                                <span id="page_total_quantity"></span> <br>
                                                (<span id="total_quantity"></span> Total)
                                            </th>
                                            <th class="text-center">
                                                <span id="page_total_grand_amount"></span> <br>
                                                (<span id="total_grand_amount"></span> Total)
                                            </th>
                                            <th class="text-center">
                                                <span id="page_total_discount_amount"></span> <br>
                                                (<span id="total_discount_amount"></span> Total)
                                            </th>
                                            <th class="text-center">
                                                <span id="page_total_tax_amount"></span> <br>
                                                (<span id="total_tax_amount"></span> Total)
                                            </th>
                                            <th class="text-center">
                                                <span id="page_total_final_amount"></span> <br>
                                                (<span id="total_final_amount"></span> Total)
                                            </th>
                                            <th class="text-center">
                                                <span id="page_total_unit_cost"></span> <br>
                                                (<span id="total_unit_cost"></span> Total)
                                            </th>
                                            <th class="text-center" colspan="3">

                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="viewModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content" id="showResult">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="printBarcode">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="showBookingItem">

            </div>
        </div>
    </div>

    <div class="modal fade" id="printViewList">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="showBookingParcelList">

            </div>
        </div>
    </div>
@endsection

@push('style_css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        window.onload = function() {
            load_data();

            function load_data(payment='', branch_name='',customer_id='', from_date = '', to_date = ''){

                var table = $('#yajraDatatable').DataTable({
                    language : {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    "bInfo": false,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:'{!!  route('admin.sale.getList') !!}',
                        data:{
                            payment   : payment,
                            branch_name   : branch_name,
                            customer_id   : customer_id,
                            from_date   : from_date,
                            to_date     : to_date,
                        }
                    },
                    order: [ [1, 'desc'] ],
                    columns: [
                        { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                        { data: 'date', name: 'date' , class : "text-center"},
                        { data: 'bill_no', name: 'bill_no', class : "text-center", searchable: false},
                        { data: 'bill_type', name: 'bill_type' , class : "text-center"},
                        { data: "total_quantity",
                            render: function(data, type, row) {
                                return (data) ? parseFloat(data) : 'N/A';
                            },
                            name: 'total_quantity' , class : "text-center"
                        },
                        { data: 'grand_amount', name: 'grand_amount' , class : "text-center"},
                        { data: 'discount_amount', name: 'discount_amount' , class : "text-center"},
                        { data: 'tax_amount', name: 'tax_amount' , class : "text-center"},
                        { data: 'final_amount', name: 'final_amount' , class : "text-center"},
                        { data: 'total_unit_cost', name: 'total_unit_cost' , class : "text-center"},
                        { data: 'total_purchase_tax', name: 'total_purchase_tax' , class : "text-center"},
                        { data: 'total_purchase_final_amount', name: 'total_purchase_final_amount' , class : "text-center"},
                        { data: 'action', name: 'action', orderable: false , searchable: false , class : "text-center"}
                    ],
                    'drawCallback' : function(row, data, start, end, display){
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 :  typeof i === 'number' ? i : 0;
                        };

                        // Total over this page
                        pageTotal = api .column( 4, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
                        $("#page_total_quantity").html(pageTotal);

                        // Total over this page
                        pageTotal = api .column( 5, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                        $("#page_total_grand_amount").html(returnNumberFormat(pageTotal));

                        // Total over this page
                        pageTotal = api .column( 6, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                        $("#page_total_discount_amount").html(returnNumberFormat(pageTotal));

                        // Total over this page
                        pageTotal = api .column( 7, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                        $("#page_total_tax_amount").html(returnNumberFormat(pageTotal));

                        // Total over this page
                        pageTotal = api .column( 8, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                        $("#page_total_final_amount").html(returnNumberFormat(pageTotal));
                        // Total over this page
                        pageTotal = api .column( 9, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                        $("#page_total_unit_cost").html(returnNumberFormat(pageTotal));
                    }
                })
                .on( 'xhr', function ( e, settings, json ) {
                    $('#total_quantity').html(json.total_quantity );
                    $('#total_grand_amount').html(returnNumberFormat(json.total_grand_amount));
                    $('#total_discount_amount').html(returnNumberFormat(json.total_discount_amount));
                    $('#total_tax_amount').html(returnNumberFormat(json.total_tax_amount));
                    $('#total_final_amount').html(returnNumberFormat(json.total_final_amount));
                    $('#total_unit_cost').html(returnNumberFormat(json.total_unit_cost));
                });
            }

            $('#filter').click(function(){
                var payment = $('#payment').val();
                var branch_name = $('#branch_name option:selected').val();
                var customer_id = $('#customer_id option:selected').val();
                var from_date   = $('#from_date').val();
                var to_date     = $('#to_date').val();

                $('#payment').val(payment);
                $('#branch_name').val(branch_name);
                $('#print_customer_id').val(customer_id);
                $('#print_from_date').val(from_date);
                $('#print_to_date').val(to_date);

                $('#yajraDatatable').DataTable().destroy();
                load_data(payment,branch_name,customer_id, from_date, to_date);
            });

            $(document).on('click', '#refresh', function(){
                $('#print_customer_id').val('');
                $('#print_from_date').val('');
                $('#print_to_date').val('');

                $('#yajraDatatable').DataTable().destroy();
                load_data();
            });




            $('#yajraDatatable').on('click', '.view-modal', function() {
                var sale_id = $(this).attr('sale_id');
                var url = "{{ route('admin.sale.view', ":sale_id") }}";
                url = url.replace(':sale_id', sale_id);
                // console.log(url);
                return false;

                $('#showResult').html('');
                if (sale_id.length != 0) {
                    $.ajax({
                        cache: false,
                        type: "GET",
                        error: function(xhr) {
                            alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                        },
                        url: url,
                        success: function(response) {
                            $('#showResult').html(response);
                        },

                    })
                }
            });




        }

    </script>
@endpush
