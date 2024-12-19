@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('message.customer_due_list') }}
                        ({{ __('message.customer_due_list', [], $secondary_locale) }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }}
                                ({{ __('message.home', [], $secondary_locale) }})</a></li>
                        <li class="breadcrumb-item active">{{ __('message.customer_due_list') }}
                            ({{ __('message.customer_due_list', [], $secondary_locale) }})</li>
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
                                        <th width="5%" class="text-center"> {{ __('message.serial') }}
                                            ({{ __('message.serial', [], $secondary_locale) }}) </th>
                                        <th width="20%" class="text-center"> {{ __('message.name') }}
                                            ({{ __('message.name', [], $secondary_locale) }}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.phone') }}
                                            ({{ __('message.phone', [], $secondary_locale) }}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.due_amount') }}
                                            ({{ __('message.due_amount', [], $secondary_locale) }}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.action') }}
                                            ({{ __('message.action', [], $secondary_locale) }}) </th>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewDetailsModal">
      <div class="modal-dialog modal-lg" style="max-width: 1200px!important">
        <div class="modal-content">
          <div class="modal-header bg-primary">
              <h4 class="modal-title">
                {{ __('message.customer_due_details') }}
                ({{ __('message.customer_due_details', [], $secondary_locale) }})
              </h4>
            <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="showResult">

          </div>
          <div class="modal-footer">
              <button  type="button" class="btn btn-danger float-right" data-dismiss="modal">
                  {{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})
              </button>
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
                        class: "text-center"
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        class: "text-center"
                    },
                    {
                        data: 'due_payment',
                        name: 'due_payment',
                        class: "text-center"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        class: "text-center"
                    }
                ]
            });

            $('#yajraDatatable').on('click', '.view-details', function() {
                var purchase_id = $(this).attr('purchase_id');
                var url = "{{ route('admin.due-customer.details', ':purchase_id') }}";
                url = url.replace(':purchase_id', purchase_id);
                $('#showResult').html('');
                if (purchase_id.length != 0) {
                    $.ajax({
                        cache: false,
                        type: "GET",
                        error: function(xhr) {
                            alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                        },
                        url: url,
                        success: function(response) {
                            $('#showResult').html(response);
                        },
                    })
                }
            });
        });
    </script>
@endpush
