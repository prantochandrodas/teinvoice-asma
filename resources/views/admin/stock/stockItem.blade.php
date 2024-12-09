@extends('layouts.admin_layout.admin_layout')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Stock Item List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Stock Item List</li>
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
                        <h3 class="card-title">Stock Item List </h3>

                        <div class="row input-daterange" style="margin-top: 40px">
                            <div class="col-md-10">
                                <label for="item_id">Item </label>
                                <select name="item_id" id="item_id" class="form-control select2" style="width: 100%" >
                                    <option value="0" >All Item  </option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}" > {{ $item->code }}  - {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2" style="margin-top: 20px">
                                <button type="button" name="filter" id="filter" class="btn btn-success">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button type="button" name="refresh" id="refresh" class="btn btn-info">
                                    <i class="fas fa-sync-alt"></i>
                                </button>

                                <form action="{{ route('admin.stockItem.printAll') }}" method="post" target="_blank" class="float-right">
                                    @csrf
                                    <input type="hidden" name="item_id" id="print_item_id" >
                                    <button type="submit" class="btn btn-info"  title="Print Sales List">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> SL </th>
                                    <th width="15%" class="text-center"> Item Code </th>
                                    <th width="20%" class="text-center"> Item Name </th>
                                    <th width="20%" class="text-center"> Quantity </th>
                                    <th width="20%" class="text-center"> Price </th>
                                    <th width="20%" class="text-center"> Stock Amount </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="3"> Total </th>
                                    <th class="text-center">
                                        <span id="page_total_quantity"></span> <br>
                                        (<span id="total_quantity"></span> Total) </th>
                                    </th>
                                    <th class="text-center" >  </th>
                                    <th class="text-center">
                                        <span id="page_total_amount"></span> <br>
                                        (<span id="total_amount"></span> Total) </th>
                                </tr>
                            </tfoot>
                        </table>
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
@endsection

@push('style_css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    window.onload = function(){
        load_data();

        function load_data(item_id = ''){

            var table = $('#yajraDatatable').DataTable({
                language : {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                processing: true,
                serverSide: true,
                // lengthMenu : [[2,4,8,12,-1],[2,4,8,12,'All']],
                ajax: {
                    url:'{!! route('admin.stockItem.getStockItem') !!}',
                    data:{
                        item_id      : item_id,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                    { data: "item.code",
                        render: function(data, type, row) {
                            return (data) ? data : 'N/A';
                        },
                        name: 'item.code' , class : "text-center"
                    },
                    { data: "item.name",
                        render: function(data, type, row) {
                            return (data) ? data : 'N/A';
                        },
                        name: 'item.name' , class : "text-center"
                    },
                    { data: 'quantity', name: 'quantity' , class : "text-center"},
                    { data: 'unit_cost', name: 'unit_cost', class : "text-center" },
                    { data: 'amount', name: 'amount', class : "text-center" },
                ],

                'drawCallback' : function(row, data, start, end, display){
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 :  typeof i === 'number' ? i : 0;
                    };

                    // Total over this page
                    pageTotal = api .column( 5, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );

                    // Update footer
                    $("#page_total_amount").html( returnNumberFormat(pageTotal));


                    // Total over this page
                    pageTotal = api .column( 3, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );

                    // Update footer
                    $("#page_total_quantity").html(pageTotal);
                }
            }) .on( 'xhr', function ( e, settings, json ) {
                $('#total_amount').html(json.total_stock_amount );
                $('#total_quantity').html(json.total_quantity );
            });
        }


        $('#filter').click(function(){
            var item_id        = $('#item_id option:selected').val();

            $('#print_item_id').val(item_id);

            $('#yajraDatatable').DataTable().destroy();
            load_data(item_id);
        });

        $(document).on('click', '#refresh', function(){
            $('#yajraDatatable').DataTable().destroy();
            $('#print_item_id').val();
            load_data();
        });

    }

  </script>
@endpush

