<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $table = 'week'; // Ensures singular table name

    protected $fillable = [
        'week_number',
        'start_date',
        'end_date',
    ];

    /**
     * Relationship: A week can have many camp enrollments.
     */
    public function campEnrollments()
    {
        return $this->hasMany(CampEnrollment::class, 'week_id');
    }
}
