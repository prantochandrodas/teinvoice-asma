@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Shop Type</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.shopType.index') }}">Shop Types</a></li>
            <li class="breadcrumb-item active">Update</li>
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
                            <h3 class="card-title">Edit Shop Type </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.shopType.update', $shopType->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')
                                        <div class="card-body row">
                                            <div class="form-group col-md-12">
                                                <label for="name"> Name <code>*</code>  </label>
                                                <input type="text" name="name" id="name" value="{{ $shopType->name ?? old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter District/City Name" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">Update</button>
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
@endpush

@push('script_js')
  <script>
        window.onload = function(){

        }

        function formValidation(){
            let name = $('#name').val();
            if(name == ''){
                toastr.error("Please Enter Shop Type Name..");
                $("#name").css('border-color', 'red');
                return false;
            } else{
                $("#name").css('border-color', '#ced4da');
            }
        }

    </script>

@endpush
