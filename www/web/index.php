<?php

use Shield1739\UTP\CitasCss\app\backend\controllers\admin\AdminDashboardAjaxController;
use Shield1739\UTP\CitasCss\app\backend\controllers\admin\AdminDashboardController;
use Shield1739\UTP\CitasCss\app\backend\controllers\doctor\DoctorCitasController;
use Shield1739\UTP\CitasCss\app\backend\controllers\doctor\DoctorScheduleCitaController;
use Shield1739\UTP\CitasCss\app\backend\controllers\LogoutController;
use Shield1739\UTP\CitasCss\app\backend\controllers\paciente\PacienteCitasController;
use Shield1739\UTP\CitasCss\app\Config;
use Shield1739\UTP\CitasCss\app\frontend\controllers\cita\ConsultCitaController;
use Shield1739\UTP\CitasCss\app\frontend\controllers\cita\ScheduleCitaAjaxController;
use Shield1739\UTP\CitasCss\app\frontend\controllers\cita\ScheduleCitaController;
use Shield1739\UTP\CitasCss\app\frontend\controllers\HomeController;
use Shield1739\UTP\CitasCss\app\frontend\controllers\LoginController;
use Shield1739\UTP\CitasCss\app\frontend\controllers\RegisterController;
use Shield1739\UTP\CitasCss\core\Application;

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)."/");

$app = new Application(dirname(__DIR__), Config::getConfig($dotenv));

$app->addRoute('/', HomeController::class);
$app->addRoute('/inicio', HomeController::class);
$app->addRoute('/iniciar-sesion', LoginController::class);
$app->addRoute('/cerrar-sesion', LogoutController::class);
$app->addRoute('/registrarse', RegisterController::class);
$app->addRoute('/citas/agendar', ScheduleCitaController::class);
$app->addRoute('/citas/agendar/ajax', ScheduleCitaAjaxController::class);
$app->addRoute('/citas/consultar', ConsultCitaController::class);
$app->addRoute('/paciente/citas', PacienteCitasController::class);
$app->addRoute('/doctor/citas', DoctorCitasController::class);
$app->addRoute('/doctor/cita/agendar', DoctorScheduleCitaController::class);
$app->addRoute('/admin/dashboard', AdminDashboardController::class);
$app->addRoute('/admin/dashboard/ajax', AdminDashboardAjaxController::class);

$app->run();
