@extends('layouts.admin.admin_layout')


@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="lnr-picture text-danger"></i>
                </div>
                <div>Create Role
                    {{--<div class="page-title-subheading">Inline validation is very easy to implement using the Architect Framework.</div>--}}
                </div>
            </div>

            {{--<div class="page-title-actions">--}}
                {{--<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" data-original-title="Example Tooltip">--}}
                    {{--<i class="fa fa-star"></i>--}}
                {{--</button>--}}
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
                                {{--<a disabled="" class="nav-link disabled">--}}
                                    {{--<i class="nav-link-icon lnr-file-empty"></i>--}}
                                    {{--<span> File Disabled</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>    --}}
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Add New Role</h5>
            <form id="signupForm" class="col-md-10 mx-auto" method="post" action="{{ route('admin.role.store') }}" novalidate="novalidate" onsubmit="return confirmSubmit()">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <div>
                        <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-z]+" placeholder="Role Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="guard_name">Role Type</label>
                    <div>
                        <select id="guard_name" name="guard_name" class="form-control" data-placeholder="Select Role Type">
                            <option value="0">Select Role Type</option>
                            <?php
                                if(count($guards) > 0) {
                                    foreach($guards as $k=>$v) {
                                        $selected = ('admin' == $v) ? 'selected' : '';
                                        echo '<option value="'.$v.'" '.$selected.'>'.ucfirst($v).'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="permissions">Permission</label>
                    <div style="border: 1px solid #ccc; border-radius: 4px; min-height: 80px; padding: 10px">
                        <div style="text-align: right; border-bottom: 1px solid #CDCDCD; margin-bottom: 10px;">
                            <input type="checkbox" value="1" id="checkAll"> Select All
                        </div>
                        <div id="permission_data" class="position-relative form-check form-check-inline">
                            @php $i = 0; @endphp
                            @foreach($permissions as $permission)
                                @php $i++; @endphp
                                {{--<label for="permission_{{ $i }}"><input type="checkbox" name="permisions[]" id="permission_{{ $i }}"> {{ $permission->name }}</label>--}}
                                <label class="form-check-label">
                                    <input type="checkbox" name="permissions[]" class="form-check-input permission_item" value="{{ $permission->id }}"> <b>{{ $permission->name }}</b>
                                </label>&nbsp;
                            @endforeach

                        </div>
                    </div>
                </div>

                {{--<div class="form-group">--}}
                    {{--<label for="lastname">Last name</label>--}}
                    {{--<div>--}}
                        {{--<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="username">Username</label>--}}
                    {{--<div>--}}
                        {{--<input type="text" class="form-control" id="username" name="username" placeholder="Username">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="email">Email</label>--}}
                    {{--<div>--}}
                        {{--<input type="text" class="form-control" id="email" name="email" placeholder="Email">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<label for="password">Password</label>--}}
                    {{--<input type="password" class="form-control" id="password" name="password" placeholder="Password">--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="confirm_password">Confirm password</label>--}}
                    {{--<div>--}}
                        {{--<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div>--}}
                        {{--<div class="form-check">--}}
                            {{--<input type="checkbox" id="agree" name="agree" value="agree" class="form-check-input">--}}
                            {{--<label class="form-check-label">Please agree to our policy</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="signup" value="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script_js')
    <script>

        (function ($) {
            $("#checkAll").on("click", function () {

                var isChecked = $(this).prop('checked');
                if(isChecked) {
                    $(".permission_item").prop('checked', true);
                }else {
                    $(".permission_item").prop('checked', false);
                }
            });

            $(".permission_item").on("click", function () {
                if ($(this).is(":checked")) {
                    var isAllChecked = 0;

                    $(".permission_item").each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    });

                    if (isAllChecked == 0) {
                        $("#checkAll").prop("checked", true);
                    }
                }
                else {
                    $("#checkAll").prop("checked", false);
                }

            });

            $("#guard_name").on("change", function () {

                var guard_value = $(this).val();
                alert(guard_value)
                if(guard_value != 0 || guard_value != "") {
                    $.ajax({
                        cache     : false,
                        type      : "POST",
                        data      : {
                            guard_name          : guard_value,
                            _token  : "{{ csrf_token() }}"
                        },
                        url       : "{{ route('admin.getPermissionsByGuard') }}",
                        error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                        success   : function(response){
                            console.log(response);
                            $("#permission_data").html(response);
                        }
                    })
                }
            })

        })(jQuery);

        function confirmSubmit() {
            var role_type = $("#guard_name").val();
            if("" == role_type || role_type == 0) {
                $("#select2-guard_name-container").parent().css("border-color", "#d92550");
                return false;
            }else{
                $("#select2-guard_name-container").parent().css("border-color", "#3ac47d");

            }

        }


    </script>
@endsection