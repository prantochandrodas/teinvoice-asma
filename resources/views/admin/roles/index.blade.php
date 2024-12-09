@extends('layouts.admin.admin_layout')


@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-medal icon-gradient bg-tempting-azure"></i>
                </div>
                <div>View Roles
                    {{--<div class="page-title-subheading">Choose between regular React Bootstrap tables or advanced dynamic ones.</div>--}}
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.role.create') }}">
                    <button type="button" data-toggle="tooltip" title="" data-placement="bottom"
                                                                   class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-plus"></i> Add New Role
                    </button>
                </a>
                {{--<div class="d-inline-block dropdown">--}}
                    {{--<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">--}}
                                            {{--<span class="btn-icon-wrapper pr-2 opacity-7">--}}
                                                {{--<i class="fa fa-business-time fa-w-20"></i>--}}
                                            {{--</span>--}}
                        {{--Buttons--}}
                    {{--</button>--}}
                    {{--<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">--}}
                        {{--<ul class="nav flex-column">--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link">--}}
                                    {{--<i class="nav-link-icon lnr-inbox"></i>--}}
                                    {{--<span> Inbox</span>--}}
                                    {{--<div class="ml-auto badge badge-pill badge-secondary">86</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link">--}}
                                    {{--<i class="nav-link-icon lnr-book"></i>--}}
                                    {{--<span> Book</span>--}}
                                    {{--<div class="ml-auto badge badge-pill badge-danger">5</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link">--}}
                                    {{--<i class="nav-link-icon lnr-picture"></i>--}}
                                    {{--<span> Picture</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a disabled class="nav-link disabled">--}}
                                    {{--<i class="nav-link-icon lnr-file-empty"></i>--}}
                                    {{--<span> File Disabled</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <table style="width: 100%;" id="rolesTable" class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Role Type</th>
                    <th>Actions</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>

@endsection

@section('script_js')
    <script>

        (function($) {

//            alert($("#rolesTable").attr("class"));
            var table = $("#rolesTable");

            table.DataTable({
                language : {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.role.getRoles') !!}',
                columns: [
                    { data: 'DT_RowIndex', orderable: false , searchable: false, class : "text-center"},
                    { data: 'name', name: 'name', class : "text-center" },
                    { data: 'guard_name', name: 'guard_name', class : "text-center" },
                    { data: 'action', name: 'action', orderable: false , searchable: false, class : "text-center"}
                ]
            });



            table.on('click', '.delete-btn', function(){

                var status_object = $(this);
                var role_id   = status_object.attr('role_id');
                var url         = "{{ route('admin.role.delete') }}";

                var sttaus = confirm("Are you sure delete this role?");

                if(sttaus) {
                    $.ajax({
                        cache: false,
                        type: "post",
                        dataType: "JSON",
                        data: {
                            role_id: role_id,
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        error: function (xhr) {
                            alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                        },
                        url: url,
                        success: function (response) {
                            if (response.success) {
//                                alert('Yes');
                                //toastr.success(response.success);
                                $("#rolesTable").DataTable().ajax.reload();
                            }
                            else {
                                toastr.error(response.error);
                            }
                        }
                    });
                }
            });

        })(jQuery);
    </script>
@endsection