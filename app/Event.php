<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'title',
        'slug',
        'brief',
        'description',
        'venue',
        'location',
        'date',
        'start_time',
        'end_time',
        'public_price',
        'member_price',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Formats the the endTime field
     *
     * @param  time $value
     * @return mixed null or string
     */
    public function getEndTimeAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return substr($value, 0, 5);
    }

    /**
     * Formats the the startTime field
     *
     * @param  time $value
     * @return mixed null or string
     */
    public function getStartTimeAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return substr($value, 0, 5);
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>=', now()->format('Y-m-d'));
    }

    /**
     * Formats the endTime field for saving
     *
     * @param  string $value
     * @return void
     */
    public function setEndTimeAttribute($value)
    {
        if ($value) {
            $this->attributes['end_time'] = $value . ':00';
        } else {
            $this->attributes['end_time'] = null;
        }
    }

    /**
     * Formats the startTime field for saving
     *
     * @param  string $value
     * @return void
     */
    public function setStartTimeAttribute($value)
    {
        if ($value) {
            $this->attributes['start_time'] = $value . ':00';
        } else {
            $this->attributes['start_time'] = null;
        }
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
