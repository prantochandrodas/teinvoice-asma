<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>
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
<script type="text/javascript">
    @if ($type && $type == 2)
        window.print();
        window.onafterprint = function() {
            window.location.href = '{{ $previous_route }}';
        }
    @else
        function printPage(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
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
    @if (!$type || ($type && $type != 2))
        <div id="print" class="row" style="padding-bottom: 30px; margin-bottom: 30px;">
            <div class="col-md-12">
                <span style="float:right">
                    <button class="btn btn-sm btn-info" id="printBtn" onclick="printPage('printArea')">Print</button>
                    <button class="btn btn-sm btn-danger" onclick="cancelPage()">Cancel</button>
                </span>
            </div>
        </div>
    @endif
    <div id="printArea" style="padding: 0 40px;">
        <section class="invoice border-dark">
            <header class="border-dark"
                style="padding-left: 0 !important;padding-right:0 !important;padding-top:0 !important;padding-bottom:0 !important">
                <img style="width: 100%;height:200px"
                    src="{{ asset('uploads/application/') . '/' . $application->photo }}"
                    alt="Asma Global Services Ltd." />
            </header>

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
                <tbody style="height: 630px;">
                    @php
                        $totalBuyBill = 0;
                        $totalCost = 0;
                    @endphp
                    @foreach ($data as $item)
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
        <p class="text-center">Supported by <b>TE Invoice Software</b></p>
    </div>
</body>

</html>
