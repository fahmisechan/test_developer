@extends('layouts.app')
@section('content')
 <div class="card">
     <div class="card-body">
        <form action="{{ route('book.store') }}" method="post">
            @csrf
	        @method('POST')
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Genre') }}</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="genre">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Total') }}</label>
                <div class="col-md-10">
                    <input type="number" class="form-control" name="total">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
        <table id="book" class="table table-bordered yajra-datatable" style="width:100%">
           <thead>
               <tr>
                   <th>Name</th>
                   <th>Genre</th>
                   <th>Total</th>
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
        $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('book.index') !!}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'genre', name: 'genre' },
                { data: 'total', name: 'total' },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection
