
@extends('layouts.admin_layout.admin_layout')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.customer') }} ({{__('message.customer', [], $secondary_locale)}})</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
            <li class="breadcrumb-item active">{{ __('message.customer') }} ({{__('message.customer', [], $secondary_locale)}})</li>
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
                        <h3 class="card-title"> {{ __('message.customer') }} {{ __('message.list') }} ({{__('message.customer', [], $secondary_locale)}} {{__('message.list', [], $secondary_locale)}}) </h3>
                        @if (auth_admin_user_permission('customer.create'))
                            <a href="{{ route('admin.customer.create') }}" class="btn btn-success float-right">
                                <i class="fa fa-pencil-alt"></i> {{ __('message.add') }} {{ __('message.customer') }} ({{__('message.add', [], $secondary_locale)}} {{__('message.list', [], $secondary_locale)}})
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> {{ __('message.serial') }} ({{__('message.serial', [], $secondary_locale)}}) </th>
                                    <th width="20%" class="text-center"> {{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}}) </th>
                                    <th width="20%" class="text-center"> {{ __('message.image') }} ({{__('message.image', [], $secondary_locale)}}) </th>
                                    <th width="15%" class="text-center"> {{ __('message.vat_no') }} ({{__('message.vat_no', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center"> {{ __('message.phone') }} ({{__('message.phone', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center"> {{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}}) </th>
                                    <th width="20%" class="text-center"> {{ __('message.action') }} ({{__('message.action', [], $secondary_locale)}}) </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-primary">
                      <h4 class="modal-title">{{ __('message.view') }} {{ __('message.customer') }} ({{__('message.view', [], $secondary_locale)}} {{__('message.customer', [], $secondary_locale)}})</h4>
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

@push('script_js')
  <script>
    window.onload = function(){

        var table = $('#yajraDatatable').DataTable({
            language : {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.customer.getCustomers') !!}',
            columns: [
                { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                { data: 'name', name: 'name' , class : "text-center"},
                { data: 'image', name: 'image', orderable: false , class : "text-center"},
                { data: 'vat_no', name: 'vat_no' , class : "text-center"},
                { data: 'phone', name: 'phone', class : "text-center" },
                { data: 'status', name: 'status' , class : "text-center"},
                { data: 'action', name: 'action', orderable: false , class : "text-center"}
            ]
        });

        $('#yajraDatatable').on('click', '.view-modal', function(){
            var customer_id = $(this).attr('customer_id');
            var url         = "{{ route('admin.customer.show', ":customer_id") }}";
            url = url.replace(':customer_id', customer_id);
            $('#showResult').html('');
            if(customer_id.length != 0){
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

        $('#yajraDatatable').on('click', '.updateStatus', function(){
            var status_object = $(this);
            var customer_id  = status_object.attr('customer_id');
            var status    = status_object.attr('status');
            var url       = "{{ route('admin.customer.updateStatus') }}";

            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                        customer_id: customer_id,
                        status: status,
                        _token : "{{ csrf_token() }}"
                    },
                error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                url       : url,
                success   : function(response){
                    if(response.success){
                        if(response.status == 1){
                            status_object.removeClass("text-danger");
                            status_object.addClass("text-success");
                            status_object.html("Active");
                            status_object.attr("status", 0);
                        }
                        else{
                            status_object.removeClass("text-success");
                            status_object.addClass("text-danger");
                            status_object.html("Inactive");
                            status_object.attr("status", 1);
                        }
                        toastr.success(response.success,'',100000);
                    }
                    else{
                        toastr.error(response.error);
                    }
                }
            })
        });

        $('#yajraDatatable').on('click', '.delete-btn', function(){
            var status_object = $(this);
            var customer_id  = status_object.attr('customer_id');
            var url       = "{{ route('admin.customer.delete') }}";

            $.ajax({
                cache       : false,
                type        : "DELETE",
                dataType    : "JSON",
                data        : {
                    customer_id: customer_id,
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

