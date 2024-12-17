<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table-bordered {
            border: 1px solid black;
        }

        .table-bordered th {
            border: 1px solid black;
        }

        .table-bordered td {
            border: 1px solid black;
        }
    </style>

</head>

<body>

    @php
        $balance = 0;
        $totalDebit = 0;
        $totalCrebit = 0;
    @endphp
    @if (isset($ledgerEntries))
        <div class="p-2">
            <h3>{{ $application->name }}</h3>
            <p style="font-size: 15px; font-weight: bold">C.R {{ $application->cr_no }}</p>
            <p style="font-size: 15px; font-weight: bold">VAT NO: {{ $application->vat_number }}</p>
            <p style="font-size: 15px; font-weight: bold">Ledger Report From
                {{ \Carbon\Carbon::parse(request('fromDate'))->format('d-m-Y') }} To
                {{ \Carbon\Carbon::parse(request('toDate'))->format('d-m-Y') }} Ledger Code : N/A Name : @foreach ($customers as $customer)
                    {{ request('customer_id') == $customer->id ? $customer->name : '' }}
                @endforeach
            </p>
        </div>
        <table class="table table-bordered">
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
                        <td class="text-center">{{ date('d-m-Y', strtotime($entry['date'])) }}</td>
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
                    <th colspan="3">Total</th>
                    <th class="text-center">{{ $totalDebit }}</th>
                    <th class="text-center">{{ $totalCrebit }}</th>
                    <th class="text-center">{{ $balance }}</th>
                </tr>

            </tbody>
        </table>
    @endif

</body>

</html>
