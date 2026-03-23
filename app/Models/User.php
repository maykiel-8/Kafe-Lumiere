<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
        'role', 'status', 'photo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ── Accessors ────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=C8874A&color=fff';
    }

    // ── Role helpers ─────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCashier(): bool
    {
        return $this->role === 'cashier';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'cashier']);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // ── Relationships ────────────────────────────────────────

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'cashier_id');
    }

    // Purchases the customer made (linked via customer_email on transactions)
    public function purchases()
    {
        return $this->hasMany(Transaction::class, 'customer_user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}