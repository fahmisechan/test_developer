@extends('layouts.app')
@section('content')
 <div class="card">
     <div class="card-body">
        <form action="{{ route('transaction.update',$record->id) }}" method="post">
            @csrf
	        @method('PUT')
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Book') }}</label>
                <div class="col-md-10">
                    <select id="get_book_id" name="book_id" class="form-control">
                        <option value=""disabled>Choose One</option>
                        @foreach ($book as $item)
                            <option value="{{ $item->id}}" {{ $item->id  == $record->book_id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Genre') }}</label>
                <div class="col-md-10">
                    <input type="text" id="genre" class="form-control" value="{{ $record->book->genre }}" disabled>
                </div>
            </div>
            <div class="form-group row" id="total" style="display: none">
                <label class="col-md-2 col-form-label"></label>
                <div class="col-md-10">
                    <p class="text-danger">Out of stock</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Borrow Date') }}</label>
                <div class="col-md-10">
                    <input type="date" class="form-control" value="{{ $record->borrow_date }}" name="borrow_date" id="borrow_date_value">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Due Date') }}</label>
                <div class="col-md-10">
                    <input type="date" class="form-control" value="{{ $record->due_date }}" name="due_date" id="due_date_value">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
     </div>
 </div>
 @endsection
 @section('script')
<script type="text/javascript">
        $('#get_book_id').select2();
    $('select#get_book_id').change(function(){
        var id = $('#get_book_id :selected').val();
        $.get({
        url: `/transaction/${id}/autofill`,
        data : id,
        success: function(result){
         $('#genre').val(result.genre);
         if(result.total < 1){
             $('#total').show();
         }else{
             $('#total').hide();
         }
         console.log(result)
        }
     });
    });

    $('#borrow_date_value').change(function(){
        var borrow_date = $('#borrow_date_value').val();
        var due_date = $('#due_date_value').val();
        if(!due_date){
            return true;
        }else if(borrow_date > due_date){
            alert('Borrowing date cannot be greater than the due date')
            $('#borrow_date_value').val('');
        }
    });

    $('#due_date_value').change(function(){
        var borrow_date = $('#borrow_date_value').val();
        var due_date = $('#due_date_value').val();
        if(due_date < borrow_date || borrow_date == null){
            alert('Due date cannot be less than the borrowing date')
            $('#due_date_value').val('');
        }
    });
</script>
@endsection
