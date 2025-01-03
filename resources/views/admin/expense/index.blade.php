@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('message.expense_head') }} ({{__('message.expense_head', [], $secondary_locale)}})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('message.home') }} ({{__('message.home', [], $secondary_locale)}})</a></li>
                        <li class="breadcrumb-item active">{{ __('message.expense_head') }} ({{__('message.expense_head', [], $secondary_locale)}})</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ __('message.expense_head') }}  {{ __('message.list') }} ({{__('message.expense_head', [], $secondary_locale)}} {{__('message.list', [], $secondary_locale)}})  </h3>
                            @if (auth_admin_user_permission('supplier.create'))
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success float-right">
                                    <i class="fa fa-pencil-alt"></i> {{ __('message.add') }} {{ __('message.expense_head') }}   ({{__('message.add', [], $secondary_locale)}}{{__('message.expense_head', [], $secondary_locale)}} )
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%" class="text-center"> {{ __('message.serial') }} ({{__('message.serial', [], $secondary_locale)}}) </th>
                                        <th width="10%" class="text-center"> {{ __('message.head_name') }} ({{__('message.head_name', [], $secondary_locale)}}) </th>
                                        <th width="7%" class="text-center"> {{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}}) </th>
                                        <th width="11%" class="text-center"> {{ __('message.action') }} ({{__('message.action', [], $secondary_locale)}}) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expense_head as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="text-center">{{ $item->name }}</td>
                                            <td class="text-center">{{ $item->status == '1' ? 'Active' : 'Inactive' }}</td>
                                            <td>
                                                <div style="display: flex;justify-content: center;">
                                                    <div>
                                                        <a href=" " data-toggle="modal"
                                                            data-target="#editModal-{{ $item->id }}"
                                                            class="btn btn-success"> <i class="fa fa-edit"></i> </a>
                                                    </div>
                                                    <div class="ml-1">
                                                        <form action="{{ route('admin.expense-head.destroy', $item->id) }}"
                                                            method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button onclick="if (!confirm('Are you sure to delete this?')) { return false }" type="submit" class="btn btn-danger delete-btn">
                                                                <i class="fa fa-trash"></i> </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editModal-{{ $item->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <form action="{{ route('admin.expense-head.update', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <h4 class="modal-title"> {{ __('message.edit') }} {{ __('message.expense_head') }} ({{__('message.edit', [], $secondary_locale)}} {{__('message.expense_head', [], $secondary_locale)}} )</h4>
                                                            <button type="button" class="close bg-danger"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" id="showResult">
                                                            <label for="">{{ __('message.expense_head') }} {{ __('message.name') }}  ( {{__('message.expense_head', [], $secondary_locale)}} {{__('message.name', [], $secondary_locale)}})</label>
                                                            <input type="text" name="name" id=""
                                                                class="form-control" placeholder="Expense Head Name"
                                                                value="{{ $item->name }}">
                                                            @error('name')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror


                                                            <label class="mt-2" for=""> {{ __('message.status') }} ({{__('message.status', [], $secondary_locale)}})</label>
                                                            <select name="status" id="" class="form-control"
                                                                required>
                                                                <option value="">Select Status</option>
                                                                <option {{ $item->status == '1' ? 'selected' : '' }}
                                                                    value="1">Active</option>
                                                                <option {{ $item->status == '0' ? 'selected' : '' }}
                                                                    value="0">Inactive</option>
                                                            </select>
                                                            @error('status')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger float-right"
                                                                data-dismiss="modal">{{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})</button>
                                                            <button type="submit"
                                                                class="btn btn-success float-right">{{ __('message.submit') }} ({{__('message.submit', [], $secondary_locale)}})</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.expense-head.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title">{{ __('message.add') }} {{ __('message.expense_head') }} ({{__('message.add', [], $secondary_locale)}} {{__('message.expense_head', [], $secondary_locale)}} )</h4>
                                    <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="showResult">
                                    <label for="">{{ __('message.expense_head') }} {{ __('message.name') }}  ( {{__('message.expense_head', [], $secondary_locale)}} {{__('message.name', [], $secondary_locale)}})</label>
                                    <input type="text" name="name" id="" class="form-control"
                                        placeholder="Expense Head Name">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger float-right"
                                        data-dismiss="modal">{{ __('message.close') }} ({{__('message.close', [], $secondary_locale)}})</button>
                                    <button type="submit" class="btn btn-success float-right">{{ __('message.submit') }} ({{__('message.submit', [], $secondary_locale)}})</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
