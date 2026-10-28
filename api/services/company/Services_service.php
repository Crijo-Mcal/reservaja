<?php

namespace public\api\services\company;

use public\api\models\Services;

class Services_service
{
    private Services $servicesTable;

    public function __construct()
    {
        $this->servicesTable = new Services();
    }

    public function addNewService(array $data): void
    {
        $this->servicesTable->insert(
            $data['professional_id'],
            $data['name'],
            $data['description'],
            $data['duration'],
            $data['price'],
            $data['vat'],
            $data['advance_payment'],
            $data['status']
        );
    }

    public function showData(int $professional_id): ?array
    {
        $result = $this->servicesTable->selectAllServices($professional_id);
        return $result;
    }

    public function filterData(string $search): ?array
    {
        $result = $this->servicesTable->selectDataByName($search);
        return $result;
    }

    public function updateData(int $professional_id, array $data): bool
    {
        return $this->servicesTable->updateAllData($professional_id, $data);
    }

    public function deleteData(int $professional_id, int $service_id): bool
    {
        return $this->servicesTable->deleteData($professional_id, $service_id);
    }
}
