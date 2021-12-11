<?php


// r[($HX=@ka(T
// UzECUwm6@?,Q

// SSH
// M?D:hgdia8]#
// MYSQL
// u^XML00X2[,z
require_once __DIR__ . "/../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaExtendedEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaPacienteInfoEntity;
use Shield1739\UTP\CitasCss\app\entities\ClinicaEntity;
use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\app\entities\EspecialidadEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\Application;
use Shield1739\UTP\CitasCss\core\Utilities;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;
use Shield1739\UTP\CitasCss\fluentpdo\Query;

$pdo = new PDO("mysql:host=localhost;port=3306;dbname=citascss", "root", "sa");

$fluent = new Query($pdo);

$x = $fluent
    ->from(DoctorEntity::getTableName())
    ->select('doctor_especialidad.*')
    ->where(DoctorEntity::getPrimaryKey(), 1)
    ->innerJoin(DoctorEntity::getJoin(DoctorEntity::DOCTOR_ESPECIALIDAD))
    ->fetch();

var_dump($x);


//Utilities::sendMail('luisfervf@gmail.com', 'TEST', "TEST");
