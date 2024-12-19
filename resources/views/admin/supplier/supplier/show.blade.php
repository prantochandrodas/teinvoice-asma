  <div class="row">
    <table class="table table-sm">
        <tr>
            <th >{{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}})</th>
            <th>:</th>
            <td >
                <span class="bg-{{ $supplier->status == 1 ? "success":"danger" }}">{{ $supplier->status == 1 ? "Active":"Inactive" }}</span>
            </td>
        </tr>
        <tr>
            <th width="30%">Supplier Name {{ __('message.supplier') }} {{ __('message.name') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.name', [], $secondary_locale)}})</th>
            <th width="10%">:</th>
            <td width="60%">
              {{ $supplier->name }}
            </td>
        </tr>
        <tr>
            <th> {{ __('message.code') }} ({{__('message.code', [], $secondary_locale)}})</th>
            <th>:</th>
            <td class="text-danger text-bold">
              {{ $supplier->code }}
            </td>
        </tr>
        <tr>
            <th>{{ __('message.balance') }} ({{__('message.balance', [], $secondary_locale)}})</th>
            <th>:</th>
            <td class="text-danger text-bold">
              {{ number_format($supplier->balance, 2) }}
            </td>
        </tr>
        <tr>
            <th>{{ __('message.supplier') }} {{ __('message.company_name') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.company_name', [], $secondary_locale)}})</th>
            <th>:</th>
            <td>
              {{ $supplier->company_name }}
            </td>
        </tr>
        <tr>
            <th>{{ __('message.supplier') }} {{ __('message.email') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.email', [], $secondary_locale)}})</th>
            <th>:</th>
            <td>
              {{ $supplier->email }}
            </td>
        </tr>
        <tr>
            <th>{{ __('message.supplier') }} {{ __('message.contact_number') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.contact_number', [], $secondary_locale)}})</th>
            <th>:</th>
            <td>
              {{ $supplier->contact_number }}
            </td>
        </tr>
        <tr>
            <th>{{ __('message.supplier') }} {{ __('message.address') }} ({{__('message.supplier', [], $secondary_locale)}} {{__('message.address', [], $secondary_locale)}})</th>
            <th>:</th>
            <td>
              {{ $supplier->address }}
            </td>
        </tr>
        <tr>
            <th>{{ __('message.image') }} ({{__('message.image', [], $secondary_locale)}})</th>
            <th>:</th>
            <td>
              @if(!empty($supplier->image))
                  <img src="{{ asset('uploads/supplier/'.$supplier->image) }}" class="img-fluid img-thumbnail" style="height: 100px" alt="supplier User">
              @endif
            </td>
        </tr>
    </table>
  </div>
