<?php

namespace public\api\services\client;

use public\api\models\Professional;
use public\api\models\Ratings;

class Professionals_service
{
    private Professional $professionalTable;
    private Ratings $ratingsTable;

    public function __construct()
    {
        $this->professionalTable = new Professional();
        $this->ratingsTable = new Ratings();
    }

    public function showAllData(array $data_input)
    {

        $allSpeciality = $this->professionalTable->selectAllSpeciality();
        $ratings_data =  isset($data_input['client_id']) ? $this->ratingsTable->getByClientId($data_input['client_id']) : null;

 
        if ($data_input['professional_name'] === '' && $data_input['professional_speciality'] === '') {

            $allData = $this->professionalTable->selectAllData();
            return [
                'professionals' => $allData,
                'allspeciality' => $allSpeciality,
                'rating_data' => $ratings_data
            ];
        }

        if ($data_input['professional_name'] != "" && $data_input['professional_speciality'] == "") {
            $allData = $this->professionalTable->selectByName($data_input['professional_name']);
            return [
                'professionals' => $allData,
                'allspeciality' => $allSpeciality,
                'rating_data' => $ratings_data
            ];
        }


        if ($data_input['professional_speciality'] != "" && $data_input['professional_name']=='') {
            $allData = $this->professionalTable->selectBySpeciality($data_input['professional_speciality']);
            return [
                'professionals' => $allData,
                'allspeciality' => $allSpeciality,
                'rating_data' => $ratings_data
            ];
        }

        if ($data_input['professional_name'] !== '' && $data_input['professional_speciality'] !== '') {
            $allData = $this->professionalTable->selectBySpecialityAndName($data_input['professional_speciality'],$data_input['professional_name']);
            return [
                'professionals' => $allData,
                'allspeciality' => $allSpeciality,
                'rating_data' => $ratings_data
            ];
        }
    }
}
