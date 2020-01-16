<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'book_id', 'quantity', 'price'
    ];

     /**
     * Role has many users
     */
    public function books()
    {
        return $this->belongsTo(Book::class);
    }
}
