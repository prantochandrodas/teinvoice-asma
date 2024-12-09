  <div class="row">
    <table class="table table-sm">
        <tr>
            <th width="30%">Supplier Name </th>
            <th width="10%">:</th>
            <td width="60%">
              {{ $supplierAdjustment->supplier->name }}
            </td>
        </tr>
        <tr>
            <th>Supplier Adjustment Date </th>
            <th>:</th>
            <td>
              {{ date("d-m-Y", strtotime($supplierAdjustment->date)) }}
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <th>:</th>
            <td class="text-danger text-bold">
              {{ number_format($supplierAdjustment->amount, 2) }}
            </td>
        </tr>
        <tr>
            <th>Supplier Adjustment Note </th>
            <th>:</th>
            <td>
              {{ $supplierAdjustment->note }}
            </td>
        </tr>
    </table>
  </div>
