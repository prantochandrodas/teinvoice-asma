
@extends('layouts.admin_layout.admin_layout')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Product Category</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Product Category</li>
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
                        <h3 class="card-title"> Category List </h3>
                        @if (auth_admin_user_permission('service.create'))
                            <a href="{{ route('admin.product-category.create') }}" class="btn btn-success float-right">
                                <i class="fa fa-pencil-alt"></i> Add New Category
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> SL </th>
                                    <th width="20%" class="text-center"> name </th>
                                    <th width="10%" class="text-center"> Status </th>
                                    <th width="15%" class="text-center"> Action </th>
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
    window.onload = function(){

        var table = $('#yajraDatatable').DataTable({
            language : {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.product-category.getCategories') !!}',
            columns: [
                { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                { data: 'name', name: 'name', class : "text-center" },
                { data: 'status', name: 'status' , searchable: false, class : "text-center"},
                { data: 'action', name: 'action', orderable: false , searchable: false, class : "text-center"}
            ]
        });

        $('#yajraDatatable').on('click', '.updateStatus', function(){
            var status_object   = $(this);
            var service_id      = status_object.attr('service_id');
            var status          = status_object.attr('status');
            var url             = "{{ route('admin.product-category.updateStatus') }}";

            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                        service_id: service_id,
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
                        toastr.success(response.success);
                    }
                    else{
                        toastr.error(response.error);
                    }
                }
            })
        });

        $('#yajraDatatable').on('click', '.delete-btn', function(){
            var status_object = $(this);
            var category_id   = status_object.attr('category_id');
            var url         = "{{ route('admin.product-category.delete') }}";

            $.ajax({
                cache       : false,
                type        : "DELETE",
                dataType    : "JSON",
                data        : {
                    category_id: category_id,
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

