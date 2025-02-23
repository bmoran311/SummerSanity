<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = ['guardian_id1', 'guardian_id2'];

    /**
     * Get the first guardian in the friendship.
     */
    public function guardianOne()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id1');
    }

    /**
     * Get the second guardian in the friendship.
     */
    public function guardianTwo()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id2');
    }

    /**
     * Scope to get all friends of a given guardian.
     */
    public function scopeFriendsOf($query, $guardianId)
    {
        return $query->where('guardian_id1', $guardianId)
                     ->orWhere('guardian_id2', $guardianId);
    }
}
