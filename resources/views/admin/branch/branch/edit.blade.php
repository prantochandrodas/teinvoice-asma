<form action="{{ route('admin.branches.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('message.edit') }} {{ __('message.branch') }} ({{ __('message.edit', [], $secondary_locale) }} {{ __('message.branch', [], $secondary_locale) }}) </h5>
                    {{-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <label for="">{{ __('message.branch_name') }} ({{ __('message.branch_name', [], $secondary_locale) }})</label>
                    <input type="text" name="name" id="" class="form-control"
                    placeholder="Branch Name"   value="{{ $item->name }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.branch_name_arabic') }} ({{ __('message.branch_name_arabic', [], $secondary_locale) }})</label>
                    <input type="text" name="arabic_name" id="" class="form-control"
                    placeholder="Branch Name Arabic" value="{{ $item->arabic_name }}">
                    @error('arabic_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.contact_number') }} ({{ __('message.contact_number', [], $secondary_locale) }})</label>
                    <input type="number" name="contact_number" id="" class="form-control"
                    placeholder="Contact Number" value="{{ $item->contact_number }}">
                    @error('contact_number')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.email') }} ({{ __('message.email', [], $secondary_locale) }})</label>
                    <input type="email" name="email" id="" class="form-control"
                    placeholder="Email" value="{{ $item->email }}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="address">{{ __('message.address') }} ({{ __('message.address', [], $secondary_locale) }})</label>
                    <textarea name="address" id="address" class="form-control" placeholder="address">{{ $item->address }}"</textarea>
                    @error('address')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.vat_number') }} ({{ __('message.vat_number', [], $secondary_locale) }})</label>
                    <input type="number" name="vat_number" id="" class="form-control"
                    placeholder="Contact Number" value="{{ $item->vat_number }}">
                    @error('vat_number')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.cr_no') }} ({{ __('message.cr_no', [], $secondary_locale) }})</label>
                    <input type="number" name="cr_no" id="" class="form-control"
                    placeholder="Contact Number" value="{{ $item->cr_no }}">
                    @error('cr_no')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="close_btn" data-bs-dismiss="modal">{{ __('message.close') }} ({{ __('message.close', [], $secondary_locale) }})</button>
                    <button type="submit" class="btn btn-success float-right">{{ __('message.submit') }} ({{ __('message.submit', [], $secondary_locale) }})</button>
                </div>
            </div>
        </div>
    </div>
</form>
