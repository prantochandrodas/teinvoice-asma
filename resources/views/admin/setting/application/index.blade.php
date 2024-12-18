@extends('layouts.admin_layout.admin_layout')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('message.company_information') }} ({{__('message.company_information', [], $secondary_locale)}})</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">
                    {{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})
                </a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('message.company_information') }} ({{__('message.company_information', [], $secondary_locale)}})
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <fieldset>
                    <legend>
                        {{ __('message.company_information') }} ({{__('message.company_information', [], $secondary_locale)}})
                    </legend>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-right " style="margin-bottom: 20px">
                                @if (auth_admin_user_permission('admin.edit'))
                                    <a href="{{ route('admin.application.edit', $application->id) }}" type="submit" class="btn btn-success">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    @if(!empty($application->photo))
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('uploads/application/'.$application->photo) }}"
                                                alt="User profile picture">
                                        </div>
                                    @endif

                                    <h3 class="profile-username text-center">
                                        {{ $application->full_name }}
                                    </h3>

                                <ul class="list-group list-group-unbordered mb-3">

                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->name }}
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.arabic_name') }} ({{__('message.arabic_name', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->arabic_name }}
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.vat_percent') }} ({{__('message.vat_percent', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->vat_percent }}
                                        </a>
                                    </li>


                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.develop_by') }} ({{__('message.develop_by', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->develop_by }}
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.email') }} ({{__('message.email', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->email }}
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.contact_number') }} ({{__('message.contact_number', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->contact_number }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.address') }} ({{__('message.address', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->address }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.vat_number') }} ({{__('message.vat_number', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->vat_number }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.cr_no') }} ({{__('message.cr_no', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            {{ $application->cr_no }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>
                                            {{ __('message.language') }} ({{__('message.language', [], $secondary_locale)}})
                                        </b>
                                        <a class="float-right">
                                            @switch($application->locale)
                                                @case("en")
                                                    English
                                                    @break
                                                @case("bn")
                                                    Bangla বাংলা
                                                    @break
                                                @case("ar")
                                                    Arabic عربى
                                                    @break
                                                @default

                                            @endswitch
                                        </a>
                                    </li>
                                    {{-- <li class="list-group-item">
                                        <b>Favicon</b>
                                        <a class="float-right">
                                            @if (!empty($application->favicon))
                                                <img src="{{ asset('uploads/application/' . $application->favicon) }}"
                                                    class="img-fluid img-thumbnail" style="height: 100px" alt="Application Favicon">
                                            @endif
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Meta Author</b>
                                        <a class="float-right">
                                            {{ $application->meta_author ?? "--" }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Meta Keywords</b>
                                        <a class="float-right">
                                            {{ $application->meta_keywords ?? "--" }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Meta Description</b>
                                        <a class="float-right">
                                            {{ $application->meta_description ?? "--" }}
                                        </a>
                                    </li> --}}
                                </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            </div>


                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
  </div>
@endsection


@push('script_js')
  <script>
    window.onload = function(){


      $('.view-modal').click(function(){
        var application_id = $(this).attr('application_id');
        var url = "{{ route('admin.application.show', ":application_id") }}";
        url = url.replace(':application_id', application_id);
        $('#showResult').html('');
        if(application_id.length != 0){
          $.ajax({
            cache   : false,
            // data    : {application_id: application_id, _token : "{{ csrf_token() }}"},
            type    : "GET",
            error   : function(xhr){ alert("An error occurred: " + xhr.status + " " + xhr.statusText); },
            url : url,
            success : function(response){
              $('#showResult').html(response);
            },

          })
        }
      });
    }
  </script>
@endpush
