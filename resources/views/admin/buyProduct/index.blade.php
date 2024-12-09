@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Buy Product List (شراء قائمة المنتجات)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Buy Product List (شراء قائمة المنتجات)</li>
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
                            <h3 class="card-title"> Buy Product List (شراء قائمة المنتجات) </h3>
                            @if (auth_admin_user_permission('supplier.create'))
                                <a href="{{ route('admin.buy-product-entry.create') }}" class="btn btn-success float-right">
                                    <i class="fa fa-pencil-alt"></i> Buy Product Create (شراء منتج إنشاء)
                                </a>
                            @endif
                            <div class="col-sm-5" style="display: flex;margin-left:400px">

                                <div class="input-group" style="gap:5px">
                                    <input type="date" id="from_date" class="form-control " value="" />
                                    <input type="date" id="to_date" class="form-control" value="" />
                                </div>
                                <div style="display: flex;gap:2px" class="ml-2">
                                    <button type="button" name="filter" id="filter" class="btn btn-success">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-info">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button title="Print Invoice" class="btn mr-2 btn-success" id="printButton">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="yajraDatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%" class="text-center"> SL </th>
                                        <th width="10%" class="text-center"> Date</th>
                                        <th>Purchase No (رقم الشراء)</th>
                                        <th>Supplier Name (اسم المورد)</th>
                                        <th>Item Code (رمز العنصر)</th>
                                        <th>Item Name (رمز العنصر)</th>
                                        <th>Item Buy Bill(فاتورة شراء السلعة)</th>
                                        <th>Item Total Cost(التكلفة الإجمالية للعنصر)</th>
                                        <th>Action(فعل)</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="6">Total</th>
                                        <th class="text-center">
                                            <span id="page_total_item_buy_bill"></span>  <br>
                                            (<span id="total_item_buy_bill"></span> Grand Total)
                                        </th>
                                        <th class="text-center">
                                            <span id="page_total_cost"></span>  <br>
                                            (<span id="total_cost"></span> Grand Total)
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Buy Product Details </h4>
              <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="showResult">

            </div>
            <div class="modal-footer">
              <button  type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
@endsection

@push('script_js')
    <script>
        window.onload = function() {
            load_data();

            function load_data(from_date = '', to_date = '') {
                var table = $('#yajraDatatable').DataTable({
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{!! route('admin.buy-product.getList') !!}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            class: "text-center"
                        },

                        {
                            data: 'date',
                            name: 'date',
                            orderable: false,
                            class: "text-center"
                        },
                        {
                            data: 'purchase_no',
                            name: 'purchase_no',
                            class: "text-center"
                        },
                        {
                            data: 'supplier_name',
                            name: 'supplier_name',
                            class: "text-center"
                        },
                        {
                            data: 'item_code',
                            name: 'item_code',
                            class: "text-center"
                        },
                        {
                            data: 'item_name',
                            name: 'item_name',
                            class: "text-center"
                        },
                        {
                            data: 'item_buy_bill',
                            name: 'item_buy_bill',
                            class: "text-center"
                        },{
                            data: 'total_cost',
                            name: 'total_cost',
                            class: "text-center"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            class: "text-center"
                        }
                    ],
                    drawCallback: function (settings) {
                        // Calculate page totals
                        var api = this.api();
                        var pageTotalItemBuyBill = api
                            .column(6, { page: 'current' })
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        var pageTotalCost = api
                            .column(7, { page: 'current' })
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // Update footer for page totals
                        $('#page_total_item_buy_bill').html(returnNumberFormat(pageTotalItemBuyBill));
                        $('#page_total_cost').html(returnNumberFormat(pageTotalCost));
            }
                });
                table.on('xhr', function (e, settings, json) {
                    $('#total_item_buy_bill').html(returnNumberFormat(json.total_item_buy_bill));
                    $('#total_cost').html(returnNumberFormat(json.total_cost));
                });
            }
            $('#filter').click(function() {

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date && to_date) {
                    $('#yajraDatatable').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Please Give From Date And To Date Data!');
                }


            });

            $('#yajraDatatable').on('click', '.view-modal', function() {
                var buy_id = $(this).attr('buy_id');
                var url = "{{ route('admin.buy-product-entry.show', ':buy_id') }}";
                url = url.replace(':buy_id', buy_id);
                $('#showResult').html('');
                if (buy_id.length != 0) {
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

            $('#yajraDatatable').on('click', '.delete-btn', function() {
                var status_object = $(this);
                var buyProductId = status_object.attr('supplier_id');
                var url = "{{ route('admin.buy-product-entry.destroy', ':buy_product_entry') }}".replace(':buy_product_entry', buyProductId);

                $.ajax({
                    cache: false,
                    type: "DELETE",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    error: function(xhr) {
                        alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                    },
                    url: url,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.success);
                            $('#yajraDatatable').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.error);
                        }
                    }
                });
            });
            $(document).ready(function() {
                $('#printButton').on('click', function() {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var url = "{{ route('admin.buy-product.print') }}";
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status,
                            from_date: from_date,
                            to_date: to_date
                        },
                        success: function(response) {
                            if (response.html) {
                                // Create a hidden iframe or div to hold the print content
                                var printWindow = window.open("", "_blank");
                                printWindow.document.write(response.html);
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                                printWindow.close();
                            } else {
                                alert('No data found for the given date range.');
                            }

                        },
                        error: function(xhr) {
                            alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                        }
                    });

                })
            })
        }
    </script>
@endpush
