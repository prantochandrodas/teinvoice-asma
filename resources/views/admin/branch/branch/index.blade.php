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
                        <li class="breadcrumb-item active">Branch</li>
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
                            <h3 class="card-title"> Branch List </h3>
                            @if (auth_admin_user_permission('supplier.create'))
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success float-right">
                                    <i class="fa fa-pencil-alt"></i> Add Branch 
                                </button>
                            @endif
                            {{-- <div class="col-sm-5" style="display: flex;margin-left:400px">

                                <div class="input-group" style="gap:5px">
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
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <table id="yajraDatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%" class="text-center"> SL</th>
                                        <th width="7%" class="text-center">Branch Name </th>
                                        <th width="10%" class="text-center">Branch Name  Arabic </th>
                                        <th width="10%" class="text-center"> Email </th>
                                        <th width="10%" class="text-center"> Contact Number </th>
                                        {{-- <th width="10%" class="text-center"> Description</th> --}}
                                        <th width="10%" class="text-center"> Address </th>
                                        <th width="11%" class="text-center"> Vat Number</th>
                                        <th width="11%" class="text-center"> CR NO</th>
                                        <th width="11%" class="text-center"> Action</th>
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
                        <form action="{{ route('admin.branches.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title">Add Branch</h4>
                                    <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="">Branch Name</label>
                                    <input type="text" name="name" id="" class="form-control"
                                    placeholder="Branch Name" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="">Branch Name Arabic</label>
                                    <input type="text" name="arabic_name" id="" class="form-control"
                                    placeholder="Branch Name Arabic" value="{{ old('arabic_name') }}">
                                    @error('arabic_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="">Contact Number</label>
                                    <input type="number" name="contact_number" id="" class="form-control"
                                    placeholder="Contact Number" value="{{ old('contact_number') }}">
                                    @error('contact_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="">Email</label>
                                    <input type="email" name="email" id="" class="form-control"
                                    placeholder="Email" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="">Vat Number</label>
                                    <input type="number" name="vat_number" id="" class="form-control"
                                    placeholder="Contact Number" value="{{ old('vat_number') }}">
                                    @error('vat_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <label for="">CR Number</label>
                                    <input type="number" name="cr_no" id="" class="form-control"
                                    placeholder="Contact Number" value="{{ old('cr_no') }}">
                                    @error('cr_no')
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

            function load_data(from_date = '', to_date = '') {
                var table = $('#yajraDatatable').DataTable({
            
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    processing: true,
                    serverSide: true,
                    
                    ajax: {
                        url: '{!! route('admin.branches.getdata') !!}',
                    
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            class: "text-center"
                        },
                        {
                            data: 'name',
                            name: 'name',
                            class: "text-center"
                        },
                        {
                            data: 'arabic_name',
                            name: 'arabic_name',
                            class: "text-center"
                        },
                        {
                            data: 'contact_number',
                            name: 'contact_number',
                            class: "text-center"
                        },
                        {
                            data: 'email',
                            name: 'email',
                            class: "text-center"
                        },
                        {
                            data: 'address',
                            name: 'address',
                            class: "text-center"
                        },
                        {
                            data: 'vat_number',
                            name: 'vat_number',
                            class: "text-center"
                        },
                        {
                            data: 'cr_no',
                            name: 'cr_no',
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
            $('#filter').click(function() {

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date && to_date) {
                    $('#yajraDatatable').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Please Give From Date And To Date Data!');
                }


            });

           

            $('#yajraDatatable').on('click', '.edit-modal', function() {
                var expense_id = $(this).attr('expense_id');
                var url = "{{ route('admin.branches.edit', ':expense_id') }}";
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
                            $('#close_btn').on("click",function(){
                                $('#editModal').modal('hide');
                            });
                        },
                    })
                }
            });

          
            $(document).ready(function() {
               
            })
        }
    </script>
@endpush

