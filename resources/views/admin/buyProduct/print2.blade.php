<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
    <style>
        p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            border-bottom: 1px solid #ccc;
            padding: 20px;
            text-align: center;
        }

        .invoice {
            border: 3px solid #ccc;
            /* padding: 8px; */
            margin: 8px;
        }

        .invoice h2 {
            text-align: center;
        }

        .product-table {
            border-collapse: collapse;
            width: 100%;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #1b1919;
            padding: 1px;
            text-align: center;
        }

        .qr-code {
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="printArea" style="padding: 0 40px;">
        <section class="invoice border-dark">
            {{-- <header class="border-dark"
                style="padding-left: 0 !important;padding-right:0 !important;padding-top:0 !important;padding-bottom:0 !important">
                <img style="width: 100%;height:200px"
                    src="{{ asset('uploads/application/') . '/' . $application->photo }}"
                    alt="Asma Global Services Ltd." />
            </header> --}}
            <div class="container" style="text-align: center">
                <h3>Asma Global Services Ltd</h3>
                <p>Expense List</p>
            </div>

            <table class="product-table">
                <thead>
                    <tr>
                        <th>#Sl</th>
                        <th>Purchase No</th>
                        <th>Supplier Name</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Item Buy Bill</th>
                        <th>Item Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalBuyBill = 0;
                        $totalCost = 0;
                    @endphp
                    @foreach ($buyProductDetails as $item)
                        <tr style="vertical-align:top">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->purchase_no }}</td>
                            <td>{{ $item->supplier_name }}</td>
                            <td>{{ $item->item_code }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->item_buy_bill }}</td>
                            <td>{{ $item->total_cost }}</td>
                        </tr>
                        @php
                            $totalBuyBill += $item->item_buy_bill;
                            $totalCost += $item->total_cost;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot class="mt-3">
                    <td colspan="4"></td>
                    <td>Total:</td>
                    <td>{{ $totalBuyBill }}</td>
                    <td>{{ $totalCost }}</td>
                </tfoot>
            </table>
        </section>
    </div>
</body>

</html>
