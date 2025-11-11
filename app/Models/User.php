<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    // Relaciones
    public function githubTokens()
    {
        return $this->hasMany(GithubToken::class);
    }

    public function githubExecutions()
    {
        return $this->hasMany(GithubExecution::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    public function purchasedRules()
    {
        return $this->belongsToMany(Rule::class, 'user_rules')
            ->withPivot('purchased_at', 'price')
            ->withTimestamps();
    }

    // Método para obtener estadísticas del usuario
    protected function getStatsAttribute(): array
    {
        return [
            'total_projects' => $this->projects()->count(),
            'total_repositories' => $this->githubExecutions()->distinct('repo_name')->count(),
            'successful_clones' => $this->githubExecutions()->where('status', 'completed')->count(),
            'purchased_rules_count' => $this->purchasedRules()->count(),
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
}
