  <div class="row">
    <table class="table table-sm">
        <tr>
            <th >Status</th>
            <th>:</th>
            <td >
                <span class="bg-{{ $supplier->status == 1 ? "success":"danger" }}">{{ $supplier->status == 1 ? "Active":"Inactive" }}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Supplier Name </th>
            <th width="10%">:</th>
            <td width="60%">
              {{ $supplier->name }}
            </td>
        </tr>
        <tr>
            <th>Code</th>
            <th>:</th>
            <td class="text-danger text-bold">
              {{ $supplier->code }}
            </td>
        </tr>
        <tr>
            <th>Balance</th>
            <th>:</th>
            <td class="text-danger text-bold">
              {{ number_format($supplier->balance, 2) }}
            </td>
        </tr>
        <tr>
            <th>Supplier Company Name</th>
            <th>:</th>
            <td>
              {{ $supplier->company_name }}
            </td>
        </tr>
        <tr>
            <th>Supplier Email</th>
            <th>:</th>
            <td>
              {{ $supplier->email }}
            </td>
        </tr>
        <tr>
            <th>Supplier Contact Number</th>
            <th>:</th>
            <td>
              {{ $supplier->contact_number }}
            </td>
        </tr>
        <tr>
            <th>Supplier Address</th>
            <th>:</th>
            <td>
              {{ $supplier->address }}
            </td>
        </tr>
        <tr>
            <th>Image</th>
            <th>:</th>
            <td>
              @if(!empty($supplier->image))
                  <img src="{{ asset('uploads/supplier/'.$supplier->image) }}" class="img-fluid img-thumbnail" style="height: 100px" alt="supplier User">
              @endif
            </td>
        </tr>
    </table>
  </div>
