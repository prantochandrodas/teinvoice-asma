@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.items') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.item.index') }}">{{ __('message.items') }}</a></li>
            <li class="breadcrumb-item active">{{ __('message.create') }}</li>
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
                        <h3 class="card-title">{{ __('message.create_new_admins') }} </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="offset-md-1 col-md-10 ">
                            <div class="card card-primary">
                                <form role="form" action="{{ route('admin.item.store') }}"
                                method="POST" enctype="multipart/form-data" onsubmit="return formValidation()">
                                  @csrf
                                    <div class="card-body row">

                                        <div class="form-group col-md-6">
                                            <label for="code">{{ __('message.code') }} <code>*</code>  </label>
                                            <input type="text" name="code" id="code" value="{{ old('code') }}"
                                            class="form-control @error('code') is-invalid @enderror" placeholder="{{ __('message.code') }}" required>
                                            @error('code')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="name">{{ __('message.name') }} <code>*</code> </label>
                                            <input type="text" name="name" id="name"  value="{{ old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror"  placeholder="{{ __('message.name') }}" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="price">{{ __('message.price') }} </label>
                                            <input type="number" step="any" name="price" id="price"  value="{{ old('price') }}"
                                                class="form-control @error('price') is-invalid @enderror"  placeholder="{{ __('message.price') }}" required>
                                            @error('price')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="tax">{{ __('message.tax') }} %</label>
                                            <input type="number" step="any" name="tax" id="tax"  value="{{ old('tax') }}"
                                                class="form-control @error('tax') is-invalid @enderror"  placeholder="{{ __('message.tax') }} " readonly required>
                                            @error('tax')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="price_without_tax">{{ __('message.price_without_tax') }}</label>
                                            <input type="number" step="any" name="price_without_tax" id="price_without_tax"
                                                value="{{ old('price_without_tax') }}"
                                                class="form-control @error('price_without_tax') is-invalid @enderror"
                                                placeholder="{{ __('message.price_without_tax') }}" readonly required >
                                            @error('price_without_tax')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="purchase_price">{{ __('message.purchase_price') }}</label>
                                            <input type="number" step="any" name="purchase_price" id="purchase_price"  value="{{ old('purchase_price') }}"
                                                class="form-control @error('purchase_price') is-invalid @enderror"
                                                placeholder="{{ __('message.purchase_price') }}" required>
                                            @error('purchase_price')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="details">{{ __('message.details') }}  </label>
                                            <textarea type="details" name="details" id="details"
                                               class="form-control @error('details') is-invalid @enderror"
                                               placeholder="{{ __('message.details') }}"
                                            >{{ old('details') }}</textarea>
                                            @error('details')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        
                                        
                                        {{-- <div class="form-group col-md-6">
                                            <label for="quantity">{{ __('message.quantity') }} </label>
                                            <input type="number" name="quantity" id="quantity"  value="{{ old('quantity') }}"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                placeholder="{{ __('message.quantity') }}" >
                                            @error('quantity')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div> --}}
                                        
                                        
                                        <div class="form-group col-md-6">
                                            <label for="image">{{ __('message.image') }} </label>
                                            <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror"
                                                accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                            <div id="preview_file" style="margin-top: 10px;"></div>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                            @enderror
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-3">
                                            <label for="from_date">Date of Manufacture</label>
                                            <input type="date" name="manufacture_date" id="from_date" class="form-control"  value="{{ date('Y-m-d') }}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label for="from_date">Date of Expiry</label>
                                            <input type="date" name="expiry_date" id="from_date" class="form-control"  value="{{ date('Y-m-d') }}"/>
                                        </div>
                                        
                                        
                                        
                                        
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">{{ __('message.submit') }}</button>
                                        <button type="reset" class="btn btn-primary">{{ __('message.reset') }}</button>
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

        $( "#price" ).keyup(function() {
            calculatePriceWithoutTax();
        });
        // $( "#tax" ).keyup(function() {
        //     calculatePriceWithoutTax();
        // });

    }

    function calculatePriceWithoutTax(){
        var price   = returnNumber($("#price").val());
        var tax     = (price / 100 * 15);
        var price_without_tax = price - tax;
        $("#price_without_tax").val(price_without_tax.toFixed(2));
        $("#tax").val(tax.toFixed(2));
    }


    function formValidation(){

    }
  </script>
@endpush
