<!DOCTYPE html>
<html>
    <head>
        <title>Sales Print Page </title>
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
	<script type="text/javascript">



        @if ( $type && $type == 2)
            window.print();
            window.onafterprint = function(){
                window.location.href = '{{ $previous_route }}';
            }
        @else
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
        @endif

    </script>

    <body>
        @if (!$type || ($type && $type != 2) )
            <div id="print" class="row" style="padding-bottom: 30px; margin-bottom: 30px;">
                <div class="col-md-12">
                    <span style="float:right">
                        <button class="btn btn-sm btn-info" id="printBtn" onclick="printPage('printArea')">Print</button>
                        <button class="btn btn-sm btn-danger" onclick="cancelPage()">Cancel</button>
                    </span>
                </div>
            </div>
        @endif

        <div id="printArea">
            <table width="100%" style="width: 90%; margin-left:4%; margin-right:5%" >
                <thead>
                    <tr>
                        <td colspan="6" class="text-center text-bold">
                        <b> SL No: {{ $sale->id }}</b><br>
                           <b>  <h1>{{ $application->arabic_name }}<br></h1></b>
                            <b> <h3> {{ $application->name }}</h3></b>
                            <b> {{ $application->address }} </b> <br>
                            <b> {{ __('message.mobile') }} : {{ $application->contact_number }}</b><br>
                            <b> Bill No: {{ $sale->bill_no }}</b><br>
                            <b> Vat: {{ $application->vat_number }}</b><br>
							<b>Date & Time: {{date('d-m-Y')}}  {{date('H:i:sa')}} </b><br>
                            <br>
                        </td>
                    </tr>
                    @if ($sale->customer)
                        <tr>
                            <td colspan="6" style="text-align: center;">
                                {{ __('message.customer') }} : {{ $sale->customer->name }} <br>
                            </td>
                        </tr>
                    @endif
                </thead>
                <tbody style="width: 90%; margin-left:4%; margin-right:5%" >
                    <tr style="border: solid 2px black; margin-left:4%; margin-right:5%">
                        <th style="width: 20%;"> {{ __('message.amount') }}<br></th>
                        <th style="width: 15%;"> {{ __('message.price') }}  </th>
                        <th style="width: 10%;"> {{ __('message.quantity') }}</th>
                        <th style="width: 45%;"> {{ __('message.item') }} </th>
                    </tr>
                    @foreach ($sale->sale_details as $sale_detail)
                        <tr  style="border-bottom: solid 2px black; margin-left:4%; margin-right:5%">
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
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">
                            <table  style="width: 90%; margin-left:4%; margin-right:5%" >
                                <tbody>
                                    <tr style="border-bottom: solid 2px black">
                                        <th style="width: 50%; text-align:left">{{ number_format($sale->grand_amount,2) }}</th>
                                        <th style="width: 50%; text-align:right"> {{ __('message.grand') }}   </th>
                                    </tr>
                                    <tr style="border-bottom: solid 2px black">
                                        <th style="width: 50%; text-align:left">{{ number_format($sale->discount_amount,2) }}</th>
                                        <th style="width: 50%; text-align:right"> {{ __('message.discount') }} </th>
                                    </tr>
                                    <tr style="border-bottom: solid 2px black">
                                        <th style="width: 50%; text-align:left">{{ number_format($sale->tax_amount,2) }}</th>
                                        <th style="width: 50%; text-align:right"> {{ __('message.tax') }} </th>
                                    </tr>
                                    <tr style="border-bottom: solid 2px black">
                                        <th style="width: 50%; text-align:left">{{ number_format($sale->final_amount,2) }}</th>
                                        <th style="width: 50%; text-align:right"> {{ __('message.final') }}  </th>
                                    </tr>
                                </tbody>
                            </table>
                        </th>

                    </tr>
					<tr>
					<th colspan="5">
                            <div style="margin-top: 30px;">
                                <img src="{{ $generatedString }}"
                                alt="barcode" style="height:100px; width:100px;"/>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="5" >
                             <br>
                            <b>Thanks For Visiting {{ $application->name }} <br/>
                            Developed By {{ $application->develop_by }}  </b>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>


