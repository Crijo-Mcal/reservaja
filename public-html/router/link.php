<?php
require_once __DIR__ . '/vendor/autoload.php';
date_default_timezone_set('Europe/Lisbon');

use Dotenv\Dotenv;


session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


/* routers */
use public\router\Router;
$appBasePath = dirname($_SERVER['SCRIPT_NAME']);
$router = new Router($appBasePath);


require_once __DIR__ . '/router/company/dashboard_router.php';
require_once __DIR__ . '/router/company/profile_router.php';
require_once __DIR__ . '/router/company/services_router.php';
require_once __DIR__ . '/router/company/schedules_router.php';
require_once __DIR__ . '/router/company/appointments_router.php';
require_once __DIR__ . '/router/company/clients_router.php';
require_once __DIR__ . '/router/company/payments_router.php';
require_once __DIR__ . '/router/company/ratings_router.php';
require_once __DIR__ . '/router/company/professionals_router.php';

require_once __DIR__ . '/router/client/professionals_router.php';
require_once __DIR__ . '/router/client/professional_detail_router.php';
require_once __DIR__ . '/router/client/booking_router.php';
require_once __DIR__ . '/router/client/payment_router.php';
require_once __DIR__ . '/router/client/history_router.php';
require_once __DIR__ . '/router/client/profile_router.php';
require_once __DIR__ . '/router/client/home_router.php';
require_once __DIR__. '/router/client/activePayment_router.php';

require_once __DIR__.'/router/auth_router.php';
require_once __DIR__ .'/router/callback_router.php';


$router->dispatch();
