<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{{ $application->name }}</title>
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
            window.close();
           
        }

        function cancelPage() {
            
                window.close();
            
        }
    </script>

    <body>
         <div id="print" class="row" style="padding-bottom: 30px; margin-bottom: 30px;">
            <div class="col-md-12">
                <span style="float:right">
                    <button class="btn btn-sm btn-info" onclick="printPage('printArea')">Print</button>
                    <button class="btn btn-sm btn-danger" onclick="cancelPage()">Cancel</button>
                </span>
            </div>
        </div>
        <div id="printArea" style="text-align: center !important">
            <div style="width:100% !important; text-align: center !important;">
                <span><b> {{ $application->name }} </b> </span><br/>
                <img src="https://teinvoicesoftware.com/teis/bar_code/code.php?code={{$item->code}}" style="width:200px !important; height: 80px !important"/><br/>
                <span style="font-size:20px !important;"><b>{{$item->name}} - </b></span>
				  <span style="font-size:20px !important;"><b>{{$item->price}} SR.</b></span><br/>
				  <span style="font-size:12px !important;"><b>M.Date:{{$item->manufacture_date}}</b> </span><span style="font-size:12px !important;"><b>E.Date:{{$item->expiry_date}}</b></span>
            </div>
        </div>
    </body>
</html>


