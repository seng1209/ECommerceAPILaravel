<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $primaryKey = 'token_id';

    protected $fillable = [ 'user_id', 'token', 'expiry_at'];
}
