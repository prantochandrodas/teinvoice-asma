@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Expense (حساب)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Expense (حساب)</li>
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
                            <h3 class="card-title"> Expense List (قائمة النفقات) </h3>
                            @if (auth_admin_user_permission('supplier.create'))
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success float-right">
                                    <i class="fa fa-pencil-alt"></i> Add Expense (أضف النفقات)
                                </button>
                            @endif
                            <div class="col-sm-5" style="display: flex;margin-left:400px">

                                <div class="input-group" style="gap:5px">
                                    <select name="branch_name" id="branch_name" class="form-control">
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="date" id="from_date" class="form-control " value="" />
                                    <input type="date" id="to_date" class="form-control" value="" />
                                </div>
                                <div style="display: flex;gap:2px" class="ml-2">
                                    <button type="button" name="filter" id="filter" class="btn btn-success">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-info">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button title="Print Invoice" class="btn mr-2 btn-success" id="printButton">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="yajraDatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%" class="text-center"> SL (إس إل)</th>
                                        <th width="7%" class="text-center"> Date (تاريخ)</th>
                                        <th width="10%" class="text-center"> Head Name (اسم الرأس) </th>
                                        <th width="10%" class="text-center"> Branch Name</th>
                                        <th width="10%" class="text-center"> Id (بطاقة تعريف)</th>
                                        <th width="10%" class="text-center"> Amount (كمية)</th>
                                        {{-- <th width="10%" class="text-center"> Description</th> --}}
                                        <th width="10%" class="text-center"> Purpose (غاية)</th>
                                        <th width="11%" class="text-center"> Action (فعل)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.expense.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title">Add Expense</h4>
                                    <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <label for="">Select Branch</label>
                                    <select name="branch_id" id="" class="form-control">
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <label for="">Select Expense Head (حدد رأس النفقات)</label>
                                    <select name="expense_head_id" id="" class="form-control">
                                        <option value="">Select Expense Head</option>
                                        @foreach ($expenseHeads as $expenseHead)
                                            <option value="{{ $expenseHead->id }}">{{ $expenseHead->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('expense_head_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    {{-- <label for="">Expense Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="2"></textarea>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror --}}
                                    <label for="">Expense Id (معرف النفقات)</label>
                                    <input type="text" name="expense_id" id="" class="form-control"
                                        placeholder="Expense ID (معرف النفقات)" value="{{ old('expense_id') }}">
                                    @error('expense_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <label for="">Date (تاريخ)</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <label for="">Amount(كمية)</label>
                                    <input type="text" name="amount" id="" class="form-control"
                                        placeholder="Expense Amount" value="{{ old('amount') }}">
                                    @error('amount')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <label for="">Purpose(غاية)</label>
                                    <input type="text" name="comment" id="" class="form-control"
                                        placeholder="Purpose" value="{{ old('comment') }}">
                                    @error('comment')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger float-right"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success float-right">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="showEditResult">

    </div>
@endsection
@push('script_js')
    <script>
        window.onload = function() {
            load_data();

            function load_data(from_date = '', to_date = '', branch_name = '') {
                var table = $('#yajraDatatable').DataTable({
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    // stateSave: true,
                    processing: true,
                    serverSide: true,
                 
                    ajax: {
                            url: '{!! route('admin.expense.getList') !!}',
                            data: {
                                from_date: from_date,
                                to_date: to_date,
                                branch_name: branch_name,
                            }
                        },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            class: "text-center"
                        },
                        {
                            data: 'date',
                            name: 'date',
                            orderable: false,
                            class: "text-center"
                        },
                        {
                            data: 'expense_head_name',
                            name: 'expense_head_name',
                            class: "text-center"
                        },
                        {
                            data: 'branch_name',
                            name: 'branch_name',
                            class: "text-center"
                        },
                        {
                            data: 'expense_head_id',
                            name: 'expense_head_id',
                            class: "text-center"
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            class: "text-center"
                        },
                        {
                            data: 'comment',
                            name: 'comment',
                            class: "text-center"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            class: "text-center"
                        }
                    ]
                });
            }
            // var table = $('#yajraDatatable').DataTable({
            //         function load_data(from_date = '', to_date = '', branch_id = '') {
            //             language: {
            //                 processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            //             },
            //             processing: true,
            //             serverSide: true,
            //             ajax: {
            //                 url: '{!! route('admin.expense.getList') !!}',
            //                 data: {
            //                     from_date: from_date,
            //                     to_date: to_date,
            //                     branch_id: branch_id,
            //                 }
            //             },
            //             columns: [{
            //                     data: 'DT_RowIndex',
            //                     orderable: false,
            //                     searchable: false,
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'date',
            //                     name: 'date',
            //                     orderable: false,
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'expense_head_name',
            //                     name: 'expense_head_name',
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'branch_name',
            //                     name: 'branch_name',
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'expense_head_id',
            //                     name: 'expense_head_id',
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'amount',
            //                     name: 'amount',
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'comment',
            //                     name: 'comment',
            //                     class: "text-center"
            //                 },
            //                 {
            //                     data: 'action',
            //                     name: 'action',
            //                     orderable: false,
            //                     class: "text-center"
            //                 }
            //             ]
            //         });
            // }
            $('#filter').click(function() {

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var branch_name = $('#branch_name').val();
                // console.log(from_date,to_date,branch_id);
                // if (from_date && to_date && branch_name) {
                    
                // } else {
                //     alert('Please Give From Date And To Date Data!');
                // }


                $('#yajraDatatable').DataTable().destroy();
                    load_data(from_date, to_date, branch_name);

            });

            $('#yajraDatatable').on('click', '.edit-modal', function() {
                var expense_id = $(this).attr('expense_id');
                var url = "{{ route('admin.expense.edit', ':expense_id') }}";
                url = url.replace(':expense_id', expense_id);
                console.log(url);
                $('#showEditResult').html('');
                if (expense_id.length != 0) {
                    $.ajax({
                        cache: false,
                        type: "GET",
                        error: function(xhr) {
                            console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                        },
                        url: url,
                        success: function(response) {
                            console.log(response)
                            $('#showEditResult').html(response);
                            $('#editModal').modal('show');
                            $('#close_btn').on("click", function() {
                                $('#editModal').modal('hide');
                            });
                        },
                    })
                }
            });

            $(document).ready(function() {
                $('#printButton').on('click', function() {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var url = "{{ route('admin.expense.print') }}";
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            from_date: from_date,
                            to_date: to_date
                        },
                        success: function(response) {
                            if (response.html) {
                                // Create a hidden iframe or div to hold the print content
                                var printWindow = window.open("", "_blank");
                                printWindow.document.write(response.html);
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                                printWindow.close();
                            } else {
                                alert('No data found for the given date range.');
                            }

                        },
                        error: function(xhr) {
                            alert("An error occurred: " + xhr.status + " " + xhr
                            .statusText);
                        }
                    });

                })
            })
        }
    </script>
@endpush
