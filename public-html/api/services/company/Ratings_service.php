<?php

namespace public\api\services\company;


use public\api\models\appointments;
use public\api\models\Professional;
use public\api\models\Ratings;

class Ratings_service
{

    private appointments\Validation $appointment_validation;
    private Professional $professional;
    private Ratings $ratingsTable;

    public function __construct()
    {
        $this->appointment_validation = new appointments\Validation();
        $this->professional = new Professional();
        $this->ratingsTable = new Ratings();
    }

    public function alltData(array $data, int $professional_id): array
    {

        $professionals = $this->professional->selectAllNamesProfessionals();

        if ($data['professional'] && $data['professional'] == 'all') {
            $allData = $this->ratingsTable->getAll();

            return [
                'professionals' => $professionals,
                'rating_data' => $allData,
            ];
        }


        if ($data['professional'] && $data['professional'] !== 'all') {
            $rating_data = $this->ratingsTable->getByProfessionalId($data['professional']);
            return [
                'professionals' => $professionals,
                'rating_data' => $rating_data,
            ];
        }

        $rating_data = $this->ratingsTable->getByProfessionalId($professional_id);
        return [
            'professionals' => $professionals,
            'rating_data' => $rating_data
        ];
    }


    public function insertData(array $data_input): void
    {
        $isRatingsExist = $this->ratingsTable->isRatingExist($data_input['appointment_id']);
        $isClientIdExist = $this->appointment_validation->isClientIdExist($data_input['appointment_id']);


        if (!$isRatingsExist && $isClientIdExist) {
            $this->ratingsTable->insert($data_input['appointment_id'], $data_input['booking_id']);
        }
    }

    public function updateRating(array $data_input): void
    {
        $this->ratingsTable->updateRating($data_input);
    }

    public function deleteRating(array $data_input): void
    {
        $this->ratingsTable->delete($data_input);
    }
}
