<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'payment_method', 'transection_id' , 'ip_address', 'order_type',
        'name', 'quantity', 'phone_number', 'shiping_address', 'is_completed', 'is_seen_by_admin'
    ];

    /**
     * Role has many users
     */
    public function books()
    {
        return $this->belongsTo(Book::class);
    }
}
