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
            <div class="container" style="text-align: center">
                <h3>Asma Global Services Ltd</h3>
                <p>Expense List</p>
            </div>

            <table class="product-table">
                <thead>
                    <tr>
                        <th width="7%" class="text-center"> SL (إس إل)</th>
                        <th width="7%" class="text-center"> Date (تاريخ)</th>
                        <th width="10%" class="text-center"> Head Name (اسم الرأس) </th>
                        <th width="10%" class="text-center"> Id (بطاقة تعريف)</th>
                        <th width="10%" class="text-center"> Amount (كمية)</th>
                        <th width="10%" class="text-center"> Purpose (غاية)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalExpens = 0;
                    @endphp
                    @foreach ($expenses as $item)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td class="text-center">{{ $item->date }}</td>
                            <td class="text-center">{{ $item->expenseHead->name }}</td>
                            <td class="text-center">{{ $item->expense_id }}</td>
                            <td class="text-center">{{ $item->amount }}</td>
                            <td class="text-center">{{ $item->comment }}</td>
                        </tr>
                        @php
                            $totalExpens += $item->amount;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot class="mt-3">
                    <td colspan="3"></td>
                    <td>Total:</td>
                    <td>{{ $totalExpens }}</td>
                    <td></td>
                </tfoot>
            </table>
        </section>
    </div>
</body>
</html>
