<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link href='https://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=IBM Plex Mono' rel='stylesheet'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            table>tbody>tr>td, table>tbody>tr>th, table>tfoot>tr>td, table>tfoot>tr>th, table>thead>tr>td, table>thead>tr>th {
                text-align: center;
            }
            .bold_text{
                /* font-size: 20px !important; */
            }
            .tables{
                border: 2px solid black;
            }
            .tables thead,  .tables thead th, .tables thead td, .table-bordered td, .table-bordered th{
                border: 1px solid black;
            }
        </style>
    </head>

    <script>
        window.print();
        window.onafterprint = function(event) {
            window.close();
        };
    </script>

    <body>
        <table width="100%" style="margin-top: -2rm">
            <thead>
                <tr>
                    <td colspan="6" class="text-center text-bold">

                        <b> SL No: {{ $sale->id }}</b><br>
                            <b> <h1>{{ $application->arabic_name }}<br></h1></b>
                            <b> <h3> {{ $application->name }}</h3></b>
                            <b> {{ $application->address }} </b> <br>
                            <b> {{ __('message.mobile') }} : {{ $application->contact_number }}</b><br>
                            <b> Bill No: {{ $sale->bill_no }}</b><br>
                            <b> Vat: {{ $application->vat_number }}</b><br>
							<b>Date & Time: {{date('d-m-Y')}}  {{date('H:i:sa')}} </b><br>
                            <br>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr style="border: solid 2px black;">
                    <th style="width: 20%;" class="text-center">{{ __('message.amount') }}  </th>
                    <th style="width: 20%;" class="text-center">{{ __('message.price') }}   </th>
                    <th style="width: 10%;" class="text-center">{{ __('message.quantity') }} </th>
                    <th style="width: 50%;" class="text-center">{{ __('message.item') }}  </th>
                </tr>
                @foreach ($cart as $item)
                    @if ($item->name != 'other_item')
                        <tr style="border-bottom: solid 2px black">
                            <td class="text-center"> {{ $item->getPriceSum() }} </td>
                            <td class="text-center"> {{ $item->price }}</td>
                            <td class="text-center"> {{ $item->quantity }}</td>
                            <td class="text-center"> {{ $item->name }}</td>
                        </tr>
                    @else
                        <tr style="border-bottom: solid 2px black">
                            <td class="text-center"> {{ $item->getPriceSum() }} </td>
                            <td class="text-center">
                                {{ $item->price }}
                            </td>
                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-center">
                                {{ $item->attributes->name }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">
                        <table  style="width: 100%" >
                            <tbody>
                                <tr style="border-bottom: solid 2px black">
                                    <th style="width: 50%; text-align:left">{{ number_format($subtotal_amount,2) }}</th>
                                    <th style="width: 50%; text-align:right">{{ __('message.grand') }}    </th>
                                </tr>
                                <tr style="border-bottom: solid 2px black">
                                    <th style="width: 50%; text-align:left">{{ number_format($discount_amount,2) }}</th>
                                    <th style="width: 50%; text-align:right">{{ __('message.discount') }}  </th>
                                </tr>
                                <tr style="border-bottom: solid 2px black">
                                    <th style="width: 50%; text-align:left">{{ number_format($total_tax_amount,2) }}</th>
                                    <th style="width: 50%; text-align:right">{{ __('message.tax') }}  </th>
                                </tr>
                                <tr style="border-bottom: solid 2px black">
                                    <th style="width: 50%; text-align:left">{{ number_format($total_amount,2) }}</th>
                                    <th style="width: 50%; text-align:right">{{ __('message.final') }}   </th>
                                </tr>
                            </tbody>
                        </table>
                    </th>
                    <th>
                        <div style="margin-top: 30px; margin-left: 15px;" >
                            <img src="{{ $generatedString }}"
                            alt="barcode" style="height:100px; width:100px;"/>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td colspan="5" class="text-center">
                        {{-- <br>
                        <b>Thanks For Visiting {{ $application->name }} <br/>
                        Developed By STITBD.com </b> --}}
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>


