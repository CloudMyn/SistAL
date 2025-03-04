<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements HasAvatar, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar_url',
        'custom_fields',
        'peran',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Apply a global scope to exclude nonactive users.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Apply a global scope to exclude nonactive users
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', '!=', 'BLOCKED');
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->peran == 'DEVELOPER') {
            return true;
        }

        return strtolower($panel->getId()) == strtolower($this->peran);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url("$this->avatar_url") : '/default_pp.png';
    }


    /**
     * Metode Login
     *
     * @param array $credentials
     * @return bool
     */
    public function login(array $credentials)
    {
        $user = static::where('email', $credentials['email'])->first();

        // cek jika password tidak sesuai
        if (!Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        $this->guard()->login($user);

        return true;
    }

    /**
     *  Metode register
     *
     *  @param array $credentials
     *  @return User
     */
    public function register(array $credentials)
    {
        // buat user baru
        $user = static::create([
            'name' => $credentials['name'],
            'username' => $credentials['username'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'peran' => 'PRAKTIKAN',
        ]);

        // return user yang baru dibuat
        return $user;
    }

    /**
     * Summary of isActive
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'ACTIVE';
    }

    public function schedules()
    {
        return $this->hasOne(Schedule::class, 'user_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function praktikan()
    {
        return $this->hasOne(Praktikan::class);
    }
}
