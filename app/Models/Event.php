<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'date', 'location', 'type', 'title', 'managed_at'];
    protected $casts = [
        'managed_at' => 'datetime',
        'date' => 'date',
    ];
    //
    public function tasks()
{
    return $this->hasMany(Task::class);
}
public function guests()
{
    return $this->hasMany(Guest::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function budgets()
{
    return $this->hasMany(Budget::class);
}
}