<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\HealthcareProfessionalRepository;
use Exception;


class HealthcareProfessionalController extends ApiController
{
    protected $healthcareProfessionalRepo;

    public function __construct(HealthcareProfessionalRepository $healthcareProfessionalRepo){
        $this->healthcareProfessionalRepo = $healthcareProfessionalRepo;
    }

    /*
        get all the Healthcare Professional data and we can filter the data by name and specialty
        Query Parameters : name and specialty
    */
    public function index(Request $request){
        try
        {
            $healthcareProfessionals= $this->healthcareProfessionalRepo->getHealthcareProfessional($request);
            return $this->sendResponse($healthcareProfessionals, 'Healthcare Professionals');
        }catch (ValidationException $error) {
            return $this->sendError($error->getMessage(), $error, 500);
        }
    }
}
