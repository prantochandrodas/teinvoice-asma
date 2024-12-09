
@extends('layouts.admin_layout.admin_layout')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.roles') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('message.role') }}</li>
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
                        <h3 class="card-title"> {{ __('message.roles_list') }}</h3>
                        @if (auth_admin_user_permission('role.create'))
                            <a href="{{ route('admin.role.create') }}" class="btn btn-success float-right">
                                <i class="fa fa-pencil-alt"></i> {{ __('message.add_role') }}
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> {{ __('message.serial') }} </th>
                                    <th width="20%" class="text-center"> {{ __('message.name') }} </th>
                                    <th width="55%" class="text-center"> {{ __('message.permission') }} </th>
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
                      <h4 class="modal-title">{{ __('message.view_role') }} </h4>
                      <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="showResult">

                    </div>
                    <div class="modal-footer">
                      <button  type="button" class="btn btn-danger float-right" data-dismiss="modal">{{ __('message.close') }}</button>
                      {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
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
            ajax: '{!! route('admin.role.getRoles') !!}',
            columns: [
                { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                { data: 'name', name: 'name' , class : "text-center"},
                { data: 'permission', name: 'permission', orderable: false , class : "text-center"},
                { data: 'action', name: 'action', orderable: false , class : "text-center"}
            ]
        });

        $('#yajraDatatable').on('click', '.view-modal', function(){
            var role_id = $(this).attr('role_id');
            var url = "{{ route('admin.role.show', ":role_id") }}";
            url = url.replace(':role_id', role_id);
            $('#showResult').html('');
            if(role_id.length != 0){
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
            var role_id  = status_object.attr('role_id');
            var status    = status_object.attr('status');
            var url       = "{{ route('admin.role.updateStatus') }}";

            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                        role_id: role_id,
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
            var role_id  = status_object.attr('role_id');
            var url       = "{{ route('admin.role.delete') }}";

            $.ajax({
                cache       : false,
                type        : "DELETE",
                dataType    : "JSON",
                headers     : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data        : {
                    role_id: role_id,
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

