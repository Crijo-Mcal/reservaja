<?php

namespace public\api\services\client;

use public\api\models\Professional;
use public\api\models\Company;
use public\api\models\Schedule;
use public\api\models\Services;

class Professional_detail_service
{
    private Professional $professionalTable;
    private Company $companyTable;
    private Schedule $scheduleTable;
    private Services $serviceTable;
   
    public function __construct()
    {
        $this->professionalTable = new Professional;
        $this->companyTable = new Company;
        $this->scheduleTable = new Schedule();
        $this->serviceTable= new Services();
    }

    public function allData(int $professional_id)
    {
        $professional_data = $this->professionalTable->selectById($professional_id);
        $schedule_data= $this->scheduleTable->selectAllDataByID($professional_id);
        $service_data= $this->serviceTable->selectActiveServices($professional_id);
        $company_data=$this->companyTable->selectDataForClientViews();
        

        return [
                'professional_data' => $professional_data,
                'company_data' => $company_data,
                'schedule_data' => $schedule_data,
                'service_data' => $service_data
                ];
    }
}
