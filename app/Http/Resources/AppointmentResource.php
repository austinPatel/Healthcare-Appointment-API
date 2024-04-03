<?php

namespace App\Http\Resources;

use \Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Appointment;
use App\Http\Resources\HealthcareProfessionalResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            'healthcareProfessionals' => new HealthcareProfessionalResource($this->healthcareProfessionals),
            'appointment_start_time' => $this->appointment_start_time,
            'appointment_end_time' => $this->appointment_end_time,
            'status' => $this->getAppointmentStatus($this->status),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
    
        ];
    }
    public function getAppointmentStatus($status){
        $appointmentStatus = Appointment::APPOINTMENT_STATUS;
        return $appointmentStatus[$status];

    }
}
