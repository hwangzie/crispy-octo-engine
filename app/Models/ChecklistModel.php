<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * ChecklistModel
 * 
 * Model untuk mengelola daftar checklist pengguna
 * 
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $is_favorite
 * @property bool $is_archived
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */


// ini adalah penerapan OOP yaitu class dengan properties
// class ini juga mewarisi dari model
class ChecklistModel extends Model
{

    /**
     * Nama tabel database
     * dengan @var string
     */

    // ini adalah properties
    protected $table = 'lists';

    /**
     * Kolom yang dapat diisi mass assignment
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'is_favorite',
        'is_archived',
        'order',
    ];


    /**
     * Casting tipe data
     * @var array<string, string>
     */
    protected $casts = [
        'is_favorite' => 'boolean',
        'is_archived' => 'boolean',
    ];
    

    /**
     * Relasi ke User (pemilik checklist)
     * 
     * @return BelongsTo
     */
    // ini merupakan penerapan OOP yaitu public method
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Relasi ke Task (daftar tugas dalam checklist)
     * 
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'list_id');
    }
}
