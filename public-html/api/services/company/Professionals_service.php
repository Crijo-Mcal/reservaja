<?php

namespace public\api\services\company;


use public\api\models\Professional;


class Professionals_service
{

    private Professional $professionalTable;

    public function __construct()
    {
        $this->professionalTable = new Professional();
    }

    public function alltData(): array
    {
        $professionals_data = $this->professionalTable->getAllProfessionals();
        return $professionals_data;
    }

    public function updateProfessionalProfile(int $id, array $data ): bool
    {
        return $this->professionalTable->updateProfileForOwner($id, $data);
    }
}
