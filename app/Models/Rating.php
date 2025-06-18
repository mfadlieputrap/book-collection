<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Book;

class Rating extends Model
{
    protected $fillable = ['book_id', 'rating'];

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
