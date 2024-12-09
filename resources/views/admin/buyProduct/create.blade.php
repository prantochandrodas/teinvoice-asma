@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Buy Product Entry</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Buy Product Entry</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Buy Product Entry</h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <form action="{{ route('admin.buy-product-entry.store') }}" method="POST" id="dynamicForm">
                    @csrf
                    <div class="ml-3 ">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label class="mb-2" for="">Purchase No :</label>
                                <input type="text" class="form-control" name="purchase_no[]" placeholder="Purchase No"
                                    required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="mb-2" for="">Supplier Name :</label>
                                <input type="text" class="form-control" name="supplier_name[]"
                                    placeholder="Supplier Name" required>
                            </div>
                            <div class="col-md-1 mb-2">
                                <label class="mb-2" for="">Item Code :</label>
                                <input type="text" class="form-control" name="item_code[]" placeholder="Item Code"
                                    required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="mb-2" for="">Item Name :</label>
                                <input type="text" class="form-control" name="item_name[]" placeholder="Item Name"
                                    required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="mb-2" for="">Item Buy Bill :</label>
                                <input type="number" class="form-control" name="item_buy_bill[]"
                                    placeholder="Item Buy Bill " required step="any" >
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="mb-2" for="">Total Cost :</label>
                                <input type="number" class="form-control" name="total_cost[]" placeholder="Total Cost "
                                    required step="any">
                            </div>
                        </div>
                        <div   id="wrapper">

                        </div>
                        <div style="display: flex;justify-content: space-between;">
                            <div>
                                <button type="button" class="btn btn-lg btn-primary mt-3" onclick="addField()">Add
                                    More</button>
                            </div>
                            <div style="margin-right: 50px">
                                <button type="submit" class="btn btn-lg btn-success mt-3">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script_js')
    <script>
        var i = 0;

        function addField() {
            i++;
            $("#wrapper").append(`
            <div class="row" id="row-${i}">
                <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" name="purchase_no[]" placeholder="Purchase No"
                        required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" name="supplier_name[]" placeholder="Supplier Name"
                        required>
                </div>
                <div class="col-md-1 mb-2">
                    <input type="text" class="form-control" name="item_code[]" placeholder="Item Code" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" name="item_name[]" placeholder="Item Name" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="number" class="form-control" name="item_buy_bill[]" placeholder="Item Buy Bill "
                        required step="any">
                </div>
                <div class="col-md-2 mb-2">
                    <input type="number" class="form-control" name="total_cost[]" placeholder="Total Cost "
                        required step="any">

                </div>
                <div class="col-md-1 mb-1">
                    <button type="button" class="remove btn btn-md btn-danger text-center mt-1 ml-2" onclick="removeRow(${i})">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            `);

        }


        function removeRow(rowId) {
            $(`#row-${rowId}`).remove();
        }
    </script>
@endpush
