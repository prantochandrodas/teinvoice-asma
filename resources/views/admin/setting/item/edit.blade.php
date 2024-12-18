@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('message.items') }} ({{__('message.items', [], $secondary_locale)}})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.item.index') }}">{{ __('message.item') }} ({{__('message.item', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item active">{{ __('message.edit') }} ({{__('message.edit', [], $secondary_locale)}})</li>
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
                            <h3 class="card-title"> {{ __('message.edit') }} {{ __('message.item') }}({{__('message.edit', [], $secondary_locale)}} {{__('message.item', [], $secondary_locale)}})</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.item.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')

                                        <div class="card-body row">

                                            <div class="form-group col-md-6">
                                                <label for="code">{{ __('message.code') }} ({{__('message.code', [], $secondary_locale)}}) <code>*</code>  </label>
                                                <input type="text" name="code" id="code" value="{{ $item->code ?? old('code') }}"
                                                class="form-control @error('code') is-invalid @enderror" placeholder="Enter Code" required>
                                                @error('code')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="name">{{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}}) <code>*</code> </label>
                                                <input type="text" name="name" id="name"  value="{{ $item->name ?? old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror"  placeholder="Enter Name" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            
                                            
                                            
                                            <div class="form-group col-md-3">
                                                <label for="price">{{ __('message.price') }} ({{__('message.price', [], $secondary_locale)}}) </label>
                                                <input type="number" name="price" id="price"  value="{{  $item->price ?? old('price') }}"
                                                    step="any" 
                                                    class="form-control @error('price') is-invalid @enderror"  placeholder="Enter Price" required>
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="tax">{{ __('message.tax') }} ({{__('message.tax', [], $secondary_locale)}}) %</label>
                                                <input type="number" name="tax" id="tax"  value="{{  $item->tax ?? old('tax') }}"
                                                     step="any" 
                                                    class="form-control @error('tax') is-invalid @enderror"  placeholder="Enter Tax" readonly required>
                                                @error('tax')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="price_without_tax">{{ __('message.price_without_tax') }} ({{__('message.price_without_tax', [], $secondary_locale)}})</label>
                                                <input type="number" name="price_without_tax" id="price_without_tax"
                                                    value="{{  $item->price_without_tax ?? old('price_without_tax') }}"
                                                    class="form-control @error('price_without_tax') is-invalid @enderror"
                                                     step="any" 
                                                    readonly placeholder="Enter Price Without Tax" required>
                                                @error('price_without_tax')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="purchase_price">{{ __('message.purchase_price') }} ({{__('message.purchase_price', [], $secondary_locale)}}) </label>
                                                <input type="number" name="purchase_price" id="purchase_price"
                                                     value="{{ $item->purchase_price ?? old('purchase_price') }}"
                                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                                     step="any" 
                                                    placeholder="Enter Purchase Price" step="any" required>
                                                @error('purchase_price')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            
                                            
                                            
                                            <div class="form-group col-md-12">
                                                <label for="details">{{ __('message.details') }} ({{__('message.details', [], $secondary_locale)}}) </label>
                                                <textarea type="details" name="details" id="details"
                                                   class="form-control @error('details') is-invalid @enderror" placeholder="Details"
                                                >{{ $item->details ?? old('details') }}</textarea>
                                                @error('details')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group col-md-6">
                                                <label for="quantity">Quantity </label>
                                                <input type="number" name="quantity" id="quantity"  value="{{ $item->quantity ?? old('quantity') }}"
                                                    class="form-control @error('quantity') is-invalid @enderror"  placeholder="Enter Quantity" step="any"  >
                                                @error('quantity')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div> --}}
                                            
                                            
                                            
                                            <div class="form-group col-md-6">
                                                <label for="image">{{ __('message.image') }} ({{__('message.image', [], $secondary_locale)}}) </label>
                                                <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file')" >
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($item->image != null)
                                                        <img src="{{ $item->image_path }}"
                                                            class="img-fluid img-thumbnail"
                                                            style="height: 100px" alt="Customer">
                                                    @endif
                                                </div>
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert" ><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-md-3">
                                                <label for="name">{{ __('message.date_of_manufacture') }} ({{__('message.date_of_manufacture', [], $secondary_locale)}}) <code>*</code> </label>
                                                <input type="date" name="manufacture_date" id="from_date" class="form-control"  value="{{ $item->manufacture_date ?? old('manufacture_date') }}"
                                                    class="form-control @error('manufacture_date') is-invalid @enderror"  placeholder="Enter Manufacture Date">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            
                                            
                                            <div class="form-group col-md-3">
                                                <label for="name">{{ __('message.date_of_expiry') }} ({{__('message.date_of_expiry', [], $secondary_locale)}}) <code>*</code> </label>
                                                <input type="date" name="expiry_date" id="from_date" class="form-control"   value="{{ $item->expiry_date ?? old('expiry_date') }}"
                                                    class="form-control @error('expiry_date') is-invalid @enderror"  placeholder="Enter Expiry Date">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            
                                            
                                            
                                            
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">{{ __('message.update') }} ({{__('message.update', [], $secondary_locale)}})</button>
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
        $("#price_without_tax").val(price_without_tax);
        $("#tax").val(tax);
    }


        function formValidation() {

        }
    </script>
@endpush
