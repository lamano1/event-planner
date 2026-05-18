<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['event_id', 'label', 'is_completed', 'due_date'];    
    
}
