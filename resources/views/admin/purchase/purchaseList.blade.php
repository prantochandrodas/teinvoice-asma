
@extends('layouts.admin_layout.admin_layout')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> {{ __('message.purchase') }} {{ __('message.list') }} ({{__('message.purchase', [], $secondary_locale)}} {{__('message.list', [], $secondary_locale)}})</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
            <li class="breadcrumb-item active"> {{ __('message.purchase') }} {{ __('message.list') }} ({{__('message.purchase', [], $secondary_locale)}} {{__('message.list', [], $secondary_locale)}})</li>
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
                        <h3 class="card-title">{{ __('message.purchase') }} {{ __('message.list') }} ({{__('message.purchase', [], $secondary_locale)}} {{__('message.list', [], $secondary_locale)}}) </h3>
                        @if (auth_admin_user_permission('purchase.create'))
                            <a href="{{  route('admin.purchase.index')  }}" class="btn btn-success float-right">
                                <i class="fa fa-pencil-alt"></i> Purchase Form
                            </a>
                        @endif

                        <div class="row input-daterange" style="margin-top: 40px">
                            <div class="col-md-3">
                                <label for="supplier_id">{{ __('message.supplier') }} ({{__('message.supplier', [], $secondary_locale)}})</label>
                                <select name="supplier_id" id="supplier_id" class="form-control select2" style="width: 100%" >
                                    <option value="0" >Select Supplier </option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" > {{ $supplier->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="invoice_no">{{ __('message.invoice_no') }} ({{__('message.invoice_no', [], $secondary_locale)}})</label>
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control"  placeholder="Invoice No"/>
                            </div>
                            <div class="col-md-2">
                                <label for="from_date">{{ __('message.from_date') }} ({{__('message.from_date', [], $secondary_locale)}})</label>
                                <input type="date" name="from_date" id="from_date" class="form-control"  value="{{ date('Y-m-d') }}"/>
                            </div>
                            <div class="col-md-2">
                                <label for="to_date">{{ __('message.to_date') }} ({{__('message.to_date', [], $secondary_locale)}})</label>
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
                                    <th width="5%" class="text-center"> {{ __('message.serial') }} ({{__('message.serial', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center">{{ __('message.invoice_no') }} ({{__('message.invoice_no', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center"> {{ __('message.date') }} ({{__('message.date', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center"> {{ __('message.supplier') }} ({{__('message.supplier', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center"> {{ __('message.quantity') }} ({{__('message.quantity', [], $secondary_locale)}})</th>
                                    <th width="10%" class="text-center"> {{ __('message.grand_amount') }} ({{__('message.grand_amount', [], $secondary_locale)}})</th>
                                    <th width="15%" class="text-center"> {{ __('message.discount_amount') }} ({{__('message.discount_amount', [], $secondary_locale)}})</th>
                                    <th width="15%" class="text-center"> {{ __('message.final_amount') }} ({{__('message.final_amount', [], $secondary_locale)}}) </th>
                                    <th width="15%" class="text-center"> {{ __('message.action') }} ({{__('message.action', [], $secondary_locale)}})</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="5"> {{ __('message.total') }} ({{__('message.total', [], $secondary_locale)}})</th>
                                    <th class="text-center">
                                        <span id="page_total_grand_amount"></span> <br>
                                        (<span id="total_grand_amount"></span> {{ __('message.total') }} ({{__('message.total', [], $secondary_locale)}})) </th>
                                    </th>
                                    <th class="text-center">
                                        <span id="page_total_discount_amount"></span> <br>
                                        (<span id="total_discount_amount"></span> {{ __('message.total') }} ({{__('message.total', [], $secondary_locale)}}))
                                    </th>
                                    <th class="text-center">
                                        <span id="page_total_final_amount"></span> <br>
                                        (<span id="total_final_amount"></span> {{ __('message.total') }} ({{__('message.total', [], $secondary_locale)}}))
                                    </th>
                                    <th></th>
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

        function load_data(supplier_id = '', invoice_no = '', from_date = '', to_date = ''){

            var table = $('#yajraDatatable').DataTable({
                language : {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{!! route('admin.purchase.getPurchaseList') !!}',
                    data:{
                        supplier_id     : supplier_id,
                        invoice_no      : invoice_no,
                        from_date       : from_date,
                        to_date         : to_date,
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                    { data: 'invoice_no', name: 'run_invoice' , class : "text-center"},
                    { data: 'date', name: 'date' , class : "text-center"},
                    { data: 'supplier.name', name: 'supplier.name' , render: function(data, type, row) { return (data) ? data : 'N/A'; },   class : "text-center"},
                    { data: 'total_quantity', name: 'total_quantity' , class : "text-center"},
                    { data: 'grand_amount', name: 'grand_amount' , class : "text-center"},
                    { data: 'discount_amount', name: 'discount_amount', class : "text-center" },
                    { data: 'final_amount', name: 'final_amount', class : "text-center" },
                    { data: 'action', name: 'action', orderable: false , searchable: false , class : "text-center"}
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
                    $("#page_total_grand_amount").html( returnNumberFormat(pageTotal));

                    // Total over this page
                    pageTotal = api .column( 6, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                    // Update footer
                    $("#page_total_discount_amount").html( returnNumberFormat(pageTotal));

                    // Total over this page
                    pageTotal = api .column( 7, { page: 'current'} ) .data() .reduce( function (a, b) { return intVal(a) + intVal(b);  }, 0 );
                    // Update footer
                    $("#page_total_final_amount").html( returnNumberFormat(pageTotal));

                }
            }).on( 'xhr', function ( e, settings, json ) {
                $('#total_grand_amount').html(json.total_grand_amount );
                $('#total_discount_amount').html(json.total_discount_amount );
                $('#total_final_amount').html(json.total_final_amount );
            });

        }

        $('#filter').click(function(){
            var supplier_id = $('#supplier_id option:selected').val();
            var invoice_no  = $('#invoice_no').val();
            var from_date   = $('#from_date').val();
            var to_date     = $('#to_date').val();

            $('#yajraDatatable').DataTable().destroy();
            load_data(supplier_id, invoice_no, from_date, to_date);
        });

        $(document).on('click', '#refresh', function(){
            $('#yajraDatatable').DataTable().destroy();
            load_data();
        });


        $('#yajraDatatable').on('click', '.view-modal', function(){
            var purchase_id = $(this).attr('purchase_id');
            var url = "{{ route('admin.purchase.show', ":purchase_id") }}";
            url = url.replace(':purchase_id', purchase_id);
            $('#showResult').html('');
            if(purchase_id.length != 0){
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

        $('#yajraDatatable').on('click', '.delete-btn', function(){
            var status_object = $(this);
            var purchase_id   = status_object.attr('purchase_id');
            var url         = "{{ route('admin.purchase.delete') }}";

            $.ajax({
                cache       : false,
                type        : "DELETE",
                dataType    : "JSON",
                headers     : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data        : {
                    purchase_id: purchase_id,
                    _token : "{{ csrf_token() }}"
                },
                error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                url       : url,
                success   : function(response){
                    if(response.success){
                        toastr.success(response.success);
                        $('#yajraDatatable').DataTable().ajax.reload();
                    }
                    else{
                        toastr.error(response.error);
                    }
                }
            })
        });
    }

  </script>
@endpush

