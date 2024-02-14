<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubAgenda extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];

    public function meetingAagenda() : BelongsTo
    {
        return $this->belongsTo(MeetingAgenda::class);
    }
}
