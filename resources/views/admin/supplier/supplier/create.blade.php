@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.supplier') }} ({{__('message.supplier', [], $secondary_locale)}})</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.supplier.index') }}">{{ __('message.supplier') }} ({{__('message.supplier', [], $secondary_locale)}})</a></li>
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
                        <h3 class="card-title">{{ __('message.create_new_supplier') }} ({{__('message.create_new_supplier', [], $secondary_locale)}}) </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="offset-md-1 col-md-10 ">
                            <div class="card card-primary">
                                <form role="form" action="{{ route('admin.supplier.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return createForm()">
                                  @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="code">{{ __('message.supplier') }} {{ __('message.code') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.code', [], $secondary_locale)}})</label>
                                            <input type="text" name="code" id="code" value="{{ $unique_code }}" class="form-control @error('code') is-invalid @enderror" placeholder="Enter Supplier Code" required>
                                            @error('code')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ __('message.supplier') }} {{ __('message.name') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.name', [], $secondary_locale)}})</label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Supplier Name" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="company_name"> {{ __('message.supplier') }} {{ __('message.company_name') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.company_name', [], $secondary_locale)}})</label>
                                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" class="form-control @error('company_name') is-invalid @enderror" placeholder="Enter Supplier Company Name" >
                                            @error('company_name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ __('message.supplier') }} {{ __('message.email') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.email', [], $secondary_locale)}})</label>
                                            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Supplier Email" >
                                            @error('email')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_number"> {{ __('message.supplier') }} {{ __('message.contact_number') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.contact_number', [], $secondary_locale)}})</label>
                                            <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" class="form-control @error('contact_number') is-invalid @enderror" placeholder="Enter Supplier Contact Number" required>
                                            @error('contact_number')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="address">{{ __('message.address') }} ({{__('message.address', [], $secondary_locale)}})</label>
                                            <textarea name="address" id="address" class="form-control  @error('address') is-invalid @enderror"
                                                placeholder="Enter Supplier Address">{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="image">{{ __('message.image') }} ({{__('message.image', [], $secondary_locale)}}) </label>
                                            <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="return filePreview(this)" >
                                            <div id="preview_file" style="margin-top: 10px;"></div>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">{{ __('message.submit') }} ({{__('message.submit', [], $secondary_locale)}})</button>
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
    function createForm(){

    }

    function filePreview(input) {
        $('#preview_file').html('');
        if (input.files && input.files[0]) {
            $('#preview_file').html('<img src="{{ asset('image/image_loading.gif') }}" style="height:80px; width: 120px" class="profile-user-img img-responsive img-rounded  "/>');
            var reader = new FileReader();

            if(input.files[0].size > 3000000){
                input.value='';
                $('#preview_file').html('');
            }
            else{
                reader.onload = function (e) {
                $('#preview_file').html('<img src="'+e.target.result+'" style="height:80px; width: 120px" class="profile-user-img img-responsive img-rounded  "/>');
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
    }
  </script>
@endpush
