
@extends('layouts.admin_layout.admin_layout')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
              {{ __('message.admins') }}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{ __('message.home') }} </a></li>
            <li class="breadcrumb-item active"> {{ __('message.admin') }} </li>
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
                        <h3 class="card-title"> {{ __('message.admins_list') }} </h3>
                        @if (auth_admin_user_permission('admin.create'))
                            <a href="{{ route('admin.admin.create') }}" class="btn btn-success float-right">
                                <i class="fa fa-pencil-alt"></i> {{ __('message.add_admin') }}
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> {{ __('message.serial') }} </th>
                                    <th width="20%" class="text-center"> {{ __('message.name') }}  </th>
                                    <th width="20%" class="text-center"> {{ __('message.image') }}  </th>
                                    <th width="15%" class="text-center"> {{ __('message.email') }}  </th>
                                    <th width="10%" class="text-center"> {{ __('message.role') }}  </th>
                                    <th width="10%" class="text-center"> {{ __('message.status') }} </th>
                                    <th width="20%" class="text-center"> {{ __('message.action') }} </th>
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
                        <h4 class="modal-title">
                            {{ __('message.view_admin') }}
                        </h4>
                      <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="showResult">

                    </div>
                    <div class="modal-footer">
                        <button  type="button" class="btn btn-danger float-right" data-dismiss="modal">
                            {{ __('message.close') }}
                        </button>
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
            ajax: '{!! route('admin.admin.getAdmins') !!}',
            columns: [
                { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                { data: 'full_name', name: 'full_name' , class : "text-center"},
                { data: 'image', name: 'image', orderable: false , class : "text-center"},
                { data: 'email', name: 'email' , class : "text-center"},
                { data: 'role', name: 'role', class : "text-center" },
                { data: 'status', name: 'status' , class : "text-center"},
                { data: 'action', name: 'action', orderable: false , class : "text-center"}
            ]
        });

        $('#yajraDatatable').on('click', '.view-modal', function(){
            var admin_id = $(this).attr('admin_id');
            var url         = "{{ route('admin.admin.show', ":admin_id") }}";
            url = url.replace(':admin_id', admin_id);
            $('#showResult').html('');
            if(admin_id.length != 0){
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
            var admin_id  = status_object.attr('admin_id');
            var status    = status_object.attr('status');
            var url       = "{{ route('admin.admin.updateStatus') }}";

            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                        admin_id: admin_id,
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
            var admin_id  = status_object.attr('admin_id');
            var url       = "{{ route('admin.admin.delete') }}";

            $.ajax({
                cache       : false,
                type        : "DELETE",
                dataType    : "JSON",
                data        : {
                    admin_id: admin_id,
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

