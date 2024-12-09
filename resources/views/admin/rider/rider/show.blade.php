  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">

            @if(!empty($rider->photo))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ asset('uploads/customer/'.$rider->photo) }}"
                        alt="User profile picture">
                </div>
            @endif

            <h3 class="profile-username text-center">
                {{ $rider->full_name }}
            </h3>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                    <span class="bg-{{ $rider->status == 1 ? "success":"danger" }}">{{ $rider->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>

            <li class="list-group-item">
                <b>User Name</b>
                <a class="float-right">
                    {{ $rider->username }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Email</b>
                <a class="float-right">
                    {{ $rider->email }}
                </a>
            </li>
            <li class="list-group-item">
                <b>First Name</b>
                <a class="float-right">
                    {{ $rider->first_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Last Name</b>
                <a class="float-right">
                    {{ $rider->last_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Phone</b>
                <a class="float-right">
                    {{ $rider->phone }}
                </a>
            </li>
            <li class="list-group-item">
                <b>NID Number</b>
                <a class="float-right">
                    {{ $rider->nid_number }}
                </a>
            </li>
            @if(!empty($rider->nid_photo))
            <li class="list-group-item">
                <b>NID Photo</b>
                <div class="float-right">
                        <img class="profile-user-img img-fluid"
                            src="{{ asset('uploads/customer/'.$rider->nid_photo) }}"
                            alt="User profile picture">
                </div>
            </li>
            @endif

            <li class="list-group-item">
                <b>Country </b>
                <a class="float-right">
                    {{ $rider->country->name ?? "" }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Division </b>
                <a class="float-right">
                    {{ $rider->division->name ?? "" }}
                </a>
            </li>
            <li class="list-group-item">
                <b>District </b>
                <a class="float-right">
                    {{ $rider->district->name ?? "" }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Area </b>
                <a class="float-right">
                    {{ $rider->area->name ?? "" }}
                </a>
            </li>

            <li class="list-group-item">
                <b>Branch </b>
                <a class="float-right">
                    {{ $rider->branch->name ?? "" }}
                </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
