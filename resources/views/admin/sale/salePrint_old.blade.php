@php

    $QRCodeMessage = "
        Company Name : $application->name,
        Address : $application->address,
        Mob : $application->contact_number,
        Date : $sale->date,
    ";


@endphp
<html>
    <head>
        <title>{{ isset($page_title) ?  $page_title."  " : ''}}</title>
        <link rel="icon" type="image/png" href="{{ asset('uploads/application/') . '/' . session()->get('company_photo') }}">
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin_css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin_css/style.css') }}">
        @stack('style_css')
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <script type="text/javascript">
            function printPage(divName) {
                var printContents       = document.getElementById(divName).innerHTML;
                var originalContents    = document.body.innerHTML;
                document.body.innerHTML = printContents;
                // document.body.style.marginTop="-45px";

                var button = document.getElementById('print');
               // button.style.display = 'none'; //or
                //button.style.visibility = 'hidden';
                window.print();
                document.body.innerHTML = originalContents;
                @if ($type)
                    window.close();
                @else
                    window.location.href = '{{ $previous_route }}';
                @endif
            }

            function cancelPage() {
                @if ($type)
                    window.close();
                @else
                    window.location.href = '{{ $previous_route }}';
                @endif
            }
        </script>

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

            .col-print-1 {width:8%;  float:left;}
            .col-print-2 {width:16%; float:left;}
            .col-print-3 {width:25%; float:left;}
            .col-print-4 {width:33%; float:left;}
            .col-print-5 {width:42%; float:left;}
            .col-print-6 {width:50%; float:left;}
            .col-print-7 {width:58%; float:left;}
            .col-print-8 {width:66%; float:left;}
            .col-print-9 {width:75%; float:left;}
            .col-print-10{width:83%; float:left;}
            .col-print-11{width:92%; float:left;}
            .col-print-12{width:100%; float:left;}

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
                border: 2px solid black;
            }
            .tables thead,  .tables thead th, .tables thead td, .table-bordered td, .table-bordered th{
                border: 1px solid black;
            }


        </style>

    </head>

    <body>

        <div id="print" class="row" style="padding-bottom: 30px; margin-bottom: 30px;">
            <div class="col-md-12">
                <span class="float-right">
                    <button class="btn btn-sm btn-info" onclick="printPage('printArea')">Print</button>
                    <button class="btn btn-sm btn-danger" onclick="cancelPage()">Cancel</button>
                </span>
            </div>
        </div>

        <div id="printArea">
            <div class="row">
                <div class="col-md-12 text-center" style="margin-bottom: 30px">
                    @if ($application->photo)
                        <img src="{{ $application->photo_path }}" style="height:60px; width:100%;">
                    @endif

                    <b><?php echo $application->address; ?></b> <br>
                    Mob :   <b><?php echo $application->contact_number;  ?></b><br>

                </div>
                @if ($sale->customer)
                    <div class="col-md-12 text-center" style="margin-bottom: 30px">
                        <b> Customer: <?php echo $sale->customer->name; ?></b> <br>
                    </div>
                @endif


                <div class="col-md-12" style="padding-left: 20px; padding-right: 30px;">
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
                                @if ($sale->sale_details)
                                    @foreach ($sale->sale_details as $sale_detail)
                                        <tr>
                                            <td >
                                                {{ number_format($sale_detail->amount,2) }}
                                            </td>
                                            <td >
                                                {{ number_format($sale_detail->price,2) }}
                                            </td>
                                            <td >
                                                {{ floatval($sale_detail->quantity) }}
                                            </td>
                                            <td >
                                                @if($sale_detail->item && $sale_detail->item->name)
                                                    {{ $sale_detail->item->name }}
                                                @else
                                                    {{ $sale_detail->item_name }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="col-print-6">
                            <table class="table table-style table-bordered" style="margin-top: 10px; text-align:center;">
                                <tbody>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($sale->grand_amount,2) }}</th>
                                        <th style="width: 50%;">Grand Amount  </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($sale->discount_amount,2) }}</th>
                                        <th style="width: 50%;">Discount Amount</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($sale->tax_amount,2) }}</th>
                                        <th style="width: 50%;">TAX Amount</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%;">{{ number_format($sale->final_amount,2) }}</th>
                                        <th style="width: 50%;">Final Amount </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-print-6">
                            <span>
                                <img src="data:image/png; base64,{{ \DNS2D::getBarcodePNG($QRCodeMessage, 'QRCODE') }}"
                                alt="barcode" style="height:100px; width:100px;"/>
                            </span>
                        </div>
                    </div>
                    <div class="row text-center text-bold" style="border-bottom: 2px solid black; margin-top:30px">
                        <div class="col-print-6">
                            {{ $sale->created_admin->phone }}
                        </div>
                        <div class="col-print-6">
                            {{ $sale->created_admin->username }}
                        </div>
                    </div>
                    <div class="col-print-12 text-center">
                        {{ date('Y-m-d H:i a', strtotime($sale->created_at)) }}
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
