<?php

namespace public\api\services\company;

use public\api\models\Professional;
use public\api\models\Company;

class Profile_service{

    private Professional $professionalTable;
    private Company $companyTable;


    public function __construct()
    {
        $this->professionalTable = new Professional();
        $this->companyTable = new Company();
    }

    public function allData(string $id)
    {
        $professional_data=$this->professionalTable->selectById($id);
        $company_data=$this->companyTable->selectData();

        $data = [
            'profesional_data'=>$professional_data,
            'company_data'=>$company_data
        ];
        
        return $data;
    }

    public function updateProfessionalProfile(int $id, array $data ): bool
    {
        return $this->professionalTable->updateProfile($id, $data);
    }

    public function updateCompanyProfile(array $data): void
    {
        $this->companyTable->updateCompany($data);
    }

    public function saveProfileImg(int $id, array $image, string $appBasePath)
    {

        $temp = $image['tmp_name'];
        $source = '';

        switch ($image['type']) {
            case 'image/png':
                $source = imagecreatefrompng($temp);
                break;
            case 'image/jpeg':
                $source = imagecreatefromjpeg($temp);
                break;
            case 'image/webp':
                $source = imagecreatefromwebp($temp);
                break;
            default:
                return;
        }

        $path = dirname(__DIR__,3) .'/asset/storages/' . $id;

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $output = $path . '/profile.webp';

        imagewebp($source, $output, 85);
        imagedestroy($source);

        $pathDatabase = ($appBasePath).'/asset/storages/' . $id . '/profile.webp';
        $this->professionalTable->updateProfile_image($id, $pathDatabase);
        $_SESSION['user']['profile_image'] = $pathDatabase;
    }

    public function saveLogoImg(int $id, array $image, string $appBasePath)
    {

        $temp = $image['tmp_name'];
        $source = '';

        switch ($image['type']) {
            case 'image/png':
                $source = imagecreatefrompng($temp);
                break;
            case 'image/jpeg':
                $source = imagecreatefromjpeg($temp);
                break;
            case 'image/webp':
                $source = imagecreatefromwebp($temp);
                break;
            default:
                return;
        }

        $path = dirname(__DIR__ ,3) .'/asset/storages/' . $id;

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $output = $path . '/logo.webp';

        imagewebp($source, $output, 85);
        imagedestroy($source);

        $pathDatabase = ($appBasePath).'/asset/storages/' . $id . '/logo.webp';
        $this->companyTable->updateCompanyLogo($pathDatabase);
    }
}
