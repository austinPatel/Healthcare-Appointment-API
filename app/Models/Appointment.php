<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Appointment extends Model
{
    use HasFactory;
    // const ROLE_SUPER_ADMIN = 'super-admin';
    // const ROLE_APP_USER = 'app-user';
    
    const STATUS_BOOKED = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;

    const APPOINTMENT_STATUS = [
        self::STATUS_BOOKED => 'booked',
        self::STATUS_COMPLETED => 'completed',
        self::STATUS_CANCELLED => 'cancelled',
    ];
    protected $fillable = [
        'user_id',
        'healthcare_professionals_id',
        'appointment_start_time',
        'appointment_end_time',
    ];
    public function userAppointment(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
