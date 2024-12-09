  <div class="row">
    <table class="table table-sm">
        <tr>
            <th width="30%">Supplier Name </th>
            <th width="10%">:</th>
            <td width="60%">
              {{ $supplierOpening->supplier->name }}
            </td>
        </tr>
        <tr>
            <th>Supplier Opening Date </th>
            <th>:</th>
            <td>
              {{ date("d-m-Y", strtotime($supplierOpening->date)) }}
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <th>:</th>
            <td class="text-danger text-bold">
              {{ number_format($supplierOpening->amount, 2) }}
            </td>
        </tr>
        <tr>
            <th>Supplier Opening Note </th>
            <th>:</th>
            <td>
              {{ $supplierOpening->note }}
            </td>
        </tr>
    </table>
  </div>
