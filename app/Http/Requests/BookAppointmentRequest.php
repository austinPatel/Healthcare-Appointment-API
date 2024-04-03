<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_start_time' => 'required|unique:appointments,appointment_start_time,NULL,id,user_id,' . \Auth::id(),
            'appointment_end_time' => 'required|unique:appointments,appointment_end_time,NULL,id,user_id,' . \Auth::id(),
            'healthcare_professionals_id' => 'required'
        ];
    }
}
