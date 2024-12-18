@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.admins') }} ({{__('message.admins', [], $secondary_locale)}})</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.admin.index') }}">{{ __('message.admin') }} ({{__('message.admin', [], $secondary_locale)}})</a></li>
            <li class="breadcrumb-item active">{{ __('message.create') }} ({{__('message.create', [], $secondary_locale)}})</li>
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
                        <h3 class="card-title">{{ __('message.create_new_admin') }} ({{__('message.create_new_admin', [], $secondary_locale)}}) </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="offset-md-1 col-md-10 ">
                            <div class="card card-primary">
                                <form role="form" action="{{ route('admin.admin.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return formValidation()">
                                  @csrf
                                    <div class="card-body row">
                                        <div class="form-group col-md-6">
                                            <label for="username">{{ __('message.username') }} ({{__('message.username', [], $secondary_locale)}})<code>*</code>  </label>
                                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                            class="form-control @error('username') is-invalid @enderror" placeholder="{{ __('message.enter_username') }} ({{__('message.enter_username', [], $secondary_locale)}})" required>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email">{{ __('message.email') }} ({{__('message.email', [], $secondary_locale)}})<code>*</code> </label>
                                            <input type="email" name="email" id="email"  value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"  placeholder="Enter email" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="first_name">{{ __('message.first_name') }} ({{__('message.first_name', [], $secondary_locale)}})<code>*</code>  </label>
                                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                                class="form-control @error('first_name') is-invalid @enderror" placeholder="{{ __('message.first_name') }} ({{__('message.first_name', [], $secondary_locale)}})" required>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="last_name">{{ __('message.first_name') }} ({{__('message.first_name', [], $secondary_locale)}})<code>*</code>  </label>
                                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                                class="form-control @error('last_name') is-invalid @enderror" placeholder="{{ __('message.first_name') }}" required>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone">{{ __('message.phone') }} ({{__('message.phone', [], $secondary_locale)}})<code>*</code> </label>
                                            <input type="text" name="phone" id="phone"  value="{{ old('phone') }}"
                                                class="form-control @error('phone') is-invalid @enderror"  placeholder="{{ __('message.phone') }} ({{__('message.phone', [], $secondary_locale)}}) " required>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password">{{ __('message.password') }} ({{__('message.password', [], $secondary_locale)}}) <code>*</code> </label>
                                            <input type="password" name="password" id="password" value="{{ old('password') }}"
                                                class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('message.phone') }} ({{__('message.phone', [], $secondary_locale)}})" required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="address">{{ __('message.address') }} ({{__('message.address', [], $secondary_locale)}}) </label>
                                            <textarea type="address" name="address" id="address"
                                               class="form-control @error('address') is-invalid @enderror" placeholder="{{ __('message.address') }} ({{__('message.address', [], $secondary_locale)}})"
                                            >{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="photo">{{ __('message.photo') }} ({{__('message.photo', [], $secondary_locale)}}) </label>
                                            <input type="file" name="photo" id="photo"  class="form-control @error('photo') is-invalid @enderror"
                                                accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                            <div id="preview_file" style="margin-top: 10px;"></div>
                                            @error('photo')
                                                <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="roles">{{ __('message.assign_roles') }} ({{__('message.assign_roles', [], $secondary_locale)}})</label>
                                            <select name="roles[]" id="roles" class="form-control select2" multiple>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('roles')
                                                <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">{{ __('message.create') }} ({{__('message.create', [], $secondary_locale)}})</button>
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

  <style>

  </style>


  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  <script>
    function formValidation(){

    }
  </script>
@endpush
