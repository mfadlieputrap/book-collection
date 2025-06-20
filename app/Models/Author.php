<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Book;

class Author extends Model
{
    protected $fillable = ['name'];

    public function books(){
        return $this->hasMany(Book::class, 'author_id');
    }
}
