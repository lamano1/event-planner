<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
    protected $fillable = ['event_id', 'item_name', 'category', 'amount', 'actual_amount', 'is_paid'];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
}
