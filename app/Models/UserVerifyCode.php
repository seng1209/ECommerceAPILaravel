<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerifyCode extends Model
{
    /** @use HasFactory<\Database\Factories\UserVerifyCodeFactory> */
    use HasFactory;

    protected $table = 'user_verify_codes';

    protected $primaryKey = 'user_verify_code_id';

    protected $fillable = ['user_id', 'code', 'expired_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
