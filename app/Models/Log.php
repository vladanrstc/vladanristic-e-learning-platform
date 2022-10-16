<?php

namespace App\Models;

use App\Traits\LogAttributes;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use LogAttributes;

    protected $table   = 'logs';
    protected $guarded = [];

}
