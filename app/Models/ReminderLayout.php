<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderLayout extends Model
{
    protected $table = 'layouts_reminders';

    protected $fillable = [
        'name',
        'reminder_id',
        'content',
    ];

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}
