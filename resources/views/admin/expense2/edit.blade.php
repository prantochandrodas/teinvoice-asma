<form action="{{ route('admin.expense.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <label for="">Select Branch </label>
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

                    <label for="">Select Expense Head (حدد رأس النفقات)</label>
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
                    <label for="">Expense Id (معرف النفقات)</label>
                    <input type="text" name="expense_id" id="" class="form-control" placeholder="Expense ID"
                        value="{{ old('expense_id', $item->expense_id) }}">
                    @error('expense_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <label for="">Date (تاريخ)</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $item->date) }}">
                    @error('date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <label for="">Amount(كمية)</label>
                    <input type="text" name="amount" id="" class="form-control"
                        placeholder="Expense Amount" value="{{ old('amount', $item->amount) }}">
                    @error('amount')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <label for="">Purpose(غاية)</label>
                    <input type="text" name="comment" id="" class="form-control" placeholder="Comment"
                        value="{{ old('comment', $item->comment) }}">
                    @error('comment')
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
