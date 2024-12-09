<form action="{{ route('admin.branches.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Branch </h5>
                    {{-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <label for="">Branch Name</label>
                    <input type="text" name="name" id="" class="form-control"
                    placeholder="Branch Name"   value="{{ $item->name }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">Branch Name Arabic</label>
                    <input type="text" name="arabic_name" id="" class="form-control"
                    placeholder="Branch Name Arabic" value="{{ $item->arabic_name }}">
                    @error('arabic_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">Contact Number</label>
                    <input type="number" name="contact_number" id="" class="form-control"
                    placeholder="Contact Number" value="{{ $item->contact_number }}">
                    @error('contact_number')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">Email</label>
                    <input type="email" name="email" id="" class="form-control"
                    placeholder="Email" value="{{ $item->email }}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control" placeholder="address">{{ $item->address }}"</textarea>
                    @error('address')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">Vat Number</label>
                    <input type="number" name="vat_number" id="" class="form-control"
                    placeholder="Contact Number" value="{{ $item->vat_number }}">
                    @error('vat_number')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">CR Number</label>
                    <input type="number" name="cr_no" id="" class="form-control"
                    placeholder="Contact Number" value="{{ $item->cr_no }}">
                    @error('cr_no')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="close_btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success float-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
