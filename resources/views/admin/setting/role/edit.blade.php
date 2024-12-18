@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('message.roles') }} ({{__('message.roles', [], $secondary_locale)}})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">{{ __('message.role') }} ({{__('message.role', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item active">{{ __('message.edit') }} ({{__('message.edit', [], $secondary_locale)}})</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('message.edit_role') }} ({{__('message.edit_role', [], $secondary_locale)}})</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.role.update', $role->id) }}" method="POST"
                                        enctype="multipart/form-data" >
                                        @csrf
                                        @method('patch')

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="name">{{ __('message.role_name') }} ({{__('message.role_name', [], $secondary_locale)}})<code>*</code> </label>
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name') ?? $role->name }}" class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="{{ __('message.role_name') }} ({{__('message.role_name', [], $secondary_locale)}})" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <label for="name">{{ __('message.permission') }} ({{__('message.permission', [], $secondary_locale)}})</label>

                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input form-check-input" type="checkbox" id="checkPermissionAll" value="1">
                                                <label for="checkPermissionAll" class="custom-control-label">All</label>
                                            </div>
                                            <hr>

                                            @foreach ($permissions_groups as $group)
                                                @php
                                                    $permissions = App\Models\Admin::getPermissionByGroupName($group->name);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                class="custom-control-input form-check-input"
                                                                type="checkbox"
                                                                id="{{ $loop->iteration }}-management"
                                                                value="{{ $group->name }}"
                                                                onclick="checkPermissionByGroup('role-{{ $loop->iteration }}-management-checkbox', this)"
                                                                {{ App\Models\Admin::roleHasPermissions($role, $permissions) ? "checked" : "" }}
                                                                >
                                                            <label for="{{ $loop->iteration }}-management" class="custom-control-label">{{ $group->name }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-6 role-{{ $loop->iteration }}-management-checkbox">
                                                        @foreach ($permissions as $permission)
                                                            <div class="custom-control custom-checkbox">
                                                                <input
                                                                    class="custom-control-input form-check-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    id="checkPermission{{ $permission->id }}"
                                                                    value="{{ $permission->name }}"
                                                                    onclick="checkSinglePermission('role-{{ $loop->parent->iteration }}-management-checkbox', '{{ $loop->parent->iteration }}-management', {{ count($permissions) }})"
                                                                    {{ $role->hasPermissionTo($permission->name) ? "checked" : "" }}
                                                                >
                                                                <label class="custom-control-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">{{ __('message.update') }} ({{__('message.update', [], $secondary_locale)}})</button>
                                            <button type="reset" class="btn btn-primary">{{ __('message.reset') }} ({{__('message.reset', [], $secondary_locale)}})</button>
                                        </div>
                                    </form>
                                </div>
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
        $("#checkPermissionAll").click(function(){
          if($(this).is(':checked')){
              $("input[type=checkbox]").prop('checked', true);
          } else{
              $("input[type=checkbox]").prop('checked', false);
          }
      });

      function checkPermissionByGroup(className, thisObject) {
          var groupIdName     = $("#"+thisObject.id);
          var classCheekBox   = $('.'+className+' input[type=checkbox]');

          if(groupIdName.is(':checked')){
              classCheekBox.prop('checked', true);
          } else{
              classCheekBox.prop('checked', false);
          }

          implementAllChecked();
      }


      function checkSinglePermission(groupClassName, groupID, CountTotalPermission){
          var classCheckBox = $('.'+groupClassName+' input');
          var groupIDCheckBox = $('#'+groupID);
          // console.log($("."+groupClassName+" input:checked").length, CountTotalPermission);
          // If there is any occurrence where something is not selected then make selected = false
          if ($("."+groupClassName+" input:checked").length == CountTotalPermission) {
              groupIDCheckBox.prop('checked', true);
          } else{
              groupIDCheckBox.prop('checked', false);
          }

          implementAllChecked();
      }


      function implementAllChecked() {
          const countPermissions  = {{ count($all_permissions) }};
          const countPermissionGroups  = {{ count($permissions_groups) }};

          // console.log(countPermissions,countPermissionGroups, $("input[type=checkbox]:checked").length);

          if($("input[type=checkbox]:checked").length == (countPermissions + countPermissionGroups) ){
              $("#checkPermissionAll").prop('checked', true);
          }
          else{
              $("#checkPermissionAll").prop('checked', false);
          }
      }



    </script>
@endpush
