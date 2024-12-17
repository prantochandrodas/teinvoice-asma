<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 12px;
            margin: 0;
            padding: 20px;
            /* Add padding around the content */
        }

        body p {
            margin: 4px;
        }

       

        

      

      

        /* Print-specific styles */
        @media print {
            /* body {
                padding: 10px;
                font-size: 12px;
                line-height: 1.2;
            } */

            /* .d-flex {
                display: block !important; 
            } */


            /* Ensure that everything fits on one page */
            @page {
                size: A4;
                margin: 0;
                padding: 0;
            }

           
            /* Reduce image size to fit the page */
            /* img {
                width: 100%;
                height: auto;
                max-height: 200px;
                object-fit: contain;
            } */

            /* Hide unwanted elements when printing */
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center">
        <div>
            <img src="{{ $application->photo_path }}" style="height: 200px" alt="">
            <div class="mt-4">
                <p class="fw-bold text-center" style="font-size: 16px">{{ $application->name }}</p>
                <p class="text-center" style="font-size: 16px">{{ $application->arabic_name }}</p>
                <p class="text-center" style="font-size: 16px">{{ $application->arabic_name }}</p>
                <p class="text-center" style="font-size: 16px">C.R {{ $application->cr_no }}</p>
                <p class="text-center" style="font-size: 16px">VAT NO: {{ $application->vat_number }}</p>
            </div>
            <div class="mt-4" style="border-bottom: 1px dashed black">
                <p class="text-center" style="font-size: 16px">Receipt Voucher</p>
                <p class="text-center" style="font-size: 16px">Date:</p>
            </div>
            <div style="border-bottom: 1px dashed black">
                <div class="d-flex justify-content-between">
                    <p style="font-size: 16px">Voucher : {{$data->voucher_number ? $data->voucher_number : ''}}</p>
                    <p style="font-size: 16px">
                        {{ $data->payment_date ? \Carbon\Carbon::parse($data->payment_date)->format('d/m/Y') : '' }}
                    </p>
                </div>
                <p class="fw-bold" style="font-size: 16px">Received From: {{$data->customer ? $data->customer->name : ''}}</p>
                <p class="fw-bold" style="font-size: 16px">Amount: {{$data->pay_amount ? number_format($data->pay_amount) : ''}}</p>
                <p style="font-size: 16px">
                    {{ $data->pay_amount ? convertNumberToWords($data->pay_amount) . ' Saudi Riyals only.' : 'N/A' }}
                </p>
                <br>
                <p class="fw-bold" style="font-size: 16px">Payment-Type: {{$data->payment_type ? $data->payment_type : ''}}</p>
                <p class="fw-bold" style="font-size: 16px">Ledger Balance: {{$data->customer ? number_format($data->customer->due_payment) : ''}}</p>
            </div>
            <p class="text-center" style="font-size: 16px">Thank You For Shopping</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Add a slight delay to ensure the table and content are fully rendered
            window.open('', '_blank');
            setTimeout(() => {
                window.print();
            }, 1000); // Adjust the delay time if needed
    
            // Return to the previous page after printing
            window.onafterprint = function () {
                window.history.back();
            };
        });
    </script>
</body>

</html>
