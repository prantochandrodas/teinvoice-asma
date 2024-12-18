  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">

            @if(!empty($item->image))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ $item->image_path }}"
                        alt="User profile picture">
                </div>
            @endif

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>{{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}})</b>
                <a class="float-right">
                    <span class="bg-{{ $item->status == 1 ? "success":"danger" }}">{{ $item->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>

            <li class="list-group-item">
                <b>{{ __('message.code') }} ({{__('message.code', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $item->code }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $item->name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.price') }} ({{__('message.price', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $item->price }}
                </a>
            </li>
            <li class="list-group-item">
                <b> {{ __('message.tax') }} ({{__('message.tax', [], $secondary_locale)}}) % </b>
                <a class="float-right">
                    {{ $item->tax }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.price_without_tax') }} ({{__('message.price_without_tax', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $item->price_without_tax }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.purchase_price') }} ({{__('message.purchase_price', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $item->purchase_price }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.details') }} ({{__('message.details', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $item->details }}
                </a>
            </li>
            {{-- <li class="list-group-item">
                <b>Quantity</b>
                <a class="float-right">
                    {{ $item->quantity }}
                </a>
            </li> --}}

          </ul>
        </div>
      </div>
    </div>
  </div>
