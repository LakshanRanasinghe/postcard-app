<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcard extends Model
{
    protected $fillable = ['card_id', 'name', 'email', 'message', 'duration'];
}
