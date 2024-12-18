  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            @if(!empty($admin->photo))
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ asset('uploads/admin/'.$admin->photo) }}"
                        alt="User profile picture">
                </div>
            @endif

            <h3 class="profile-username text-center">
                {{ $admin->full_name }}
            </h3>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>{{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}})</b>
                <a class="float-right">
                    <span class="bg-{{ $admin->status == 1 ? "success":"danger" }}">{{ $admin->status == 1 ? "Active":"Inactive" }}</span>
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.username') }} ({{__('message.username', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $admin->username }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.email') }} ({{__('message.email', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $admin->email }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.first_name') }} ({{__('message.first_name', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $admin->first_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.last_name') }} ({{__('message.last_name', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $admin->last_name }}
                </a>
            </li>
            <li class="list-group-item">
                <b>{{ __('message.phone') }} ({{__('message.phone', [], $secondary_locale)}})</b>
                <a class="float-right">
                    {{ $admin->phone }}
                </a>
            </li>
            @if($admin->roles)
            <li class="list-group-item">
                <b>{{ __('message.role') }} ({{__('message.role', [], $secondary_locale)}})</b>
                <a class="float-right">
                    @foreach ($admin->roles as $role)
                        <span class="badge badge-info mr-2">{{ $role->name }}</span>
                    @endforeach
                </a>
            </li>
            @endif
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
