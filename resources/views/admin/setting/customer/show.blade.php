  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">

            @if(!empty($customer->image))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ $customer->image_path }}"
                        alt="Customer profile picture">
                </div>
            @endif
          <ul class="list-group list-group-unbordered mb-3">

            <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                    <span class="bg-{{ $customer->status == 1 ? "success":"danger" }}">{{ $customer->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>
            <li class="list-group-item">
                <b>Name</b>
                <a class="float-right">
                    {{ $customer->name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Email</b>
                <a class="float-right">
                    {{ $customer->email }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Phone</b>
                <a class="float-right">
                    {{ $customer->phone }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Vat No</b>
                <a class="float-right">
                    {{ $customer->vat_no }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Address</b>
                <a class="float-right">
                    {{ $customer->address }}
                </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
