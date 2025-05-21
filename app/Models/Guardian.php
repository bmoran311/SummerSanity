<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\GuardianResetPassword;

class Guardian extends Authenticatable
{   
    use HasFactory, Notifiable;    
    
    protected $table = 'guardian';
    protected $fillable = ['first_name', 'last_name', 'email'];   

    public function friends()
    {
        return $this->hasMany(Friend::class, 'guardian_id1')->orWhere('guardian_id2', $this->id);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new GuardianResetPassword($token));
    }
}
