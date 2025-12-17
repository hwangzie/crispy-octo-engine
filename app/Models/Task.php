<?php

namespace App\Models;

use App\Contracts\Displayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    // ini adalah sebuah tipe data array
    protected $fillable = [
        'list_id',
        'title',
        'description',
        'completed',
        'order',
    ];

    protected $casts = [
        // ini adalah sebuah tipe data boolean
        'completed' => 'boolean',
    ];

    // Polymorphism pada getDisplayName
    public function getDisplayName(): string
    {
        return $this->completed ? "✓ {$this->title}" : $this->title;
    }
    
    public function list(): BelongsTo
    {
        return $this->belongsTo(ChecklistModel::class, 'list_id');
    }
}
