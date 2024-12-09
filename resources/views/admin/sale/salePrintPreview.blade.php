<html>
    <head>
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
                <form action="{{ route('admin.sale.printPreviewPrint') }}"
                method="POST" enctype="multipart/form-data" target="_blank">
                    @csrf
                    <input type="hidden" value="{{ $subtotal_amount }}" name="subtotal_amount">
                    <input type="hidden" value="{{ $total_item }}" name="total_item">
                    <input type="hidden" value="{{ $discount_amount }}" name="discount_amount">
                    <input type="hidden" value="{{ $total_tax_amount }}" name="total_tax_amount">
                    <input type="hidden" value="{{ $total_amount }}" name="total_amount">

                    <span class="float-right">
                        <button class="btn btn-sm btn-info" type="submit" >
                            {{ __('message.print') }}
                        </button>
                    </span>
                </form>
            </div>
        </div>

        <div id="printArea">
            <div class="row">
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
            </div>
        </div>
    </body>
</html>

<style>
    .table-style td, .table-style th {
        padding: .1rem !important;
    }
</style>
