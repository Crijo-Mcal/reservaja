<?php

/*
 * Rotas do perfil do profissional e da empresa (área profissional).
 */

use public\api\controller\company\Profile_controller;

/* ---------- GET ---------- */

// Página do perfil
$router->get(
    '/html/company/profile.php',
    [Profile_controller::class, 'allData'],
    dirname(__DIR__,2). '/html/company/profile.php'
);

/* ---------- POST ---------- */

// Atualizar os dados do profissional
$router->post(
    '/company/profile/updateDataProfessional',
    [Profile_controller::class, 'update_Professional'],
);

// Atualizar os dados da empresa
$router->post(
    '/company/profile/updateDataCompany',
    [Profile_controller::class, 'update_company'],
);

// Alterar a fotografia do profissional
$router->post(
    '/company/profile/profileImage',
    [Profile_controller::class, 'setProfileImage'],
);

// Alterar o logótipo da empresa
$router->post(
    '/company/profile/companyLogo',
    [Profile_controller::class, 'setCompanyLogo'],
);
