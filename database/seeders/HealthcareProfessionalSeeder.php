<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\HealthcareProfessional;

class HealthcareProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $healthcareProfessional =[
            [
                'name' => 'Nitin Patel',
                'specialty' => 'Ophthalmologist'
            ],
            [
                'name' => 'Snehal Desai',
                'specialty' => 'ENT Otorhinolaryngologist'
            ],
            [
                'name' => 'Keyur Thakor',
                'specialty' => 'Physician'
            ],
            [
                'name' => 'Ritesh Das',
                'specialty' => 'Orthopedic'
            ],
            [
                'name' => 'Kirit Shah',
                'specialty' => 'Neurosurgeon'
            ],
        ];
        foreach ($healthcareProfessional as $key => $value) {
            HealthcareProfessional::create([
                'name' => $value['name'],
                'specialty' => $value['specialty']
            ]);
        }
    }
}
