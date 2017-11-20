<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dates = [
        'date'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>=', now()->format('Y-m-d'));
    }

    /**
     * Gets the total price of an event
     * @param  integer $guests
     * @param  boolean $membersPrice
     * @return float
     */
    public function totalPrice($guests = 1, $membersPrice = false)
    {
        $price = $this->public_price;
        if ($membersPrice) {
            $price = $this->member_price;
        }

        return $price * $guests;
    }
}
