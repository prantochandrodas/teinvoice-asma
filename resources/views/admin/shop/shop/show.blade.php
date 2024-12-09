  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">

            @if(!empty($shop->photo))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ $shop->photo_path }}"
                        alt="Shop Photo">
                </div>
            @endif

            <h3 class="profile-username text-center">
                {{ $shop->full_name }}
            </h3>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                    <span class="bg-{{ $shop->status == 1 ? "success":"danger" }}">{{ $shop->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>

            <li class="list-group-item">
                <b>Shop Type </b>
                <a class="float-right">
                    {{ $shop->shop_type->name ?? "" }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Name</b>
                <a class="float-right">
                    {{ $shop->shop }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Owner Name</b>
                <a class="float-right">
                    {{ $shop->owner_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Email</b>
                <a class="float-right">
                    {{ $shop->email }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Phone</b>
                <a class="float-right">
                    {{ $shop->phone }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Password</b>
                <a class="float-right">
                    {{ $shop->store_password }}
                </a>
            </li>
            @if(!empty($shop->banner_photo))
                <li class="list-group-item">
                    <b>Banner Photo</b>
                    <div class="float-right">
                        <img class="profile-user-img img-fluid"
                            src="{{ $shop->banner_photo_path }}"
                            alt="Banner Photo">
                    </div>
                </li>
            @endif
            <li class="list-group-item">
                <b>NID Number</b>
                <a class="float-right">
                    {{ $shop->nid_number }}
                </a>
            </li>
            @if(!empty($shop->nid_photo))
                <li class="list-group-item">
                    <b>NID Photo</b>
                    <div class="float-right">
                        <img class="profile-user-img img-fluid"
                            src="{{ $shop->nid_photo_path }}"
                            alt="NID Photo">
                    </div>
                </li>
            @endif
            <li class="list-group-item">
                <b>Trade License</b>
                <a class="float-right">
                    {{ $shop->trade_license_number }}
                </a>
            </li>
            @if(!empty($shop->trade_license_photo))
                <li class="list-group-item">
                    <b>Trade License Photo</b>
                    <div class="float-right">
                        <img class="profile-user-img img-fluid"
                            src="{{ $shop->trade_license_photo_path }}"
                            alt="Trade License Photo">
                    </div>
                </li>
            @endif
            <li class="list-group-item">
                <b></b>
                <a class="float-right">
                    {{ $shop->tin_number }}
                </a>
            </li>
            @if(!empty($shop->tin_photo))
                <li class="list-group-item">
                    <b>TIN Photo</b>
                    <div class="float-right">
                        <img class="profile-user-img img-fluid"
                            src="{{ $shop->tin_photo_path }}"
                            alt="TIN Photo">
                    </div>
                </li>
            @endif

            <li class="list-group-item">
                <b>Latitude </b>
                <a class="float-right">
                    {{ $shop->latitude }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Longitude </b>
                <a class="float-right">
                    {{ $shop->longitude }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Division </b>
                <a class="float-right">
                    {{ $shop->division->name ?? "" }}
                </a>
            </li>
            <li class="list-group-item">
                <b>District </b>
                <a class="float-right">
                    {{ $shop->district->name ?? "" }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Area </b>
                <a class="float-right">
                    {{ $shop->area->name ?? "" }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Branch </b>
                <a class="float-right">
                    {{ $shop->branch->name ?? "" }}
                </a>
            </li>
            @if ($shop->product_tags)
                <li class="list-group-item">
                    <b>Product Tags </b>
                    <a class="float-right">
                        @foreach ($shop->product_tags as $product_tag)
                            <span class="badge badge-secondary mr-2 " style="font-size: 17px">
                                {{ $product_tag->name }}
                            </span>
                        @endforeach
                    </a>
                </li>
            @endif

          </ul>
        </div>
      </div>
    </div>
  </div>
