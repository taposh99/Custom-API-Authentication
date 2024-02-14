<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingAgenda extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function subAgenda()
    {

        return $this->hasMany(SubAgenda::class);
    }
}
