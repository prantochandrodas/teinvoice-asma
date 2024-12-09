  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            @if(!empty($branchUser->photo))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ asset('uploads/branchUser/'.$branchUser->photo) }}"
                        alt="User profile picture">
                </div>
            @endif

            <h3 class="profile-username text-center">
                {{ $branchUser->full_name }}
            </h3>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Status</b>
                <a class="float-right">
                    <span class="bg-{{ $branchUser->status == 1 ? "success":"danger" }}">{{ $branchUser->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>
            <li class="list-group-item">
                <b>Branch </b>
                <a class="float-right">
                    {{ $branchUser->branch->name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>User Name</b>
                <a class="float-right">
                    {{ $branchUser->username }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Email</b>
                <a class="float-right">
                    {{ $branchUser->email }}
                </a>
            </li>
            <li class="list-group-item">
                <b>First Name</b>
                <a class="float-right">
                    {{ $branchUser->first_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Last Name</b>
                <a class="float-right">
                    {{ $branchUser->last_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>Phone</b>
                <a class="float-right">
                    {{ $branchUser->phone }}
                </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
