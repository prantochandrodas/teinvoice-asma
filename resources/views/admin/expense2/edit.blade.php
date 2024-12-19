<form action="{{ route('admin.expense.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('message.edit') }} {{ __('message.expense') }}  ({{ __('message.edit', [], $secondary_locale) }} {{ __('message.expense', [], $secondary_locale) }})</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <label for="">{{ __('message.select_branch') }} ({{ __('message.select_branch', [], $secondary_locale) }})</label>
                    <select name="branch_id" id="" class="form-control">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option {{ $item->branch_id == $branch->id ? 'selected' : '' }}
                                value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.expense_head') }} ({{ __('message.expense_head', [], $secondary_locale) }})</label>
                    <select name="expense_head_id" id="" class="form-control">
                        <option value="">Select Expense Head</option>
                        @foreach ($expenseHeads as $expenseHead)
                            <option {{ $item->expense_head_id == $expenseHead->id ? 'selected' : '' }}
                                value="{{ $expenseHead->id }}">{{ $expenseHead->name }}</option>
                        @endforeach
                    </select>
                    @error('expense_head_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <label for="">{{ __('message.expense') }} {{ __('message.id') }}  ({{ __('message.expense', [], $secondary_locale) }} {{ __('message.id', [], $secondary_locale) }})</label>
                    <input type="text" name="expense_id" id="" class="form-control" placeholder="Expense ID"
                        value="{{ old('expense_id', $item->expense_id) }}">
                    @error('expense_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <label for="">{{ __('message.date') }} ({{ __('message.date', [], $secondary_locale) }})</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $item->date) }}">
                    @error('date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <label for="">{{ __('message.amount') }} ({{ __('message.amount', [], $secondary_locale) }})</label>
                    <input type="text" name="amount" id="" class="form-control"
                        placeholder="Expense Amount" value="{{ old('amount', $item->amount) }}">
                    @error('amount')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">{{ __('message.purpose') }} ({{ __('message.purpose', [], $secondary_locale) }})</label>
                    <input type="text" name="comment" id="" class="form-control" placeholder="Comment"
                        value="{{ old('comment', $item->comment) }}">
                    @error('comment')
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
