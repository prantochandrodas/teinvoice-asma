@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        {{ __('message.company_information') }} ({{__('message.company_information', [], $secondary_locale)}})
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.application.index') }}"> {{ __('message.company_information') }} ({{__('message.company_information', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item active"> {{ __('message.edit') }} ({{__('message.edit', [], $secondary_locale)}})</li>
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
                            <h3 class="card-title">{{ __('message.edit_company_information') }} ({{__('message.edit_company_information', [], $secondary_locale)}})</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="offset-md-1 col-md-10 ">
                                <div class="card card-primary">
                                    <form role="form" action="{{ route('admin.application.update', $application->id) }}"
                                        method="POST" enctype="multipart/form-data" onsubmit="return formValidation()">
                                        @csrf  @method('patch')

                                        <div class="card-body row">

                                            <div class="form-group col-md-6">
                                                <label for="name">{{ __('message.name') }} ({{__('message.name', [], $secondary_locale)}})</label>
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name') ?? $application->name }}" class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Enter Application Name" required>
                                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="arabic_name">{{ __('message.arabic_name') }} ({{__('message.arabic_name', [], $secondary_locale)}})</label>
                                                <input type="text" name="arabic_name" id="arabic_name"
                                                    value="{{ old('arabic_name') ?? $application->arabic_name }}" class="form-control @error('arabic_name') is-invalid @enderror"
                                                    placeholder="{{ __('message.arabic_name') }} " required>
                                                @error('arabic_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="vat_percent">{{ __('message.vat_percent') }} ({{__('message.vat_percent', [], $secondary_locale)}})</label>
                                                <input type="number" name="vat_percent" id="vat_percent"
                                                    value="{{ old('vat_percent') ?? $application->vat_percent }}" class="form-control @error('vat_percent') is-invalid @enderror"
                                                    placeholder="{{ __('message.vat_percent') }}" max="100" min="0" required>
                                                @error('vat_percent') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="develop_by">{{ __('message.develop_by') }} ({{__('message.develop_by', [], $secondary_locale)}})</label>
                                                <input type="text" name="develop_by" id="develop_by"
                                                    value="{{ old('develop_by') ?? $application->develop_by }}" class="form-control @error('develop_by') is-invalid @enderror"
                                                    placeholder="{{ __('message.develop_by') }} " required>
                                                @error('develop_by') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="contact_number">{{ __('message.contact_number') }} ({{__('message.contact_number', [], $secondary_locale)}})</label>
                                                <input type="text" name="contact_number" id="contact_number"
                                                    value="{{ old('contact_number') ?? $application->contact_number }}"
                                                    class="form-control @error('contact_number') is-invalid @enderror" placeholder="Enter Application Contact Number"
                                                    required>
                                                @error('contact_number') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">{{ __('message.email') }} ({{__('message.email', [], $secondary_locale)}})</label>
                                                <input type="text" name="email" id="email"
                                                    value="{{ old('email') ?? $application->email }}" class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="Enter Application Email" required>
                                                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="vat_number">{{ __('message.vat_number') }} ({{__('message.vat_number', [], $secondary_locale)}})</label>
                                                <input type="text" name="vat_number" id="vat_number"
                                                    value="{{ old('vat_number') ?? $application->vat_number }}" class="form-control @error('vat_number') is-invalid @enderror"
                                                    placeholder="Enter Application Vat Number" required>
                                                @error('vat_number') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cr_no">{{ __('message.cr_no') }} ({{__('message.cr_no', [], $secondary_locale)}})</label>
                                                <input type="text" name="cr_no" id="cr_no"
                                                    value="{{ old('cr_no') ?? $application->cr_no }}" class="form-control @error('cr_no') is-invalid @enderror"
                                                    placeholder="{{ __('message.cr_no') }}" max="100" min="0" required>
                                                @error('cr_no') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ __('message.address') }} ({{__('message.address', [], $secondary_locale)}})</label>
                                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                                    placeholder="Enter Address">{{ old('address') ?? $application->address }}</textarea>
                                                @error('address') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="photo">{{ __('message.photo') }} ({{__('message.photo', [], $secondary_locale)}})</label>
                                                <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror"
                                                    accept="image/*" onchange="return filePreview(this, 'preview_file_photo')">
                                                <div id="preview_file_photo" style="margin-top: 10px;">
                                                    @if ($application->photo != null)
                                                        <img src="{{ asset('/uploads/application/' . $application->photo) }}"
                                                            class="img-fluid img-thumbnail" style="height: 100px"
                                                            alt="Application  Photo">
                                                    @endif
                                                </div>
                                                @error('photo') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            {{-- <div class="form-group col-md-6">
                                                <label for="favicon">Favicon </label>
                                                <input type="file" name="favicon" id="favicon" class="form-control @error('favicon') is-invalid @enderror"
                                                    accept="image/*"  onchange="return filePreview(this, 'preview_file_favicon')">
                                                <div id="preview_file_favicon" style="margin-top: 10px;">
                                                    @if ($application->favicon != null)
                                                            <img src="{{ asset('/uploads/application/' . $application->favicon) }}"
                                                                class="img-fluid img-thumbnail" style="height: 100px"
                                                                alt="Application  Favicon">
                                                    @endif
                                                </div>
                                                @error('favicon') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div> --}}

                                            <div class="form-group col-md-12">
                                                <label for="locale">{{ __('message.language') }}  ({{__('message.language', [], $secondary_locale)}})</label>
                                                <select name="locale" id="locale" class="form-control select2" >
                                                        <option value="en" {{ $application->locale == "en" ? 'selected':'' }}> English</option>
                                                        <option value="ar" {{ $application->locale == "ar" ? 'selected':'' }}> Arabic عربى</option>
                                                        <option value="bn" {{ $application->locale == "bn" ? 'selected':'' }}> Bangla বাংলা </option>
                                                </select>
                                                @error('roles')
                                                    <span class="alert invalid-feedback" role="alert" style="padding: 0px !important"><strong>{{ $message }}</strong> </span>
                                                @enderror
                                            </div>

                                            {{-- <div class="form-group col-md-6">
                                                <label for="meta_author">Meta Author</label>
                                                <textarea name="meta_author" id="meta_author" class="form-control @error('meta_author') is-invalid @enderror"
                                                    placeholder="Enter Meta Author">{{ old('meta_author') ?? $application->meta_author }}</textarea>
                                                @error('meta_author') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="meta_keywords">Meta Keywords</label>
                                                <textarea name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror"
                                                    placeholder="Enter Meta Keywords">{{ old('meta_keywords') ?? $application->meta_keywords }}</textarea>
                                                @error('meta_keywords') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="meta_description">Meta Description</label>
                                                <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                                    placeholder="Enter Meta Description">{{ old('meta_description') ?? $application->meta_description }}</textarea>
                                                @error('meta_description') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span> @enderror
                                            </div> --}}

                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">{{ __('message.update') }} ({{__('message.update', [], $secondary_locale)}})</button>
                                            <button type="reset" class="btn btn-primary">{{ __('message.reset') }} ({{__('message.reset', [], $secondary_locale)}})</button>
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
