  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            @if(!empty($shopUser->photo))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ asset('uploads/shopUser/'.$shopUser->photo) }}"
                        alt="User profile picture">
                </div>
            @endif

            <h3 class="profile-username text-center">
                {{ $shopUser->full_name }}
            </h3>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                    <span class="bg-{{ $shopUser->status == 1 ? "success":"danger" }}">{{ $shopUser->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>
            <li class="list-group-item">
                <b>shop </b>
                <a class="float-right">
                    {{ $shopUser->shop->name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>User Name</b>
                <a class="float-right">
                    {{ $shopUser->username }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Email</b>
                <a class="float-right">
                    {{ $shopUser->email }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Password</b>
                <a class="float-right">
                    {{ $shopUser->store_password }}
                </a>
            </li>
            <li class="list-group-item">
                <b>First Name</b>
                <a class="float-right">
                    {{ $shopUser->first_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Last Name</b>
                <a class="float-right">
                    {{ $shopUser->last_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Phone</b>
                <a class="float-right">
                    {{ $shopUser->phone }}
                </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
