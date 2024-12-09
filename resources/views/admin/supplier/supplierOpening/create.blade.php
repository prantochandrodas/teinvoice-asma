@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Supplier Opening Form </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Supplier Opening  Form </li>
            </ol>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <fieldset>
                                <legend>Supplier Opening </legend>
                                <div class="row">
                                    <div class="card-body">
                                        <form role="form" action="{{ route('admin.supplierOpening.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return formValidation()">
                                            @csrf
                                            <div class="form-group">
                                                <label for="supplier_id">Supplier </label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2  @error('supplier_id') is-invalid @enderror" style="width: 100%" >
                                                    <option value="0" > Select Supplier </option>
                                                    @if ($suppliers->count())
                                                        @foreach ($suppliers as $supplier)
                                                            <option value="{{ $supplier->id }}" data-balance="{{ $supplier->balance }}">{{ $supplier->name }} - {{ $supplier->contact_number }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('supplier_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="balance"> Balance </label>
                                                <input type="number" name="balance" id="balance"  value="0" class="form-control @error('balance') is-invalid @enderror" placeholder="Supplier Balance"  min="0" step="any" readonly required>
                                                @error('balance') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="amount">Amount </label>
                                                <input type="number" name="amount" id="amount"  value="0" class="form-control @error('amount') is-invalid @enderror" placeholder="Supplier Amount"  min="0" step="any"  required>
                                                @error('amount') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="form-control @error('date') is-invalid @enderror" required>
                                                @error('date') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Note</label>
                                                <textarea name="note" id="note" class="form-control  @error('note') is-invalid @enderror" placeholder="Supplier Opening Note" rows="3"></textarea>
                                                @error('note') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                <button type="submit" class="btn btn-success" id="confirm_btn"> Confirm </button>
                                                <button type="reset" class="btn btn-primary">Reset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style_css')
<style>

</style>
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  <script>

    window.onload = function(){
        $('#supplier_id').on('change', function(){
            var supplier   = $("#supplier_id option:selected");
            var supplier_id   = supplier.val();

            if(supplier_id == 0 ){
                $("#balance").val(0);
            } else{
                $("#balance").val(supplier.data('balance'));
            }
        });
    }

    function formValidation(){
        var supplier_id     = $("#supplier_id option:selected").val();
        var balance         = returnNumber($("#balance").val());
        var amount          = returnNumber($("#amount").val());

        if(supplier_id == '0'){
            $('#select2-supplier_id-container').parent().css({"border-color": "red"});
            toastr.error("Please Select supplier..");
            return false;
        } else{
            $('#select2-supplier_id-container').parent().css({"border-color": "#aaa"});
        }


        if(amount == 0){
            $('#amount').css({"border-color": "red"});
            toastr.error("Please Enter Amount");
            return false;
        }
    }

  </script>
@endpush
