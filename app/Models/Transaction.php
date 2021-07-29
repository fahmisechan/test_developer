<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'trans_transaction';

    protected $fillable = ['code','user_id','book_id','borrow_date','due_date','status'];

    public function book()
    {
        return $this->belongsTo(Book::class,'book_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function setBorrowDateAttribute($value)
    {
        $this->attributes['borrow_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
