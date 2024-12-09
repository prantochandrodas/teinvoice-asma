@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Riders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.rider.index') }}">Rider</a></li>
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
                            <h3 class="card-title">Edit Rider </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.rider.update', $rider->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')

                                        <div class="card-body row">
                                            <div class="form-group col-md-6">
                                                <label for="username">User Name <code>*</code>  </label>
                                                <input type="text" name="username" id="username" value="{{  $rider->username ?? old('username') }}"
                                                class="form-control @error('username') is-invalid @enderror" placeholder="Enter User Name" required>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="email">Email address <code>*</code> </label>
                                                <input type="email" name="email" id="email"  value="{{ $rider->email ?? old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror"  placeholder="Enter email" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name <code>*</code>  </label>
                                                <input type="text" name="first_name" id="first_name" value="{{ $rider->first_name ?? old('first_name') }}"
                                                    class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter First Name" required>
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Last Name <code>*</code>  </label>
                                                <input type="text" name="last_name" id="last_name" value="{{ $rider->last_name ?? old('last_name') }}"
                                                    class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter Last Name" required>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone<code>*</code> </label>
                                                <input type="text" name="phone" id="phone"  value="{{ $rider->phone ?? old('phone') }}"
                                                    class="form-control @error('phone') is-invalid @enderror"  placeholder="Enter Phone" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password">Password <code>*</code> </label>
                                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password" >
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="address">Address  </label>
                                                <textarea type="address" name="address" id="address"
                                                   class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                                >{{ $rider->address ?? old('address') }}</textarea>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="photo">Photo </label>
                                                <input type="file" name="photo" id="photo"  class="form-control @error('photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($rider->photo != null)
                                                        <img src="{{ file_url($rider->photo, 'customer') }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="Customer">
                                                    @endif
                                                </div>
                                                @error('photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="nid_number">NID Number </label>
                                                <input type="text" name="nid_number" id="nid_number"  value="{{ $rider->nid_number ??  old('nid_number') }}"
                                                    class="form-control @error('nid_number') is-invalid @enderror"  placeholder="Enter Phone" >
                                                @error('nid_number')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="nid_photo">NID Photo </label>
                                                <input type="file" name="nid_photo" id="nid_photo"  class="form-control @error('nid_photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file_nid_photo')" >
                                                <div id="preview_file_nid_photo" style="margin-top: 10px;">
                                                    @if ($rider->nid_photo != null)
                                                        <img src="{{ file_url($rider->nid_photo, 'customer') }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="NID Photo">
                                                    @endif
                                                </div>
                                                @error('nid_photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="country_id"> Country  </label>
                                                <select name="country_id" id="country_id" class="form-control select2" style="width: 100%">
                                                  <option value="0">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $rider->country && $rider->country->id == $country->id ? "selected" : "" }}>
                                                            {{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="division_id"> Division/State  </label>
                                                <select name="division_id" id="division_id" class="form-control select2" style="width: 100%">
                                                    <option value="0">Select Division/State</option>
                                                    @foreach ($divisions as $division)
                                                        <option value="{{ $division->id }}" {{ $rider->division && $rider->division->id == $division->id ? "selected" : ""}}>
                                                            {{ $division->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('division_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="district_id"> District/City <code>*</code> </label>
                                                <select name="district_id" id="district_id" class="form-control select2" style="width: 100%">
                                                    <option value="0">Select District/City</option>
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}" {{ $rider->district_id == $district->id ? "selected" : ""}}>
                                                            {{ $district->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('district_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="area_id"> Area/Upazila </label>
                                                <select name="area_id" id="area_id" class="form-control select2" style="width: 100%">
                                                    <option value="0">Select Area/Upazila</option>
                                                    @foreach ($areas as $area)
                                                        <option value="{{ $area->id }}" {{ $rider->area_id == $area->id ? "selected" : ""}}>
                                                            {{ $area->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('area_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="branch_id">Branch</label>
                                                <select name="branch_id" id="branch_id" class="form-control select2" >
                                                    <option value="">Select Branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ $rider->branch_id == $branch->id ? "selected" : ""}}>{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('branch_id')
                                                    <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
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
