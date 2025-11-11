<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    /** @use HasFactory<\Database\Factories\RuleFactory> */
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function purchasedBy()
    {
        return $this->belongsToMany(User::class, 'user_rules')
            ->withPivot('purchased_at', 'price')
            ->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
