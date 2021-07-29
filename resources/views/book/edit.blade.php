@extends('layouts.app')
@section('content')
 <div class="card">
     <div class="card-body">
        <form action="{{ route('book.update',$book->id) }}" method="post">
            @csrf
	        @method('PUT')
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="{{ $book->name }}"  name="name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Genre') }}</label>
                <div class="col-md-10">
                    <input type="text" class="form-control"  value="{{ $book->genre }}" name="genre">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">{{ __('Total') }}</label>
                <div class="col-md-10">
                    <input type="number" class="form-control"  value="{{ $book->total }}" name="total">
                </div>
            </div>
            <button href="{{ url('book') }}" class="btn btn-warning">Back</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
     </div>
 </div>
 @endsection
