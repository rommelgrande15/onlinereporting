<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'category','category_id', 'type', 'subject', 'url', 'method', 'ip', 'agent', 'user_id', 'group_id'
    ];
}
