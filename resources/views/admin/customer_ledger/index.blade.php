@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('message.customer_ledger') }} ({{ __('message.customer_ledger', [], $secondary_locale) }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('message.customer_ledger') }} ({{ __('message.customer_ledger', [], $secondary_locale) }})</li>
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
                            <h3 class="card-title"> {{ __('message.sale_list') }} ({{ __('message.sale_list', [], $secondary_locale) }}) </h3>
                            <form action="{{ route('admin.customer.ledger') }}" method="GET" class="mb-4"
                                id="filterForm">
                                <div class="row input-daterange" style="margin-top: 40px">
                                    <div class="col-md-3">
                                        <label for="customer_id">{{ __('message.customer') }}  ({{ __('message.customer', [], $secondary_locale) }})</label>
                                        <select id="customer_id" class="form-control select2" name="customer_id"
                                            data-placeholder="Select a Customer" data-tags="true" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->phone }} - {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="to_date">{{ __('message.date') }}  ({{ __('message.date', [], $secondary_locale) }})</label>
                                        <div class="input-group">
                                            <input type="date" id="from_date" name="fromDate" class="form-control"
                                                value="{{ request('fromDate', now()->startOfMonth()->format('Y-m-d')) }}" />
                                            <input type="date" id="toDate" name="toDate" class="form-control"
                                                value="{{ request('toDate', now()->format('Y-m-d')) }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-2" style="margin-top: 20px">
                                        <button type="submit" name="filter" id="filter" class="btn btn-success">
                                            <i class="fas fa-search-plus"></i>
                                        </button>

                                        @if (request('customer_id') && request('fromDate') && request('toDate'))
                                            <a href="{{ route('admin.customer.ledger.excel', ['customer_id' => request('customer_id'), 'fromDate' => request('fromDate'), 'toDate' => request('toDate')]) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-file-excel"
                                                    style="font-size: 20px;"></i></a>

                                            <a href="{{ route('admin.customer.ledger.pdf', ['customer_id' => request('customer_id'), 'fromDate' => request('fromDate'), 'toDate' => request('toDate')]) }}"
                                                class="btn btn-sm btn-success">
                                                <svg height="24px" width="24px" version="1.1" id="_x32_"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                                    xml:space="preserve" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <style type="text/css">
                                                            .st0 {
                                                                fill: #ffffff;
                                                            }
                                                        </style>
                                                        <g>
                                                            <path class="st0"
                                                                d="M347.746,346.204c-8.398-0.505-28.589,0.691-48.81,4.533c-11.697-11.839-21.826-26.753-29.34-39.053 c24.078-69.232,8.829-88.91-11.697-88.91c-16.119,0-24.167,17.011-22.376,35.805c0.906,9.461,8.918,29.34,18.78,48.223 c-6.05,15.912-16.847,42.806-27.564,62.269c-12.545,3.812-23.305,8.048-31.027,11.622c-38.465,17.888-41.556,41.773-33.552,51.894 c15.197,19.226,47.576,2.638,80.066-55.468c22.243-6.325,51.508-14.752,54.146-14.752c0.304,0,0.721,0.097,1.204,0.253 c16.215,14.298,35.366,30.67,51.128,32.825c22.808,3.136,35.791-13.406,34.891-23.692 C382.703,361.461,376.691,347.942,347.746,346.204z M203.761,408.88c-9.401,11.178-24.606,21.9-29.972,18.334 c-5.373-3.574-6.265-13.86,5.819-25.497c12.076-11.623,32.29-17.657,35.329-18.787c3.59-1.337,4.482,0,4.482,1.791 C219.419,386.512,213.154,397.689,203.761,408.88z M244.923,258.571c-0.899-11.192,1.33-21.922,10.731-23.26 c9.386-1.352,13.868,9.386,10.292,26.828c-3.582,17.464-5.38,29.08-7.164,30.44c-1.79,1.338-3.567-3.144-3.567-3.144 C251.627,282.27,245.815,269.748,244.923,258.571z M248.505,363.697c4.912-8.064,17.442-40.702,17.442-40.702 c2.683,4.926,23.699,29.956,23.699,29.956S257.438,360.123,248.505,363.697z M345.999,377.995 c-13.414-1.768-36.221-17.895-36.221-17.895c-3.128-1.337,24.992-5.157,35.79-4.466c13.875,0.9,18.794,6.718,18.794,12.53 C364.362,373.982,359.443,379.787,345.999,377.995z">
                                                            </path>
                                                            <path class="st0"
                                                                d="M461.336,107.66l-98.34-98.348L353.683,0H340.5H139.946C92.593,0,54.069,38.532,54.069,85.901v6.57H41.353 v102.733h12.716v230.904c0,47.361,38.525,85.893,85.878,85.893h244.808c47.368,0,85.893-38.532,85.893-85.893V130.155v-13.176 L461.336,107.66z M384.754,480.193H139.946c-29.875,0-54.086-24.212-54.086-54.086V195.203h157.31V92.47H85.86v-6.57 c0-29.882,24.211-54.102,54.086-54.102H332.89v60.894c0,24.888,20.191,45.065,45.079,45.065h60.886v288.349 C438.855,455.982,414.636,480.193,384.754,480.193z M88.09,166.086v-47.554c0-0.839,0.683-1.524,1.524-1.524h15.108 c2.49,0,4.786,0.409,6.837,1.212c2.029,0.795,3.812,1.91,5.299,3.322c1.501,1.419,2.653,3.144,3.433,5.121 c0.78,1.939,1.182,4.058,1.182,6.294c0,2.282-0.402,4.414-1.19,6.332c-0.78,1.918-1.932,3.619-3.418,5.054 c-1.479,1.427-3.27,2.549-5.321,3.329c-2.036,0.78-4.332,1.174-6.822,1.174h-6.376v17.241c0,0.84-0.683,1.523-1.523,1.523h-7.208 C88.773,167.61,88.09,166.926,88.09,166.086z M134.685,166.086v-47.554c0-0.839,0.684-1.524,1.524-1.524h16.698 c3.173,0,5.968,0.528,8.324,1.568c2.386,1.062,4.518,2.75,6.347,5.009c0.944,1.189,1.694,2.504,2.236,3.916 c0.528,1.375,0.929,2.862,1.189,4.407c0.253,1.531,0.401,3.181,0.453,4.957c0.045,1.694,0.067,3.515,0.067,5.447 c0,1.924-0.022,3.746-0.067,5.44c-0.052,1.769-0.2,3.426-0.453,4.964c-0.26,1.546-0.661,3.025-1.189,4.399 c-0.55,1.427-1.3,2.743-2.23,3.909c-1.842,2.282-3.976,3.969-6.354,5.016c-2.334,1.04-5.135,1.568-8.324,1.568h-16.698 C135.368,167.61,134.685,166.926,134.685,166.086z M214.269,137.981c0.84,0,1.523,0.684,1.523,1.524v6.48 c0,0.84-0.683,1.524-1.523,1.524h-18.244v18.579c0,0.84-0.684,1.523-1.524,1.523h-7.209c-0.84,0-1.523-0.683-1.523-1.523v-47.554 c0-0.839,0.683-1.524,1.523-1.524h27.653c0.839,0,1.524,0.684,1.524,1.524v6.48c0,0.84-0.684,1.524-1.524,1.524h-18.92v11.444 H214.269z">
                                                            </path>
                                                            <path class="st0"
                                                                d="M109.418,137.706c1.212-1.092,1.798-2.645,1.798-4.749c0-2.096-0.587-3.649-1.798-4.741 c-1.263-1.13-2.928-1.68-5.098-1.68h-5.975v12.848h5.975C106.489,139.385,108.155,138.836,109.418,137.706z">
                                                            </path>
                                                            <path class="st0"
                                                                d="M156.139,157.481c1.13-0.424,2.103-1.107,2.973-2.088c0.944-1.055,1.538-2.571,1.769-4.511 c0.26-2.208,0.386-5.091,0.386-8.569c0-3.485-0.126-6.369-0.386-8.569c-0.231-1.946-0.825-3.462-1.762-4.51 c-0.869-0.982-1.873-1.679-2.972-2.089c-1.182-0.453-2.534-0.676-4.042-0.676h-7.164v31.68h7.164 C153.605,158.15,154.965,157.927,156.139,157.481z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>

                                            <a href="{{ route('admin.customer.ledger.print', ['customer_id' => request('customer_id'), 'fromDate' => request('fromDate'), 'toDate' => request('toDate')]) }}"
                                                class="btn btn-info"><i class="fas fa-print"
                                                    style="font-size: 20px;"></i></a>
                                        @endif


                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            @php
                                $balance = 0;
                                $totalDebit = 0;
                                $totalCrebit = 0;
                            @endphp
                            @if (isset($ledgerEntries))
                                <div class="p-2">
                                    <h3>{{ $application->name }}</h3>
                                    <h5>{{ $application->arabic_name }}</h5>
                                    <h5>C.R {{ $application->cr_no }}</h5>
                                    <h5>VAT NO: {{ $application->vat_number }}</h5>
                                    <p style="font-size: 18px; font-weight: bold">Ledger Report From
                                        {{ \Carbon\Carbon::parse(request('fromDate'))->format('d-m-Y') }} To
                                        {{ \Carbon\Carbon::parse(request('toDate'))->format('d-m-Y') }} Ledger Code : N/A
                                        Name : @foreach ($customers as $customer)
                                            {{ request('customer_id') == $customer->id ? $customer->name : '' }}
                                        @endforeach
                                    </p>
                                </div>
                                <table id="yajraDatatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="20%" class="text-center"> Date </th>
                                            <th width="10%" class="text-center"> VNo </th>
                                            <th width="10%" class="text-center"> Particulars </th>
                                            <th width="10%" class="text-center"> Debit Amt </th>
                                            <th width="10%" class="text-center"> Credit Amt </th>
                                            <th width="10%" class="text-center"> Balance </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $balance += $setOpeningAmount;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($fromDate)) }}</td>
                                            <td></td>
                                            <td class="text-center">Opening Balance</td>
                                            <td class="text-center">{{ number_format($setOpeningAmount) }}</td>
                                            <td></td>
                                            <td class="text-center">{{ number_format($balance) }}</td>

                                            @php
                                                $totalDebit += $setOpeningAmount;
                                            @endphp
                                        </tr>

                                        {{-- <p>{{$totalBalance}}</p> --}}
                                        @foreach ($ledgerEntries as $entry)
                                            @php
                                                if ($entry['type'] == 'sale') {
                                                    $balance += $entry['debit'];
                                                } elseif ($entry['type'] == 'payment') {
                                                    $balance -= $entry['credit'];
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ date('d-m-Y', strtotime($entry['date'])) }}
                                                </td>
                                                <td class="text-center">{{ $entry['v_no'] }}</td>
                                                <td class="text-center">
                                                    @if ($entry['type'] == 'sale')
                                                        <p>Sales Account</p>
                                                    @elseif ($entry['type'] == 'payment')
                                                        <p>Cash Account</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ number_format($entry['debit']) }}</td>
                                                <td class="text-center">{{ number_format($entry['credit']) }}</td>
                                                <td class="text-center">{{ number_format($balance) }}</td>

                                                @php
                                                    $totalDebit += $entry['debit'];
                                                    $totalCrebit += $entry['credit'];
                                                @endphp
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="3" class="text-center">Total</th>
                                            <th class="text-center">{{ $totalDebit }}</th>
                                            <th class="text-center">{{ $totalCrebit }}</th>
                                            <th class="text-center">{{ $balance }}</th>
                                        </tr>

                                    </tbody>
                                </table>
                            @endif
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
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            const customerId = document.getElementById('customer_id').value;
            const fromDate = document.getElementById('from_date').value;
            const toDate = document.getElementById('toDate').value;

            if (!customerId || !fromDate || !toDate) {
                e.preventDefault(); // Prevent form submission
                alert('Please select a customer, a start date, and an end date.');
            }
        });
    </script>
@endpush
