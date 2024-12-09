@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Area/Upazila</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.area.index') }}">Area/Upazilas</a></li>
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
                            <h3 class="card-title">Edit Area/Upazila </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.area.update', $area->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')
                                        <div class="card-body row">
                                            <div class="form-group col-md-6">
                                                <label for="country_id"> Country <code>*</code> </label>
                                                <select name="country_id" id="country_id" class="form-control select2" style="width: 100%">
                                                  <option value="0">Select Country</option>
                                                  @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == $area->country->id ? "selected" : "" }}
                                                        >
                                                        {{ $country->name }}
                                                    </option>
                                                  @endforeach
                                                </select>
                                                @error('country_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="division_id"> Division/State <code>*</code> </label>
                                                <select name="division_id" id="division_id" class="form-control select2" style="width: 100%">
                                                  <option value="0">Select Division/State</option>
                                                  @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ $division->id == $area->division->id ? "selected" : "" }}
                                                        >
                                                        {{ $division->name }}
                                                    </option>
                                                  @endforeach
                                                </select>
                                                @error('division_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="district_id"> District/City <code>*</code> </label>
                                                <select name="district_id" id="district_id" class="form-control select2" style="width: 100%">
                                                    <option value="0">Select District/City</option>
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}"
                                                            {{ $district->id == $area->district_id ? "selected" : "" }}
                                                            >
                                                            {{ $district->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('district_id')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="name"> Name <code>*</code>  </label>
                                                <input type="text" name="name" id="name" value="{{ $area->name ?? old('name') }}"
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
    }

    function formValidation(){
        let country_id = $('#country_id').val();
        if(country_id == '0'){
            toastr.error("Please Select Country..");
            $("#select2-country_id-container").parent().css('border-color', 'red');
            return false;
        } else{
            $("#select2-country_id-container").parent().css('border-color', '#ced4da');
        }

        let division_id = $('#division_id').val();
        if(division_id == '0'){
            toastr.error("Please Select Division/City..");
            $("#select2-division_id-container").parent().css('border-color', 'red');
            return false;
        } else{
            $("#select2-division_id-container").parent().css('border-color', '#ced4da');
        }
    }

    </script>

@endpush
