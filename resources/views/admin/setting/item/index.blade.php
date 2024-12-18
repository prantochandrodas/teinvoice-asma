
@extends('layouts.admin_layout.admin_layout')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.items') }} ({{__('message.items', [], $secondary_locale)}})</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
            <li class="breadcrumb-item active">{{ __('message.items') }} ({{__('message.items', [], $secondary_locale)}})</li>
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
                        <h3 class="card-title"> {{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</h3>
                        @if (auth_admin_user_permission('item.create'))
                            <a href="{{ route('admin.item.create') }}" class="btn btn-success float-right">
                                <i class="fa fa-pencil-alt"></i>  {{ __('message.add_item') }} ({{__('message.add_item', [], $secondary_locale)}})
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">  {{ __('message.serial') }} ({{__('message.serial', [], $secondary_locale)}})</th>
                                    <th width="15%" class="text-center">  {{ __('message.code') }} ({{__('message.code', [], $secondary_locale)}})</th>
                                    <th width="20%" class="text-center">  {{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}})</th>
                                    <th width="15%" class="text-center">  {{ __('message.image') }} ({{__('message.image', [], $secondary_locale)}})</th>
                                    <th width="10%" class="text-center">  {{ __('message.price') }} ({{__('message.price', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center">  {{ __('message.purchase_price') }} ({{__('message.purchase_price', [], $secondary_locale)}}) </th>
                                    <th width="10%" class="text-center">  {{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}})</th>
                                    <th width="15%" class="text-center">  {{ __('message.action') }} ({{__('message.action', [], $secondary_locale)}})</th>
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
                      <h4 class="modal-title">{{ __('message.view_item') }} ({{__('message.view_item', [], $secondary_locale)}})</h4>
                      <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="showResult">

                    </div>
                    <div class="modal-footer">
                      <button  type="button" class="btn btn-danger float-right" data-dismiss="modal">{{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})</button>
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
            ajax: '{!! route('admin.item.getItems') !!}',
            columns: [
                { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                { data: 'code', name: 'code' , class : "text-center"},
                { data: 'name', name: 'name', orderable: false , class : "text-center"},
                { data: 'image', name: 'image' , class : "text-center"},
                { data: 'price', name: 'price', class : "text-center" },
                { data: 'purchase_price', name: 'purchase_price', class : "text-center" },
                { data: 'status', name: 'status' , class : "text-center"},
                { data: 'action', name: 'action', orderable: false , class : "text-center"}
            ]
        });


        $('#yajraDatatable').on('click', '.view-modal', function(){
            var item_id     = $(this).attr('item_id');
            var url         = "{{ route('admin.item.show', ":item_id") }}";
            url = url.replace(':item_id', item_id);
            $('#showResult').html('');
            if(item_id.length != 0){
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
            var item_id  = status_object.attr('item_id');
            var status    = status_object.attr('status');
            var url       = "{{ route('admin.item.updateStatus') }}";

            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                        item_id: item_id,
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
                            status_object.html("{{ __('message.active') }}");
                            status_object.attr("status", 0);
                        }
                        else{
                            status_object.removeClass("text-success");
                            status_object.addClass("text-danger");
                            status_object.html("{{ __('message.inactive') }}");
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
            var item_id  = status_object.attr('item_id');
            var url       = "{{ route('admin.item.delete') }}";

            $.ajax({
                cache       : false,
                type        : "DELETE",
                dataType    : "JSON",
                data        : {
                    item_id: item_id,
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

