<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';
    protected $primaryKey = 'MessageId';
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null; // Assuming no UpdatedAt or not needed

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'Subject',
        'Message',
    ];

    // Map Accessors
    public function getNameAttribute()
    {
        return trim(($this->attributes['FirstName'] ?? '') . ' ' . ($this->attributes['LastName'] ?? ''));
    }

    public function getEmailAttribute()
    {
        return $this->attributes['Email'] ?? '';
    }

    public function getSubjectAttribute()
    {
        return $this->attributes['Subject'] ?? '';
    }

    public function getMessageAttribute()
    {
        return $this->attributes['Message'] ?? '';
    }

    public function getIsReadAttribute()
    {
        return $this->attributes['IsRead'] ?? false;
    }
}
