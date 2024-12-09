@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Branch</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.branch.index') }}">Branches</a></li>
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
                            <h3 class="card-title">Edit Branch </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-offset-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.branch.update', $branch->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return editForm()">
                                        @csrf
                                        @method('patch')
                                        <div class="card-body row">
                                            <div class="form-group col-md-6">
                                                <label for="name"> Name <code>*</code>  </label>
                                                <input type="text" name="name" id="name" value="{{ $branch->name ?? old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter Branch Name" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email"> Email <code>*</code>  </label>
                                                <input type="email" name="email" id="email" value="{{ $branch->email ?? old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter Branch Email" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="phone"> Phone <code>*</code> </label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">+88</div>
                                                    </div>
                                                    <input type="text" name="phone" id="phone"
                                                        value="{{ $branch->phone ??  old('phone') }}" class="form-control @error('phone') is-invalid @enderror"
                                                        required placeholder="Branch Phone" >
                                                </div>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label for="country_id"> Country  </label>
                                                <select name="country_id" id="country_id" class="form-control select2" style="width: 100%">
                                                  <option value="0">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $branch->country->id == $country->id ? "selected" : ""}}>
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
                                                        <option value="{{ $division->id }}" {{ $branch->division->id == $division->id ? "selected" : ""}}>
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
                                                        <option value="{{ $district->id }}" {{ $branch->district->id == $district->id ? "selected" : ""}}>
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
                                                        <option value="{{ $area->id }}" {{ $branch->area->id == $area->id ? "selected" : ""}}>
                                                            {{ $area->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('area_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="address">Address  </label>
                                                <textarea type="address" name="address" id="address"
                                                   class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                                >{{ $branch->address ?? old('address') }}</textarea>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>



                                            <div class="form-group col-md-12">
                                                <label for="photo">Photo </label>
                                                <input type="file" name="photo" id="photo"  class="form-control @error('photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($branch->photo != null)
                                                        <img src="{{ file_url($branch->photo, 'branch') }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="Branch">
                                                    @endif
                                                </div>
                                                @error('photo')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
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

    window.onload = function(){
        $(document).on('change', '#country_id', function(){
            var country_id = $(this).val();
            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                    country_id: country_id,
                },
                error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                url       : "{{ route('division.divisionOptionByCountry') }}",
                success   : function(response){
                    $("#division_id").html(response.option);
                }
            })
        });

        $(document).on('change', '#division_id', function(){
            var division_id = $(this).val();
            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                    division_id: division_id,
                },
                error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                url       : "{{ route('district.districtOptionByDivision') }}",
                success   : function(response){
                    $("#district_id").html(response.option);
                }
            })
        });

        $(document).on('change', '#district_id', function(){
            var district_id = $(this).val();
            $.ajax({
                cache     : false,
                type      : "POST",
                dataType  : "JSON",
                data      : {
                    district_id: district_id,
                },
                error     : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
                url       : "{{ route('area.areaOptionByDistrict') }}",
                success   : function(response){
                    $("#area_id").html(response.option);
                }
            })
        });
    }


    function formValidation(){
        /* let country_id = $('#country_id').val();
        if(country_id == '0'){
            toastr.error("Please Select Country..");
            $("#select2-country_id-container").parent().css('border-color', 'red');
            return false;
        } else{
            $("#select2-country_id-container").parent().css('border-color', '#ced4da');
        } */

        /* let division_id = $('#division_id').val();
        if(division_id == '0'){
            toastr.error("Please Select Division/State..");
            $("#select2-division_id-container").parent().css('border-color', 'red');
            return false;
        } else{
            $("#select2-division_id-container").parent().css('border-color', '#ced4da');
        } */

        let district_id = $('#district_id').val();
        if(district_id == '0'){
            toastr.error("Please Select District/City..");
            $("#select2-district_id-container").parent().css('border-color', 'red');
            return false;
        } else{
            $("#select2-district_id-container").parent().css('border-color', '#ced4da');
        }
    }

  </script>
@endpush
