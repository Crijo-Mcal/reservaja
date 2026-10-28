<?php

use public\api\controller\company\Profile_controller;

$router->get(
    '/html/company/profile.php',
    [Profile_controller::class, 'allData'],
    dirname(__DIR__,2). '/html/company/profile.php'
);


$router->post(
    '/company/profile/updateDataProfessional',
    [Profile_controller::class, 'update_Professional'],
);

$router->post(
    '/company/profile/updateDataCompany',
    [Profile_controller::class, 'update_company'],
);

$router->post(
    '/company/profile/profileImage',
    [Profile_controller::class, 'setProfileImage'],
);

$router->post(
    '/company/profile/companyLogo',
    [Profile_controller::class, 'setCompanyLogo'],
);
