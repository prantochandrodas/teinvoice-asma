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
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-left text-bold" style="font-size: 16px;">SHOP NAME : {{ $application->name }} </div>
                <div class="col-sm-6 text-right text-bold" style="font-size: 16px;">VAT NUMBER: {{ $application->vat_number }} </div>
                <div class="col-sm-6 text-left text-bold" style="font-size: 16px;">
                    DATE: <span>{{ date('d-F-Y', strtotime($from_date)) }} to {{ date('d-F-Y', strtotime($from_date)) }} </span></div>
            </div>
            <table width="100%" style="margin-top: -2rm" class="table table-bordered table-striped">
                <caption class="text-center">
                    <h1> Sale Report </h1>
                </caption>
                <thead>
                    <tr>
                        <th  class="text-center"> SL </th>
                        <th  class="text-center"> Date</th>
                        <th  class="text-center"> Bill No </th>
                        <th  class="text-center"> Bill Type</th>
                        <th  class="text-center"> Quantity </th>
                        <th  class="text-center"> Grand Amount </th>
                        <th  class="text-center"> Discount Amount </th>
                        <th  class="text-center"> Tax Amount </th>
                        <th  class="text-center"> Final Amount  </th>
                        <th  class="text-center"> Purchase  Amount  </th>
                        <th  class="text-center"> Purchase  TAX Amount  </th>
                        <th  class="text-center"> Purchase Final Amount  </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_quantity         = 0;
                        $total_grand_amount     = 0;
                        $total_discount_amount  = 0;
                        $total_tax_amount       = 0;
                        $total_final_amount     = 0;
                        $total_unit_cost        = 0;
                        $total_purchase_tax_amount        = 0;
                        $total_purchase_final_amount        = 0;
                    @endphp
                    @foreach ($sales as $sale)
                        @php
                            $total_quantity         += $sale->total_quantity;
                            $total_grand_amount     += $sale->grand_amount;
                            $total_discount_amount  += $sale->discount_amount;
                            $total_tax_amount       += $sale->tax_amount;
                            $total_final_amount     += $sale->final_amount;
                            $total_unit_cost     += $sale->total_unit_cost;
                            $total_purchase_final_amount        += $sale->total_unit_cost;
                        @endphp
                        <tr>
                            <td  class="text-center"> {{ $loop->iteration }} </td>
                            <td  class="text-center"> {{ date("d-m-Y", strtotime($sale->date)) }} </td>
                            <td  class="text-center"> {{ $sale->bill_no }}  </td>
                            <td  class="text-center"> {{ $sale->bill_type }} </td>
                            <td  class="text-center"> {{ floatval($sale->total_quantity) }}  </td>
                            <td  class="text-center"> {{ number_format($sale->grand_amount,2) }}  </td>
                            <td  class="text-center"> {{ number_format($sale->discount_amount,2) }} </td>
                            <td  class="text-center"> {{ number_format($sale->tax_amount,2) }}  </td>
                            <td  class="text-center"> {{ number_format($sale->final_amount,2) }}  </td>
                            <td  class="text-center"> {{ number_format($sale->total_unit_cost,2) }}  </td>
                            <td  class="text-center"> 0.00  </td>
                            <td  class="text-center"> {{ number_format($sale->total_unit_cost,2) }}  </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th  class="text-center" colspan="4"> Total </th>
                        <th  class="text-center"> {{ floatval($total_quantity) }}  </th>
                        <th  class="text-center"> {{ number_format($total_grand_amount,2) }}  </th>
                        <th  class="text-center"> {{ number_format($total_discount_amount,2) }} </th>
                        <th  class="text-center"> {{ number_format($total_tax_amount,2) }}  </th>
                        <th  class="text-center"> {{ number_format($total_final_amount,2) }}  </th>
                        <th  class="text-center"> {{ number_format($total_unit_cost,2) }}  </th>
                        <th  class="text-center"> {{ number_format($total_purchase_tax_amount,2) }}  </th>
                        <th  class="text-center"> {{ number_format($total_purchase_final_amount,2) }}  </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>


