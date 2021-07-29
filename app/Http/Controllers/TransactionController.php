<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $book = Book::get();
        if ($request->ajax()) {
            $transaction = Transaction::get();
            return Datatables::of($transaction)
            ->addIndexColumn()
            ->addColumn('num', function ($record) {
                return request()->start;
            })
            ->addColumn('status', function ($record) {
                return $record->status == 0 ? '<button class="btn btn-primary btn-sm">Borrowed</button>' : '<button class="btn btn-danger btn-sm">Due Date</button>';
            })
            ->addColumn('book_id', function ($record) {
                return $record->book->name;
            })
            ->addColumn('user_id', function ($record) {
                return $record->user->name;
            })
                    ->addColumn('action', function($data) {
                        return Auth::user()->role == 'user' ? '' : '<a href="transaction/'.$data->id.'/edit" class="btn btn-success btn-sm" id="getEditArticleData" data-id="'.$data->id.'">Edit</a>
                        <form action="transaction/'.$data->id.'" method="POST" style="display : inline-block;">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</a>
                        </form>
                        ';
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('transaction.create',compact('book'));
    }
    public function store(Request $request)
    {
        // return $request;
        $transaction = new Transaction();
        $transaction->code = 'TR'.mt_rand(0,10000);
        $transaction->user_id = Auth()->user()->id;
        $transaction->book_id = $request->book_id;
        $transaction->borrow_date = $request->borrow_date;
        $transaction->due_date = $request->due_date;
        if($request->due_date < Carbon::now()){
         $transaction->status = 1;
        }else{
            $transaction->status = 0;
        }
        if($transaction->save()){
            $book = Book::where('id',$request->book_id)->first();
            Book::where('id',$request->book_id)->update([
                'total' => $book->total - 1
            ]);
        }
        return redirect('/transaction');
    }
    public function edit($id)
    {
        $record = Transaction::findorFail($id);
        $book = Book::get();
        return view('transaction.edit',compact('record','book'));

    }
    public function update(Request $request,$id)
    {
        $transaction = Transaction::findOrFail($id);
        if($request->due_date < Carbon::now()){
            $transaction->status = 1;
           }else{
            $transaction->status = 0;
           }
        $transaction->update($request->all());
        return redirect('transaction');
    }
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        Book::where('id',$transaction->book_id)->update([
            'total' => $transaction->book->total + 1
        ]);
        $transaction->delete();
        return redirect('transaction');
    }
    public function autofill($id)
    {
        return response()->json(Book::findOrFail($id));
    }
}
