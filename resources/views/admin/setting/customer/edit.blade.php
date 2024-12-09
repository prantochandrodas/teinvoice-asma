@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Customers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Customer</a></li>
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
                            <h3 class="card-title">Edit Customer </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.customer.update', $customer->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')

                                        <div class="card-body row">

                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone<code>*</code> </label>
                                                <input type="text" name="phone" id="phone"  value="{{ $customer->phone ?? old('phone') }}"
                                                    class="form-control @error('phone') is-invalid @enderror"  placeholder="Enter Phone" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name">Name <code>*</code>  </label>
                                                <input type="text" name="name" id="name" value="{{ $customer->name ?? old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter User Name" autocomplete="off" required >
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="email">Email  </label>
                                                <input type="email" name="email" id="email"  value="{{ $customer->email ?? old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror"  placeholder="Enter email" autocomplete="off" required >
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="vat_no">Vat No  <code>*</code> </label>
                                                <input type="text" name="vat_no" id="vat_no"  value="{{  $customer->vat_no ?? old('vat_no') }}"
                                                    class="form-control @error('vat_no') is-invalid @enderror"  placeholder="Enter Vat No" autocomplete="off" required >
                                                @error('vat_no')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="image">Image </label>
                                                <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($customer->image != null)
                                                        <img src="{{ $customer->image_path }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="Customer">
                                                    @endif
                                                </div>
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="address">Address  </label>
                                                <textarea type="address" name="address" id="address"
                                                   class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                                >{{ $customer->address ?? old('address') }}</textarea>
                                                @error('address')
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
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function formValidation() {

        }
    </script>
@endpush
