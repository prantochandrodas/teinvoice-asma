<div class="modal-header bg-default">
    <h4 class="modal-title">Purchase Information View </h4>
    <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <fieldset>
                    <legend>Purchase Information</legend>
                    <div class="row">
                        <div class="col-md-6">
                        <table class="table table-style">
                            <tr>
                                <th style="width: 40%"> Invoice No </th>
                                <td style="width: 10%"> : </td>
                                <td style="width: 50%"> {{ $purchase->invoice_no }} </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Date </th>
                                <td style="width: 10%"> : </td>
                                <td style="width: 50%"> {{ \Carbon\Carbon::parse($purchase->date)->format('d/m/Y') }} </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Quantity </th>
                                <td style="width: 10%"> : </td>
                                <td style="width: 50%"> {{ floatval($purchase->total_quantity) }} </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Grand Amount </th>
                                <td style="width: 10%"> : </td>
                                <td style="width: 50%"> {{ number_format($purchase->grand_amount,2) }} </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Discount Amount </th>
                                <td style="width: 10%"> : </td>
                                <td style="width: 50%"> {{ number_format($purchase->discount_amount,2) }} </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Final Amount </th>
                                <td style="width: 10%"> : </td>
                                <td style="width: 50%"> {{ number_format($purchase->final_amount,2) }} </td>
                            </tr>
                        </table>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Supplier Information </legend>
                                <table class="table table-style">
                                    <tr>
                                        <th style="width: 40%"> Name </th>
                                        <td style="width: 10%"> : </td>
                                        <td style="width: 50%"> {{ $purchase->supplier? $purchase->supplier->name : "" }} </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%"> Contact Number </th>
                                        <td style="width: 10%"> : </td>
                                        <td style="width: 50%"> {{ $purchase->supplier? $purchase->supplier->contact_number : "" }} </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%"> Email </th>
                                        <td style="width: 10%"> : </td>
                                        <td style="width: 50%"> {{ $purchase->supplier? $purchase->supplier->email : ""  }} </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%"> Address </th>
                                        <td style="width: 10%"> : </td>
                                        <td style="width: 50%"> {{ $purchase->supplier? $purchase->supplier->address : ""  }} </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                    </div>

                    @if($purchase->purchase_items->count() > 0)
                        <fieldset>
                            <legend>Purchase Items</legend>
                            <table class="table table-style table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%" class="text-center"> SL </th>
                                        <th width="15%" class="text-center"> Item Name </th>
                                        <th width="15%" class="text-center"> Item Code </th>
                                        <th width="20%" class="text-center">Quantity </th>
                                        <th width="20%" class="text-center">Price </th>
                                        <th width="20%" class="text-center">Amount </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->purchase_items as $purchase_item)
                                        <tr>
                                            <td class="text-center"> {{ $loop->iteration }} </td>
                                            <td class="text-center"> {{ $purchase_item->item->name }} </td>
                                            <td class="text-center"> {{ $purchase_item->item->code }} </td>
                                            <td class="text-center"> {{ $purchase_item->quantity }} </td>
                                            <td class="text-center"> {{ number_format($purchase_item->price,2) }} </td>
                                            <td class="text-center"> {{ number_format($purchase_item->amount,2) }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </fieldset>
                    @endif
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button  type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
</div>

<style>
    .table-style td, .table-style th {
        padding: .1rem !important;
    }
</style>

<script>

</script>
