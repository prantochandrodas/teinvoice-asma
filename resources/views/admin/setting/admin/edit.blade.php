@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Admins</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin.index') }}">{{ __('message.admin') }} </a></li>
                        <li class="breadcrumb-item active">{{ __('message.edit') }} </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Edit Admin </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.admin.update', $admin->id) }}" method="POST"
                                        enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf
                                        @method('patch')

                                        <div class="card-body row">
                                            <div class="form-group col-md-6">
                                                <label for="username">{{ __('message.username') }} <code>*</code>  </label>
                                                <input type="text" name="username" id="username" value="{{ $admin->username ?? old('username') }}"
                                                class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('message.enter_username') }}" required>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="email">{{ __('message.email') }} <code>*</code> </label>
                                                <input type="email" name="email" id="email"  value="{{ $admin->email ?? old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror"  placeholder="{{ __('message.enter_email') }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="first_name">{{ __('message.first_name') }}<code>*</code>  </label>
                                                <input type="text" name="first_name" id="first_name" value="{{ $admin->first_name ?? old('first_name') }}"
                                                    class="form-control @error('first_name') is-invalid @enderror" placeholder="{{ __('message.first_name') }}" required>
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">{{ __('message.last_name') }} <code>*</code>  </label>
                                                <input type="text" name="last_name" id="last_name" value="{{ $admin->last_name ?? old('last_name') }}"
                                                    class="form-control @error('last_name') is-invalid @enderror" placeholder="{{ __('message.last_name') }}" required>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">{{ __('message.phone') }} <code>*</code> </label>
                                                <input type="text" name="phone" id="phone"  value="{{ $admin->phone ?? old('phone') }}"
                                                    class="form-control @error('phone') is-invalid @enderror"  placeholder="{{ __('message.phone') }} " required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password">{{ __('message.password') }}  </label>
                                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                                    class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('message.password') }} " >
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="address">{{ __('message.address') }}   </label>
                                                <textarea type="address" name="address" id="address"
                                                   class="form-control @error('address') is-invalid @enderror" placeholder="{{ __('message.address') }} "
                                                >{{ $admin->address ?? old('address') }}</textarea>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="photo">{{ __('message.photo') }} </label>
                                                <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this)">
                                                <div id="preview_file" style="margin-top: 10px;">
                                                    @if ($admin->photo != null)
                                                        <img src="{{ file_url($admin->photo, 'admin') }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px" alt="User">
                                                    @endif
                                                </div>
                                                @error('photo')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="roles">{{ __('message.assign_roles') }}</label>
                                                <select name="roles[]" id="roles" class="form-control select2" multiple>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" {{ $admin->hasRole($role->name) ? 'selected':'' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                    <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('style_css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script_js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function formValidation() {

        }

    </script>
@endpush
