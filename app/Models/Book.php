<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'ref_book';

    protected $fillable = ['name','genre','total'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class,'book_id');
    }
}
