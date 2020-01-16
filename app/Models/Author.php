<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class author extends Model
{
    public function books()
    {
      return $this->hasMany(Book::class);
    }
    
    protected $fillable = [
        'name', 'description', 'image'
    ];
}
