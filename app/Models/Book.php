<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function category()
    {
       return $this->belongsTo(Category::class);
    }

    public function author()
    {
       return $this->belongsTo(Author::class);
    }
    
    public function publisher()
    {
       return $this->belongsTo(Publisher::class);
    }

    /**
     * Role has many users
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

     /**
     * Role has many users
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    protected $fillable = [
        'title', 'category_id', 'summary', 'country', 'stock', 'rating', 'old_price', 'new_price', 'page', 'description', 
        'cover', 'author_id', 'language', 'publisher_id', 'discount', 'upcoming'
    ];
}
