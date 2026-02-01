<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = ['contact_message_id', 'message'];

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }
}
