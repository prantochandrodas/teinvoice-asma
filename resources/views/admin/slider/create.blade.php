@extends('layouts.admin_layout.admin_layout')

@section('content')




<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Slider</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.slider.index') }}">Slider</a></li>
            <li class="breadcrumb-item active">Create</li>
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
                        <h3 class="card-title">Create New Slider </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="offset-md-1 col-md-10 ">
                            <div class="card card-primary">
                                <form role="form" action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return formValidation()">
                                  @csrf
                                    <div class="card-body row">
                                        <div class="form-group col-md-12">
                                            <label for="type">Slider Type <code>*</code> </label>
                                            <select name="type" id="type" class="form-control  select2 @error('type') is-invalid @enderror" >
                                                <option value="">Select Slider Type</option>
                                                <option value="1">Shop</option>
                                                <option value="2">Customer</option>
                                                <option value="3">Rider</option>
                                            </select>
                                            @error('type')
                                                <div class="text-danger" role="alert" style="display: block !important">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="title"> Title </label>
                                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror" placeholder="Enter Slider Title">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="subtitle"> Sub-Title </label>
                                            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}"
                                            class="form-control @error('subtitle') is-invalid @enderror" placeholder="Enter Slider Sub-Title">
                                            @error('subtitle')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="description">Description  </label>
                                            <textarea name="description" id="description"
                                               class="form-control @error('description') is-invalid @enderror" placeholder="Slider Description"
                                            >{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="image">Photo <code>*</code> </label>
                                            <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror"
                                                accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                            <div id="preview_file" style="margin-top: 10px;"></div>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="reset" class="btn btn-primary">Reset</button>
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


    window.onload = function(){

    }
    function formValidation(){
        let type = $('#type').val();
        if(type == ''){
            toastr.error("Please Select Type..");
            $("#select2-type-container").parent().css('border-color', 'red');
            return false;
        } else{
            $("#select2-type-container").parent().css('border-color', '#ced4da');
        }
    }
  </script>
@endpush
