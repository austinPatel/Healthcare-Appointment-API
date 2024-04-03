<?php
namespace App\Repositories;

use App\Models\HealthcareProfessional;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HealthcareProfessionalRepository{

    /*
        Get the data of healthcare professionals
        we can used the filter by the specialty and name for getting specific professional
        $request - used for the filter by passing the parameters as above name or specialty
    */
    public function getHealthcareProfessional($request){

        $query = HealthcareProfessional::select('id','name','specialty');
        $searchByName = $request['name'] ?? null;
        $searchBySpecialty = $request['specialty'] ?? null;
        if ($searchByName) {
            $query = $query->where('name', 'LIKE',"%{$searchByName}%");
        }
        if ($searchBySpecialty) {
            $query = $query->orWhere('specialty', 'LIKE',"%{$searchBySpecialty}%");
        }
        $healthcareProfessionals = $query->orderBy('name','asc')->get();
        return $healthcareProfessionals;
    }
}