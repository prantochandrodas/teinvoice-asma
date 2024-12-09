@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Suppliers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.supplier.index') }}">Supplier</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit Supplier </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return editForm()">
                                        @csrf
                                        @method('patch')

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="code">Supplier Code</label>
                                                <input type="text" name="code" id="code" value="{{ $supplier->code ?? old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="Enter Supplier Code" required>
                                                @error('code')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Supplier Name</label>
                                                <input type="text" name="name" id="name" value="{{ $supplier->name ?? old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Supplier Name" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="company_name">Supplier Company Name</label>
                                                <input type="text" name="company_name" id="company_name" value="{{  $supplier->company_name ??  old('company_name') }}" class="form-control @error('company_name') is-invalid @enderror" placeholder="Enter Supplier Company Name" >
                                                @error('company_name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Supplier Email</label>
                                                <input type="text" name="email" id="email" value="{{  $supplier->email ??  old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Supplier Email" >
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="contact_number">Supplier Contact Number</label>
                                                <input type="text" name="contact_number" id="contact_number" value="{{  $supplier->contact_number ??  old('contact_number') }}" class="form-control @error('contact_number') is-invalid @enderror" placeholder="Enter Supplier Contact Number" required>
                                                @error('contact_number')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea name="address" id="address" class="form-control  @error('address') is-invalid @enderror"
                                                    placeholder="Enter Supplier Address">{{  $supplier->address ??  old('address') }}</textarea>
                                                @error('address')
                                                    <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="image">Image </label>
                                                <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="return filePreview(this)" >
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($supplier->image != null)
                                                        <img src="{{ asset('uploads/supplier/' . $supplier->image) }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="User">
                                                    @endif
                                                </div>
                                                @error('image')
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


@push('script_js')
    <script>
        function editForm() {

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
