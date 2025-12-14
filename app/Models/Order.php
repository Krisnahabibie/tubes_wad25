<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'invoice_code', 'total_price', 'status'
    ];

    // Relasi: Order milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Order punya banyak item
    // Pastikan kamu juga membuat model OrderItem.php!
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
