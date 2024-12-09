
@extends('layouts.admin_layout.admin_layout')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Supplier Opening List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Supplier Opening List</li>
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
                        <h3 class="card-title">Supplier Opening List </h3>
                        <a href="{{  route('admin.supplierOpening.index')  }}" class="btn btn-success float-right">
                            <i class="fa fa-pencil-alt"></i> Supplier Opening Form
                        </a>

                        <div class="row input-daterange" style="margin-top: 40px">
                            <div class="col-md-4">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control select2" style="width: 100%" >
                                    <option value="0" >All Supplier </option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" > {{ $supplier->name }} - {{ $supplier->contact_number }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control"  value="{{ date('Y-m-d') }}"/>
                            </div>
                            <div class="col-md-3">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}"/>
                            </div>
                            <div class="col-md-2" style="margin-top: 20px">
                                <button type="button" name="filter" id="filter" class="btn btn-success">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button type="button" name="refresh" id="refresh" class="btn btn-info">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> SL </th>
                                    <th width="20%" class="text-center"> Date </th>
                                    <th width="30%" class="text-center"> Supplier </th>
                                    <th width="30%" class="text-center"> Amount </th>
                                    <th width="15%" class="text-center"> Action </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="3"> Total </th>
                                    <th class="text-center">
                                        <span id="page_total_amount"></span> <br>
                                        (<span id="total_amount"></span> Total)
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-primary">
                      <h4 class="modal-title">View Supplier Opening </h4>
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

        function load_data(supplier_id = '',  from_date = '', to_date = ''){

            var table = $('#yajraDatatable').DataTable({
                language : {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{!! route('admin.supplierOpening.getSupplierOpeningList') !!}',
                    data:{
                        supplier_id     : supplier_id,
                        from_date    : from_date,
                        to_date      : to_date,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                    { data: 'date', name: 'date' , class : "text-center"},
                    { data: 'supplier.name', name: 'supplier.name' ,  render: function(data, type, row) { return (data) ? data : 'N/A'; },  class : "text-center"},
                    { data: 'amount', name: 'amount', class : "text-center" },
                    { data: 'action', name: 'action', orderable: false , searchable: false , class : "text-center"}
                ],
                'drawCallback' : function(row, data, start, end, display){
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 :  typeof i === 'number' ? i : 0;
                    };

                    // Total over this page
                    pageTotal = api .column( 3, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                    // Update footer
                    $("#page_total_amount").html( returnNumberFormat(pageTotal));

                }
            }).on( 'xhr', function ( e, settings, json ) {
                $('#total_amount').html(json.total_amount );
            });

        }

        $('#filter').click(function(){
            var supplier_id = $('#supplier_id option:selected').val();
            var from_date   = $('#from_date').val();
            var to_date     = $('#to_date').val();

            $('#yajraDatatable').DataTable().destroy();
            load_data(supplier_id, from_date, to_date);
        });

        $(document).on('click', '#refresh', function(){
            $('#yajraDatatable').DataTable().destroy();
            load_data();
        });


        $('#yajraDatatable').on('click', '.view-modal', function(){
            var supplier_opening_id = $(this).attr('supplier_opening_id');
            var url = "{{ route('admin.supplierOpening.show', ":supplier_opening_id") }}";
            url = url.replace(':supplier_opening_id', supplier_opening_id);
            $('#showResult').html('');
            if(supplier_opening_id.length != 0){
                $.ajax({
                    cache   : false,
                    type    : "GET",
                    error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                    url : url,
                    success : function(response){
                        $('#showResult').html(response);
                    },
                })
            }
        });
    }


  </script>
@endpush

