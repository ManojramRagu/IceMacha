<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $primaryKey = 'MessageId';
    public $timestamps = false;

    protected $fillable = [
        'UserId',
        'FirstName',
        'LastName',
        'Email',
        'Subject',
        'Message',
    ];

    //
}
