<?php

namespace Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'group',
        'value',
        'type'
    ];
}