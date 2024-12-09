@php

    $QRCodeMessage = "
        Company Name    : $application->name,
        Address         : $application->address,
        Mob             : $application->contact_number,
    ";
@endphp
<html>
    <head>
        <title> Print Preview </title>
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/admin_css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin_css/style.css') }}">
        @stack('style_css')
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


        <style>

            *{
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
                color-adjust: exact !important;                 /*Firefox*/
            }

            @media print {
                * {
                    -webkit-print-color-adjust: exact;
                }
            }

            .water_mark {
                position: relative;
            }

            .water_mark::before{
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                opacity: 0.15;
                background-repeat: no-repeat;
                background-position: center;
                background-size: 40% 100px;
            }

            @media print {
                *{
                    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
                    color-adjust: exact !important;                 /*Firefox*/
                }
                .water_mark {
                    position: relative;
                }

                .water_mark::before{
                    z-index: 999;
                    position: absolute;
                    left: 0;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    opacity: 0.15;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: 40% 100px;
                }
            }

            .tables{
                border: 2px solid black !important;
            }
            .tables thead,  .tables thead th, .tables thead td, .table-bordered td, .table-bordered th{
                border: 2px solid black !important;
            }
            .printArea{
                padding:10px;
                margin-left:10px;
                margin-right:10px;
            }

        </style>

    <script>
        window.print();
        window.onafterprint = function(event) {
            // window.close();
        };
    </script>
    </head>

    <body>
        <div id="printArea">
            <div class="row">
                <div class="col-md-12 text-center" style="margin-bottom: 30px">
                    @if ($application->photo)
                        <img src="{{ $application->photo_path }}" style="height:60px; width:100%;">
                    @endif

                    <b> <?php echo $application->address; ?> </b> <br>
                    Mob :  <b> <?php echo $application->contact_number;  ?> </b><br>
                </div>

                <div class="col-md-12" style="padding-left: 20px; padding-right: 30px; ">
                    <div class="row">
                        <table class="table table-style  table-bordered tables" style="margin-top: 10px; text-align:center; ">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Amount </th>
                                    <th style="width: 20%;">Price  </th>
                                    <th style="width: 20%;">Quantity</th>
                                    <th style="width: 40%;">Item </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tax_amount = 0;
                                @endphp
                                @foreach ($cart as $item)
                                    @if ($item->name != 'other_item')
                                        @php
                                            $tax_amount += ($item->price / 100  * 15) * $item->quantity;
                                        @endphp
                                        <tr>
                                            <td class="text-center"> {{ $item->getPriceSum() }} </td>
                                            <td class="text-center"> {{ $item->price }}</td>
                                            <td class="text-center"> {{ $item->quantity }}</td>
                                            <td class="text-center"> {{ $item->name }}</td>
                                        </tr>
                                    @else
                                        @php
                                            if($item->price != 0){
                                                $tax_amount += ($item->price / 100  * 15) * $item->quantity;
                                            }
                                        @endphp
                                        <tr>
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
                        </table>

                        <div class="col-sm-6">
                            <table class="table table-style table-bordered" style="margin-top: 10px; text-align:center;">
                                <tbody>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($subtotal_amount,2) }}</th>
                                        <th style="width: 50%;">Grand Amount  </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($discount_amount,2) }}</th>
                                        <th style="width: 50%;">Discount Amount</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($tax_amount,2) }}</th>
                                        <th style="width: 50%;">TAX Amount</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($total_amount,2) }}</th>
                                        <th style="width: 50%;">Final Amount </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <span>
                                <img src="data:image/png; base64,{{ \DNS2D::getBarcodePNG($QRCodeMessage, 'QRCODE') }}"
                                alt="barcode" style="height:100px; width:100px;"/>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        {{ date('Y-m-d H:i a') }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<style>
    .table-style td, .table-style th {
        padding: .1rem !important;
    }
</style>
