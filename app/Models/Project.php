<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'repository_url',
        'status',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
    }

    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'project_rules')
            ->withPivot('applied_at')
            ->withTimestamps();
    }
}
