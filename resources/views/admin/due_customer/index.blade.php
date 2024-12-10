
@extends('layouts.admin_layout.admin_layout')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Customers Due-List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Customer Due-List</li>
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
                    
                    <div class="card-body">
                        <table id="yajraDatatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"> SL </th>
                                    <th width="20%" class="text-center"> Name </th>
                                    <th width="10%" class="text-center"> Phone </th>
                                    <th width="10%" class="text-center"> Due Amount </th>
                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

@push('script_js')
<script>
    $(document).ready(function() {
        $('#yajraDatatable').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            ajax: '{{ route('admin.due-customer.getdata') }}',
            columns: [{
                    data: null, // Use null to signify that this column does not map directly to any data source
                    name: 'serial_number',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +
                            1; // Calculate the serial number
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    class : "text-center"
                },
                {
                    data: 'phone',
                    name: 'phone',
                    class : "text-center"
                },
                {
                    data: 'due_payment',
                    name: 'due_payment',
                    class : "text-center"
                }
            ]
        });
    });
</script>
@endpush

