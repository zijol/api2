<?php

namespace App\Modes;

use Illuminate\Database\Eloquent\Model;

class BaseMode extends Model
{
    protected $connection = 'irt';
}
