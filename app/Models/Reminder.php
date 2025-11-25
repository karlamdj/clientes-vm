<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';
    protected $fillable = ['name'];


    public function layouts()
    {
        return $this->belongsToMany(Layout::class, 'layout_reminder');
    }
}
