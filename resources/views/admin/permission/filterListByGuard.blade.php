@php $i = 0; @endphp
@foreach($permissions as $permission)
    @php $i++; @endphp
    {{--<label for="permission_{{ $i }}"><input type="checkbox" name="permisions[]" id="permission_{{ $i }}"> {{ $permission->name }}</label>--}}
    <label class="form-check-label">
        <input type="checkbox" name="permisions[]" class="form-check-input permission_item" value="{{ $permission->id }}"> <b>{{ $permission->name }}</b>
    </label>&nbsp;
@endforeach