<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 10px;
            /* border: 1px solid #ccc; */
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .dashed-border {
            border-bottom: 1px dashed black;
        }
    </style>
</head>

<body>
    <div id="print" class="row" style="padding-bottom: 30px; margin-bottom: 30px;">
        <div class="col-md-12">
            <span style="float:right">
                <button class="btn btn-sm btn-info" id="printBtn" onclick="printPage('printArea')">Print</button>
                <button class="btn btn-sm btn-danger" onclick="cancelPage()">Cancel</button>
            </span>
        </div>
    </div>

    <div id="printArea" style="padding: 0 40px;">
        <table>
            <!-- Header -->
            <tr>
                <td colspan="2" class="text-center">
                    <img src="{{ $application->photo_path }}" style="width: 100%;height:200px" alt="Company Logo">
                </td>
            </tr>
            {{-- <tr>
                <td colspan="2" class="text-center">
                    <p class="fw-bold" style="font-size: 16px">{{ $application->name }}</p>
                    <p style="font-size: 16px">{{ $application->arabic_name }}</p>
                    <p style="font-size: 16px">C.R {{ $application->cr_no }}</p>
                    <p style="font-size: 16px">VAT NO: {{ $application->vat_number }}</p>
                </td>
            </tr> --}}

            <!-- Receipt Voucher -->
            <tr>
                <td colspan="2" class="text-center dashed-border">
                    <p class="fw-bold" style="font-size: 16px">(إيصال استلام) <br> Receipt Voucher</p>
                    
                </td>
            </tr>

            <!-- Voucher Details -->
            <tr>
                <td>
                    <p style="font-size: 16px">(قسيمة) Voucher: {{$data->voucher_number ? $data->voucher_number : ''}}</p>
                </td>
                <td class="text-end">
                    <p style="font-size: 16px">
                        (تاريخ)  Date: {{ $data->payment_date ? \Carbon\Carbon::parse($data->payment_date)->format('d/m/Y') : '' }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="fw-bold" style="font-size: 16px">(اسم الفرع)  Branch Name: {{$data->branch ? $data->branch->name : ''}}</p>
                    <p class="fw-bold" style="font-size: 16px">(تم الاستلام بواسطة)  Received By: {{$data->received_by ? $data->received_by: ''}}</p>
                    <p class="fw-bold" style="font-size: 16px">(تم الاستلام من)  Received From: {{$data->customer ? $data->customer->name : ''}}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="fw-bold" style="font-size: 16px">(كمية)  Amount: {{$data->pay_amount ? number_format($data->pay_amount) : ''}}</p>
                    <p style="font-size: 16px">
                        {{ $data->pay_amount ? convertNumberToWords($data->pay_amount) . ' Saudi Riyals only.' : 'N/A' }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="dashed-border">
                    <p class="fw-bold" style="font-size: 16px">(نوع الدفع) Payment-Type: {{$data->payment_type ? $data->payment_type : ''}}</p>
                    <p class="fw-bold" style="font-size: 16px">(رصيد الدفتر) Ledger Balance: {{$data->customer ? number_format($data->customer->due_payment) : ''}}</p>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td colspan="2" class="text-center ">
                    <p style="font-size: 16px">(شكرا لك على التسوق) <br> Thank You For Shopping</p>
                </td>
            </tr>
        </table>
    </div>

    <script type="text/javascript">
        function printPage(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function cancelPage() {
            window.location.href = '{{ $previous_route }}';
        }
    </script>
</body>

</html>
