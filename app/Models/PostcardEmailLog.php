<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostcardEmailLog extends Model
{
    protected $fillable = ['postcard_id', 'email'];
}
