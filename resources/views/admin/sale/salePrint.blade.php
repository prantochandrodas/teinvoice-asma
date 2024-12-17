{{-- <!DOCTYPE html>
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

        table>tbody>tr>td,
        table>tbody>tr>th,
        table>tfoot>tr>td,
        table>tfoot>tr>th,
        table>thead>tr>td,
        table>thead>tr>th {
            text-align: center;
        }



        .tables {
            border: 2px solid black;
        }

        .tables thead,
        .tables thead th,
        .tables thead td,
        .table-bordered td,
        .table-bordered th {
            border: 1px solid black;
        }

        .tables-border {
            border-collapse: collapse;
            border: 2px solid #000000;
        }

        .tables-border > thead > tr > td,
        .tables-border > tbody > tr > td,
        .tables-border > tfoot > tr > td{
            border: 2px solid #000000;
            padding: 5px;
        }

        .tables-border > thead > tr > th,
        .tables-border > tbody > tr > th,
        .tables-border > tfoot > tr > th {
            border: 2px solid #000000;
            padding: 5px;
        }

        .tables-product{
            border-collapse: collapse;
            border: 2px solid #000000;
        }

        .tables-product>thead>tr,
        .tables-product>tbody,
        .tables-product>tfoot>tr{
            border-collapse: collapse;
            border: 2px solid #000000;
        }

    </style>
</head>
<script type="text/javascript">
    @if ($type && $type == 2)
        window.print();
        window.onafterprint = function(){
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

    <div id="printArea" style="  margin: 0 auto !important; width: 100%;overflow: hidden; padding-top: 10px " >

        <table width="98%" class="tables-border" style="margin-left:1%; margin-right:1%; margin-bottom: 20px">
            <tbody>
                <tr>
                    <td class="text-center text-bold">
					<img src="{{ asset('uploads/application/') . '/' . $application->photo }}"
                        alt="{{ $application->name ?? config('app.name') }}" style="height: 100px; width:300px"
                        style="opacity: .8">
                        <b>
                            <h3>{{ $application->arabic_name }}</h3>
                        </b>
                        <b>
                            <h4> {{ $application->name }}</h4>
                        </b>
                        <b> {{ $application->address }} </b> <br>
                        <b> Mobile : {{ $application->contact_number }} : متحرك </b><br>
                        <b> CR No : {{ $application->cr_no }} : رقم السجل التجاري </b><br>
                        <b> Vat No(15%): {{ $application->vat_number }} :15٪ ظريبه الشراء </b><br>
                       <b><h3> فاتورة ضريبية مبسطة نقدا  </h3></b></br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        TAX INVOICE : فاتورة ضريبية
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <b>  {{ $sale->payment_type }} </b>
                    </td>
                </tr>
                <tr>
                    <td >
                        <table width="100%">
                            <tr>
                                <td style="text-align: left;" width="33%">
                                    Invoice No :
                                </td>
                                <td style="text-align: center;" width="47%">
                                    {{ $sale->bill_no }}
                                </td>
                                <td style="text-align: right;" width="20%">
                                    رقم الفاتورة
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;" width="33%">
                                    Invoice Date :
                                </td>
                                <td style="text-align: center;" width="47%">
                                    {{ date('d/m/Y', strtotime($sale->date)) }}
                                        &nbsp; &nbsp; &nbsp; &nbsp;
                                    {{ date('H:i:s A', strtotime($sale->time)) }}
                                </td>
                                <td style="text-align: right;" width="20%">
                                    تاريخ الفاتورة
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @if ($sale->customer)
                    <tr>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td style="text-align: left;" width="40%">
                                        Customer عميل :
                                    </td>
                                    <td style="text-align: left;" width="60%">
                                        {{ $sale->customer->name }}
                                    </td>
                                </tr>

								<tr>
								<td style="text-align: left;" width="40%">
                                        Mobile التليفون المحمول :
                                    </td>
                                    <td style="text-align: left;" width="60%">
                                        {{ $sale->customer->phone }}
                                    </td>
								</tr>
                                <tr>
                                    <td style="text-align: left;" width="40%">
                                        Address عنوان :
                                    </td>
                                    <td style="text-align: left;" width="60%">
                                        {{ $sale->customer->address }}
                                    </td>

                                </tr>

								<tr>
								<td style="text-align: left;" width="50%">
                                        VAT NO ضريبة القيمة المضافة لا :
                                    </td>
                                    <td style="text-align: left;" width="50%">
                                        {{ $sale->customer->vat_no }}
                                    </td>
								</tr>
                            </table>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>


        <table width="98%" class="tables-product" style="margin-left:1%; margin-right:1%;margin-bottom: 20px">
            <thead>
                <tr>
                    <th style="width: 5%;"> SL NO. </th>
                    <th style="width: 30%;"> Product <br> المنتوج </th>
                    <th style="width: 10%;"> QTY <br> كمية </th>
                    <th style="width: 20%;"> PRICE <br> السعر </th>
                    <th style="width: 20%;"> TOTAL <br> المجموع </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->sale_details as $sale_detail)
                    <tr >
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            @if ($sale_detail->item && $sale_detail->item->name)
                                {{ $sale_detail->item->name }}
                            @else
                                {{ $sale_detail->item_name }}
                            @endif
                        </td>
                        <td>
                            {{ floatval($sale_detail->quantity) }}
                        </td>

						<td>
                            {{ number_format($sale_detail->price, 2) }}
                        </td>

                        <td>
                            {{ number_format($sale_detail->amount, 2) }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        Total Quantity (الكمية الإجمالية) :  {{ floatval($sale->total_quantity) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style=" padding: 5px">
                        <table style="width: 100%; border: 4px solid #000; -moz-border-radius: 6px;
                        -webkit-border-radius: 6px;
                        border-radius: 6px;  border-collapse: separate;">
                            <thead>
                                <tr>
                                    <td width="70%" class="text-right">Subtotal  (المجموع الفرعي) :</td>
                                    <td width="30%" class="text-center"> SR  {{ number_format($sale->final_amount,2) }} </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Discount  (خصم) :</td>
                                    <td class="text-center"> SR  {{ number_format($sale->discount_amount,2) }} </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Amount (Excluding VAT) (المبلغ باستثناء ضريبة القيمة المضافة):</td>
                                    <td class="text-center"> SR {{ number_format($sale->grand_amount,2) }}  </td>
                                </tr>
                                <tr>
                                    <td class="text-right"> VAT 15% (ضريبة القيمة المضافة):</td>
                                    <td class="text-center"> SR {{ number_format($sale->tax_amount,2) }} </td>
                                </tr>
                                <tr>
                                    <td class="text-right"> Net Total with TAX (الإجمالي الصافي مع الضريبة):</td>
                                    <td class="text-center"> SR {{ number_format($sale->final_amount,2) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>

        <table width="98%" style="margin-left:1%; margin-right:1%; margin-bottom: 20px">
            <thead>
                <tr>
                    <td width="50%" class="text-center">
                        <img src="{{ $generatedString }}" alt="QR Code" style="height:120px; width:120px;" />
                    </td>
                    <td width="50%" class="text-center">
                        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('11a', 'C39')}}" alt="barcode"  style="height:60px; width:200px;" />
                    </td>
                </tr>
            </thead>
        </table>

        <table width="100%" >
            <thead>
                <tr>
                    <td >
                        <table width="98%" style="margin-left:1%; margin-right:1%; margin-bottom: 20px; border: 1px solid #000">
                            <thead>
                                <tr>
                                    <td >
                                        لا عودة ولا تبادل بدون فاتورة. يجب
                                        أن يكون تبادل الإرجاع في غضون 3
                                        أيام من البيع. يجب أن تكون العناصر في
                                        عبوتها الأصلية والتي يجب
                                         أن تكون في حالتها الأصلية غير التالفة.
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        No return no exchange without invoice.
                                        Return exchange should be within 3 days of sale.
                                        Items must be in their original packing which must be
                                        in the original undamaged condition.
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</body>

</html> --}}
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
        window.onafterprint = function(){
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
        <header class="border-dark" style="padding-left: 0 !important;padding-right:0 !important;padding-top:0 !important;padding-bottom:0 !important">
            <img style="width: 100%;height:200px" src="{{ asset('uploads/application/') . '/' . $application->photo }}" alt="Asma Global Services Ltd." />
        </header>
        <h2><b> TAX INVOICE :فاتورة ضريبية مبسطة نقدا </b></h2>
        <div class="row" style="width: 100%; margin-left: auto; margin-right: auto;">
            <div class=" col border border-dark" style="border-left: 0 !important;">
                <p><b>Branch Name: {{$sale->branch ? $sale->branch->name : ''}}</b></p>
                {{-- <p><b>SL NO: {{$sale->id}}</b></p> --}}
                <p><b>Bill No: {{$sale->bill_no}}</b></p>
            </div>
            @if ($sale->customer)
                <div class="col-5 border-top border-bottom border-dark">
                    <div class="d-flex justify-content-between">
                        <p>Customer :</p>
                        <p>
                            @if ( $sale->customer->name)
                                {{ $sale->customer->name }}
                            @endif</p>
                        <p>عميل</p>
                          </div>
                           <div class="d-flex justify-content-between">
                    <p>
                        Mobile:</p>
                        <p>
                            @if ( $sale->customer->phone){{ $sale->customer->phone }} @endif <p>  التليفون المحمول

                        </p>
                           </div>
                           <div class="d-flex justify-content-between">
                    <p>Address  :</p>  <p> @if ( $sale->customer->address)
                        {{ $sale->customer->address }}
                    @endif</p><p>  عنوان</p>
                           </div>
                           <div class="d-flex justify-content-between">
                    <p>VAT NO :</p>  <p> @if ( $sale->customer->vat_no) {{ $sale->customer->vat_no }} @endif </p> <p> ضريبة القيمة المضافة </p>
                           </div>
                </div>
            @endif

            <div class=" col border border-dark" style="border-right: 0 !important;">
                <p> <b>Date & Time :
                    {{ date('d/m/Y', strtotime($sale->date)) }}
                    &nbsp; &nbsp; &nbsp; &nbsp;
                {{ date('H:i:s A', strtotime($sale->time)) }}                   الفاتورة تاري خ
                </b></p>
            </div>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>SL NO.</th>
                    <th>Product <br>المنتوج</th>
                    <th>QTY <br>كمية</th>
                    <th>PRICE <br>السعر</th>
                    <th>TOTAL <br>المجموع</th>
                </tr>
            </thead>
            <tbody style="height: 270px;">
                @foreach ($sale->sale_details as $sale_detail)
                <tr style="vertical-align:top">
                    <td>  {{ $loop->iteration }}</td>
                    <td>       @if ($sale_detail->item && $sale_detail->item->name)
                        {{ $sale_detail->item->name }}
                    @else
                        {{ $sale_detail->item_name }}
                    @endif</td>
                    <td>{{ floatval($sale_detail->quantity) }}</td>
                    <td>{{ number_format($sale_detail->price, 2) }}</td>
                    <td>  {{ number_format($sale_detail->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end" >Subtotal ( الفرعي المجموع) :</td>
                    <td>SR {{ number_format($sale->final_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Discount (خصم) :</td>
                    <td>SR {{ number_format($sale->discount_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Amount (Excluding VAT) (المضافة القيمة ضريبة باستثناء المبلغ):</td>
                    <td>SR {{ number_format($sale->grand_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">VAT (المضافة القيمة ضريبة) :</td>
                    <td>SR {{ number_format($sale->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Net Total with TAX (اإلجمالي الصافي مع الض) :</td>
                    <td>SR {{ number_format($sale->final_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Pay Amount (مبلغ الدفع):</td>
                    <td>SR {{ number_format($sale->final_amount - $sale->due_payment, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Due Amount (المبلغ المستحق):</td>
                    <td>SR {{ number_format($sale->due_payment, 2) }}</td>
                </tr>
               
            </tfoot>
        </table>

        <div class="qr-code">
            <img src="{{ $generatedString }}" alt="QR Code" style="height:120px; width:120px;" />
        </div>
    </section>
    <p class="text-center">Supported by  <b>TE Invoice Software</b></p>
</div>
</body>

</html>
