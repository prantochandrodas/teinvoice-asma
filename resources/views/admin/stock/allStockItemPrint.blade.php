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
        <table width="100%" style="margin-top: -2rm" class="table table-bordered table-striped">
            <caption class="text-center">
                <h1> Stock Item </h1>
            </caption>
            <thead>
                <tr>
                    <th width="5%" class="text-center"> SL </th>
                    <th width="15%" class="text-center"> Item Code </th>
                    <th width="20%" class="text-center"> Item Name </th>
                    <th width="20%" class="text-center"> Quantity </th>
                    <th width="20%" class="text-center"> Price </th>
                    <th width="20%" class="text-center"> Stock Amount </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_quantity   = 0;
                    $total_amount     = 0;
                @endphp
                @foreach ($stockItems as $stockItem)
                    @php
                        $total_quantity   += 0;
                        $total_amount     += 0;

                        $total_quantity   += $stockItem->quantity;
                        $total_amount     += $stockItem->amount;
                    @endphp
                    <tr>
                        <td  class="text-center"> {{ $loop->iteration }} </td>
                        <td  class="text-center"> {{ $stockItem->item->code }}  </td>
                        <td  class="text-center"> {{ $stockItem->item->name }}  </td>
                        <td  class="text-center"> {{ floatval($stockItem->quantity) }}  </td>
                        <td  class="text-center"> {{ number_format($stockItem->unit_cost,2) }}  </td>
                        <td  class="text-center"> {{ number_format($stockItem->amount,2) }} </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th  class="text-center" colspan="3"> Total </th>
                    <th  class="text-center"> {{ floatval($total_quantity) }}  </th>
                    <th class="text-center" >  </th>
                    <th  class="text-center"> {{ number_format($total_amount,2) }}  </th>
                </tr>
            </tfoot>
        </table>
    </body>
</html>


