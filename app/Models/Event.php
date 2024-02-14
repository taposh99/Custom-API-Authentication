<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function meetingMinute(): HasMany
    {
        return $this->hasMany(MeetingMinute::class);
    }

    public function meetingAgenda()
    {
        return $this->hasMany(MeetingAgenda::class);
    }

  
}
