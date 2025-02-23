<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampEnrollment extends Model
{
    use HasFactory;

    protected $table = 'camp_enrollment'; // Ensure it matches your singular table name

    protected $fillable = [
        'camper_id',
        'week_id',
        'camp_name',
        'time_slot',
    ];

    /**
     * Relationship: Each enrollment belongs to a camper.
     */
    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }

    /**
     * Relationship: Each enrollment belongs to a week.
     */
    public function week()
    {
        return $this->belongsTo(Week::class);
    }
}
