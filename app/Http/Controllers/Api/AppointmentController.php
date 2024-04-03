<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\BookAppointmentRequest;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AppointmentResource;

class AppointmentController extends ApiController
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository){
        $this->appointmentRepository = $appointmentRepository;
    }

    /*
        Booking appointment
    */
    public function store(Request $request){
        try{
            $response= $this->appointmentRepository->bookAppointment($request->all());
            if(!$response){
                return $this->sendError('Your Appointment time is not available');
            }    
            return $this->sendResponse($response, 'Your Appointment is successfully booked');        
        }catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    /*
        View All the Heathcare Appointments of user
        Create Request Pameter for future filter by Healthcare Professional,Date filter etc.
    */
    public function index(Request $request){
        try{
            $user_id = Auth::user()->id;
            $response= $this->appointmentRepository->getAllAppointmentsUser($request->all(),$user_id);
            $data = AppointmentResource::collection($response);

            return $this->sendResponse($data, 'User Appointments'); 
        }catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
        
    }

    /*

        Cancelled the user appointment
    */
    public function cancelled(Request $request){

        try{
            $response= $this->appointmentRepository->cancelled($request->all());
            if(!$response){
                return $this->sendError('Appointment not allowed to cancelled within 24 hour');
            }
            return $this->sendResponse($response, 'Your Appointments has been Cancelled');
        }catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
  

    }
    /*
        Complete the user appointment and update the status completed
    */
    public function complete(Request $request){

        try{
            $response= $this->appointmentRepository->complete($request->all());
            if(!$response){
                return $this->sendError('Appointment does not completed');
            }
            return $this->sendResponse($response, 'Your Appointments has been completed');
        }catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
  

    }
}
