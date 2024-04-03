<?php

namespace App\Repositories;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;

class AppointmentRepository{

    /* 
        Description: Booking Appointment with Healthcare Professionals
    */
    public function bookAppointment(array $data){
        $availableSlotAppointment= $this->checkAppointment($data);
        // count > 0 that means there is no time slot appointment booking otherwise booked
        if($availableSlotAppointment > 0){
            return false;
        }
        $data['status']= 1;
        $data['user_id']= Auth::user()->id;
        $appointment=Appointment::create($data); // Appointment booking created
        return $appointment;
    }

    /*
        Description: Check the availability Time slot booking appointment
    */
    public function checkAppointment(array $data){

        $appointment_start_time = $data['appointment_start_time'];
        $appointment_end_time = $data['appointment_end_time'];
        
        // $appointment_qr = Appointment::whereBetween('appointment_start_time', [$appointment_start_time,$appointment_end_time]);
        // $appointment_qr->orWhereBetween('appointment_end_time',[$appointment_start_time,$appointment_end_time]);
        // check with healthcare profressional
        // $appointment_qr->where('healthcare_professionals_id',$data['healthcare_professionals_id'])->get();
        // db::enableQueryLog();
        $appointment_qr= Appointment::where(function($query) use($appointment_start_time,$appointment_end_time){
            // check with time slot availability start time and endtime
            $query->where('appointment_start_time',">=",$appointment_start_time);
            $query->where('appointment_start_time',"<=",$appointment_end_time)
                    ->orWhere('appointment_end_time',">=",$appointment_start_time)
                    ->where('appointment_end_time','<=',$appointment_end_time);

            // check with healthcare profressional
        })->where('healthcare_professionals_id',$data['healthcare_professionals_id'])->get();
        // dd(DB::getQueryLog());
        // exit;
        $total = $appointment_qr->count(); // count > 0 that means there is no time slot appointment booking otherwise booked
        return $total;

    }

    /*
        View All the Heathcare Appointments of user
        $data argument passed for the filter with status, appointment time,healthcare professional
    */
    public function getAllAppointmentsUser(array $data,$user_id){

        /*
            if you dont want to show the cancelled appointment then used below commented line otherwise it will all appointment
        */
        // $appointments = Appointment::where('user_id',$user_id)->whereNotIn('status',[Appointment::STATUS_CANCELLED])->orderBy('appointment_start_time','ASC')->get();
        $appointments = Appointment::where('user_id',$user_id)->orderBy('appointment_start_time','ASC')->get();

        return $appointments;
    }

    /*
        Description: Cancel an appointment (with constraints, e.g., not allowed within 24 hours of the appointment time).
    */
    public function cancelled($request){
        $user_id = Auth::user()->id;
        $appointment_id = $request['appointment_id'];
        // get the created_at date for the calculation of 24 hours appointment not allowed to cancelled
        $checkAppointment = Appointment::where('id',$appointment_id)->where('user_id',$user_id)->first();
        // Calculated Total hours from created_at datetime with current date time
        $now = Carbon::now();
        $created_at = Carbon::parse($checkAppointment->created_at);
        $diffHours = $created_at->diffInHours($now);

        if($diffHours>24){
            $cancelledAppointment = Appointment::where('id', $appointment_id)->where('user_id',$user_id)->update(['status'=>Appointment::STATUS_CANCELLED]);
            return true;
        }
        return false;


    }

    /*
        Description: Make an appointment as completed
    */
    public function complete($request){
        $user_id = Auth::user()->id;
        $appointment_id = $request['appointment_id'];
        $cancelledAppointment = Appointment::where('id', $appointment_id)->where('user_id',$user_id)->update(['status'=>Appointment::STATUS_COMPLETED]);
        return $cancelledAppointment ? true : false;
    }
}