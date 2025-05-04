<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitation';

    protected $fillable = [
        'guardian_id',
        'email',
        'status',
        'guardian_id2',
    ];

    public function inviter()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function invitee()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id2');
    }
}