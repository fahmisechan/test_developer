<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $book = Book::get();
            return Datatables::of($book)
            ->addColumn('num', function ($record) {
                return request()->start;
            })
                    ->addColumn('action', function($data) {
                        return '<a href="book/'.$data->id.'/edit" class="btn btn-success btn-sm" id="getEditArticleData" data-id="'.$data->id.'">Edit</a>
                        <form action="book/'.$data->id.'" method="POST" style="display : inline-block;">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</a>
                        </form>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('book.create');
    }
    public function store(Request $request)
    {
        Book::create($request->all());
        return redirect('/book');
    }
    public function edit($id)
    {
        $book = Book::findorFail($id);
        return view('book.edit',compact('book'));

    }
    public function update(Request $request,$id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return redirect('book');
    }
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect('book');
    }
}
