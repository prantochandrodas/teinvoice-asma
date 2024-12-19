<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0 ">{{ __('message.sale_details') }}
          ({{ __('message.sale_details', [], $secondary_locale) }})</h5>
    </div>
    <div class="card-body p-4">
        <table class="table table-hover table-striped table-responsive-md">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Bill No</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Grand Amount</th>
                    <th scope="col">Discount Amount</th>
                    <th scope="col">Tax Amount</th>
                    <th scope="col">Pay Amount</th>
                    <th scope="col">Due Amount</th>
                    <th scope="col">Final Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saleInfo as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->bill_no }}</td>
                        <td>{{ $item->total_quantity }}</td>
                        <td>{{ number_format($item->grand_amount) }}</td>
                        <td>{{ number_format($item->discount_amount) }}</td>
                        <td>{{ number_format($item->tax_amount) }}</td>
                        <td>{{ number_format($item->final_amount - $item->due_payment, 2) }}</td>
                        <td>{{ number_format($item->due_payment, 2) }}</td>
                        <td>{{ number_format($item->final_amount) }}</td>
                    </tr>
                @endforeach
                <td class="text-center" style="font-weight: 700" colspan="8">Total</td>
                <td style="font-weight: 700">   {{ number_format($saleInfo->sum('final_amount'), 2) }}</td>
            </tbody>
        </table>
    </div>
</div>
<div class="card shadow-sm mb-4">
  <div class="card-header">
      <h5 class="mb-0 ">{{ __('message.payment_details') }}
        ({{ __('message.payment_details', [], $secondary_locale) }})</h5>
  </div>
  <div class="card-body p-4">
      <table class="table table-hover table-striped table-responsive-md">
          <thead class="bg-dark text-white">
              <tr>
                  <th scope="col">Payment Date</th>
                  <th scope="col">Voucher Number</th>
                  <th scope="col">Payment Type</th>
                  <th scope="col">Payment Amount</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($paymentInfo as $item)
                  <tr>
                      <td>{{ $item->payment_date }}</td>
                      <td>{{ $item->voucher_number }}</td>
                      <td>{{ $item->payment_type }}</td>
                      <td>{{ number_format($item->pay_amount) }}</td>
                  </tr>
              @endforeach
              <td class="text-center" style="font-weight: 700" colspan="3">Total</td>
              <td style="font-weight: 700">   {{ number_format($paymentInfo->sum('pay_amount'), 2) }}</td>
          </tbody>
      </table>
  </div>
</div>

<div class="card shadow-sm mb-4">
  <div class="card-header">
      <h5 class="mb-0">{{ __('message.summary') }}
        ({{ __('message.summary', [], $secondary_locale) }})</h5>
  </div>
  <div class="card-body p-4">
      <table class="table table-borderless">
          <tbody>
              <tr>
                  <th scope="row">Total Sales Amount:</th>
                  <td>{{ number_format($saleInfo->sum('final_amount'), 2) }}</td>
              </tr>
              <tr>
                  <th scope="row">Total Payment Received:</th>
                  <td>{{ number_format($paymentInfo->sum('pay_amount'), 2) }}</td>
              </tr>
              <tr class="fw-bold text-danger">
                  <th scope="row">Total Due Amount:</th>
                  <td>{{ number_format($saleInfo->sum('final_amount') - $paymentInfo->sum('pay_amount'), 2) }}</td>
              </tr>
          </tbody>
      </table>
  </div>
</div>

