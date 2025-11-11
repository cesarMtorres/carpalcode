<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'github_id',
        'github_login',
        'access_token',
        'is_valid',
    ];

    protected $hidden = [
        'access_token',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
