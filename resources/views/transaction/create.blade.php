@extends('layouts.app')
@section('content')
 <div class="card">
     <div class="card-body">
        <form action="{{ route('transaction.store') }}" method="post">
            @csrf
	        @method('POST')
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Book') }}</label>
                <div class="col-md-10">
                    <select id="get_book_id" name="book_id" class="form-control">
                        <option value="" selected disabled>Choose One</option>
                        @foreach ($book as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Genre') }}</label>
                <div class="col-md-10">
                    <input type="text" id="genre" class="form-control" value="" disabled>
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
                    <input type="date" class="form-control" name="borrow_date" id="borrow_date_value">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Due Date') }}</label>
                <div class="col-md-10">
                    <input type="date" class="form-control" name="due_date" id="due_date_value">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
        <table id="book" class="table table-bordered yajra-datatable" style="width:100%">
           <thead>
               <tr>
                   <th>Num</th>
                   <th>Code</th>
                   <th>Student</th>
                   <th>Book</th>
                   <th>Borrow Date</th>
                   <th>Due Date</th>
                   <th>Status</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
           </tbody>
        </table>
     </div>
 </div>
 @endsection
 @section('script')
<script type="text/javascript">
    $(function() {
        $('#get_book_id').select2();
        $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('transaction.index') !!}',
            columns: [
                { data: 'DT_RowIndex' , orderable: false,searchable: false},
                { data: 'code', name: 'code' },
                { data: 'user_id', name: 'user_id' },
                { data: 'book_id', name: 'book_id' },
                { data: 'borrow_date', name: 'borrow_date' },
                { data: 'due_date', name: 'due_date' },
                { data: 'status', name: 'status' },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
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
