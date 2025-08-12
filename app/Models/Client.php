<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// --- IMPORT THESE TWO LINES ---
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Relations\HasMany;
// --- CHANGE `extends Model` to `extends Authenticatable` ---
class Client extends Authenticatable
{
    // --- ADD `Notifiable` TO THE `use` STATEMENT ---
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // This links the client to the business user
        'name',
        'email',
        'phone',
        'password', // The client's own password
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Use the 'hashed' cast for automatic hashing
    ];

    // --- RELATIONSHIPS ---

    /**
     * Get the business user that this client belongs to.
     */
    public function business()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }
     /**
     * Get all of the invoices for the Client.
     *
     * This defines the one-to-many relationship where a Client can have many Invoices.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
