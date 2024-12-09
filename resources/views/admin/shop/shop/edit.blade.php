@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Shop</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.shop.index') }}">Shop</a></li>
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
                            <h3 class="card-title">Edit Shop </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.shop.update', $shop->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')

                                        <div class="card-body row">
                                            <div class="form-group col-md-12">
                                                <label for="shop_type_id">Shop Type <code>*</code></label>
                                                <select name="shop_type_id" id="shop_type_id" class="form-control select2" >
                                                    <option value="">Select Shop Type</option>
                                                    @foreach ($shopTypes as $shopType)
                                                        <option value="{{ $shopType->id }}" {{ $shopType->id == $shop->shop_type_id ? "selected" : "" }}>
                                                            {{ $shopType->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('shop_type_id')
                                                    <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name"> Name <code>*</code>  </label>
                                                <input type="text" name="name" id="name" value="{{ $shop->name ?? old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter Shop Name" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="owner_name"> Owner Name   </label>
                                                <input type="text" name="owner_name" id="owner_name" value="{{ $shop->owner_name ??  old('owner_name') }}"
                                                class="form-control @error('owner_name') is-invalid @enderror" placeholder="Enter Shop Owner Name" >
                                                @error('owner_name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="email">Email  <code>*</code> </label>
                                                <input type="email" name="email" id="email"  value="{{ $shop->email ?? old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror"  placeholder="Enter Email" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone<code>*</code> </label>
                                                <input type="text" name="phone" id="phone"  value="{{ $shop->phone ?? old('phone') }}"
                                                    class="form-control @error('phone') is-invalid @enderror"  placeholder="Enter Phone" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="address">Address  </label>
                                                <textarea type="address" name="address" id="address"
                                                   class="form-control @error('address') is-invalid @enderror" placeholder="Shop Address"
                                                >{{  $shop->address ?? old('address') }}</textarea>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password">Password </label>
                                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password" >
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="photo">Photo </label>
                                                <input type="file" name="photo" id="photo"  class="form-control @error('photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($shop->photo != null)
                                                        <img src="{{ $shop->photo_path }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="Shop">
                                                    @endif
                                                </div>
                                                @error('photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="banner_photo"> Banner Photo </label>
                                                <input type="file" name="banner_photo" id="banner_photo"  class="form-control @error('banner_photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file_banner_photo')" >
                                                <div id="preview_file_banner_photo" style="margin-top: 10px;">
                                                    @if ($shop->banner_photo != null)
                                                        <img src="{{ $shop->banner_photo_path }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="Shop">
                                                    @endif
                                                </div>
                                                @error('banner_photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="nid_number">NID Number </label>
                                                <input type="text" name="nid_number" id="nid_number"  value="{{ $shop->nid_number ??  old('nid_number') }}"
                                                    class="form-control @error('nid_number') is-invalid @enderror"  placeholder="Enter NID Number" >
                                                @error('nid_number')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="nid_photo">NID Photo </label>
                                                <input type="file" name="nid_photo" id="nid_photo"  class="form-control @error('nid_photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file_nid_photo')" >
                                                <div id="preview_file_nid_photo" style="margin-top: 10px;">
                                                    @if ($shop->nid_photo != null)
                                                        <img src="{{ $shop->nid_photo_path }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="NID Photo">
                                                    @endif
                                                </div>
                                                @error('nid_photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="trade_license_number">Trade License Number </label>
                                                <input type="text" name="trade_license_number" id="trade_license_number"  value="{{ $shop->trade_license_number ??  old('trade_license_number') }}"
                                                    class="form-control @error('trade_license_number') is-invalid @enderror"  placeholder="Enter Trade License Number" >
                                                @error('trade_license_number')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="trade_license_photo">Trade License Photo </label>
                                                <input type="file" name="trade_license_photo" id="trade_license_photo"  class="form-control @error('trade_license_photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file_trade_license_photo')" >
                                                <div id="preview_file_trade_license_photo" style="margin-top: 10px;">
                                                    @if ($shop->trade_license_photo != null)
                                                        <img src="{{ $shop->trade_license_photo_path }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="NID Photo">
                                                    @endif
                                                </div>
                                                @error('trade_license_photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tin_number">TIN Number  </label>
                                                <input type="text" name="tin_number" id="tin_number"  value="{{ $shop->tin_number ??  old('tin_number') }}"
                                                    class="form-control @error('tin_number') is-invalid @enderror"  placeholder="Enter TIN Number " >
                                                @error('tin_number')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tin_photo">TIN Photo </label>
                                                <input type="file" name="tin_photo" id="tin_photo"  class="form-control @error('tin_photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file_tin_photo')" >
                                                <div id="preview_file_tin_photo" style="margin-top: 10px;">
                                                    @if ($shop->tin_photo != null)
                                                        <img src="{{ $shop->tin_photo_path }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="NID Photo">
                                                    @endif
                                                </div>
                                                @error('tin_photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="latitude">Latitude </label>
                                                <input type="text" name="latitude" id="latitude"  value="{{ $shop->latitude ?? old('latitude') }}"
                                                    class="form-control @error('latitude') is-invalid @enderror"  placeholder="Enter Latitude" >
                                                @error('latitude')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" name="longitude" id="longitude"  value="{{ $shop->longitude ?? old('longitude') }}"
                                                    class="form-control @error('longitude') is-invalid @enderror"  placeholder="Enter Longitude" >
                                                @error('longitude')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="country_id"> Country  </label>
                                                <select name="country_id" id="country_id" class="form-control select2" style="width: 100%">
                                                  <option value="0">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $shop->country && $shop->country->id == $country->id ? "selected" : "" }}>
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
                                                        <option value="{{ $division->id }}" {{ $shop->division && $shop->division->id == $division->id ? "selected" : ""}}>
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
                                                        <option value="{{ $district->id }}" {{ $shop->district_id == $district->id ? "selected" : ""}}>
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
                                                        <option value="{{ $area->id }}" {{ $shop->area_id == $area->id ? "selected" : ""}}>
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
                                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('branch_id')
                                                    <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="product_tag_id">Product Tag</label>
                                                <select name="product_tag_id[]" id="product_tag_id" class="form-control select2" multiple>
                                                    @foreach ($productTags as $productTag)
                                                        @php
                                                            $selected = "";
                                                            foreach($shop->product_tags as $product_tag){
                                                                if($product_tag->id == $productTag->id){
                                                                    $selected = "selected";
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <option value="{{ $productTag->id }}" {{ $selected }}>
                                                            {{ $productTag->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('product_tag_id')
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
