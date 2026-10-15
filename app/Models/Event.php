<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'category', 'ticket_price', 'description', 'image'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
