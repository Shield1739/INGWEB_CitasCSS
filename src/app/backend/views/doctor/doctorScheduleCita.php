<?php
/** @var $model Shield1739\UTP\CitasCss\app\backend\models\doctor\DoctorScheduleCitaModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
$formBuilder->addEntity('cita', $model->cita);
$formBuilder->addEntity('citaPacienteInfo', $model->citaPacienteInfo);
?>

<div class="container text-primary">
    <div class="pb-5">
        <h1 class="h3 fw-bold">Agendar Cita</h1>
    </div>
    <div class="container">
        <form action="" method="POST">
            <div class="d-block">
                <h1 class="h3 text-center">
                    Informacion Del Paciente
                </h1>
                <div class="d-block pb-4">
                    <div class="row justify-content-md-center gx-3 gy-3 pb-3">
                        <div class="col-xl-4 col-lg-5 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                                <?php
                                $cedulaField = $formBuilder->renderFloatingInputField('citaPacienteInfoCedula', 'Cedula', "citaPacienteInfo");
                                echo $cedulaField
                                ?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                                <?php
                                $nssField = $formBuilder->renderFloatingInputField('citaPacienteInfoNSS', 'Numero de Seguro Social', "citaPacienteInfo");
                                echo $nssField
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center gx-3 gy-3 pb-3">
                        <div class="col-xl-4 col-lg-5 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill fs-3"></i></span>
                                <?php
                                $nombreField = $formBuilder->renderFloatingInputField('citaPacienteInfoNombre', 'Nombre', "citaPacienteInfo");
                                echo $nombreField
                                ?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill fs-3"></i></span>
                                <?php
                                $apellidoField = $formBuilder->renderFloatingInputField('citaPacienteInfoApellido', 'Apellido', "citaPacienteInfo");
                                echo $apellidoField
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center gx-3 gy-3 pb-3">
                        <div class="col-xl-4 col-lg-5 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill fs-3"></i></span>
                                <?php
                                $correoField = $formBuilder->renderFloatingInputField('citaPacienteInfoCorreo', 'Correo Electronico', "citaPacienteInfo");
                                echo $correoField
                                ?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone-fill fs-3"></i></span>
                                <?php
                                $numeroContactoField = $formBuilder->renderFloatingInputField('citaPacienteInfoNumeroContacto', 'Numero de Contacto', "citaPacienteInfo");
                                echo $numeroContactoField
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block">
                <h1 class="h3 text-center">
                    Fecha y Hora
                </h1>
                <div class="row justify-content-center gx-3 gy-3 pb-3">
                    <div class="col-xl-4 col-lg-5 col-sm-10">
                        <h1 class="h5">
                            Fecha
                        </h1>
                        <div class="d-block">
                            <?php
                            $fechaField = $formBuilder->renderSingleInputField('fecha');
                            $fechaField->setFieldTypeDate();

                            $minDate = new DateTime();
                            $minDate->modify('+1 day');
                            $maxDate = new DateTime();
                            $maxDate->modify('+6 months');

                            $fechaField->setMin($minDate->format('Y-m-d'));
                            $fechaField->setMax($maxDate->format('Y-m-d'));

                            echo $fechaField;
                            ?>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-sm-10">
                        <h1 class="h5">
                            Hora
                        </h1>
                        <div class="d-block">
                            <?php
                            $bloqueHoraSelect = $formBuilder->renderSelectField('bloqueHoraID', $model->getAllHorasOptions());
                            echo $bloqueHoraSelect;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center gx-3 gy-3 pb-3">
                    <div class="col-xl-8 col-lg-10">
                        <h1 class="h5">
                            Motivo
                        </h1>
                        <div class="d-block">
                            <?php
                            $motivoArea = $formBuilder->renderTextAreaField('motivo');
                            echo $motivoArea;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block text-center">
                <button class="btn btn-primary btn-lg" name="submit" type="submit">Agendar Cita</button>
                <input id="doctorIdInput" type="hidden" value="<?php echo $model->doctorID ?>">
            </div>
        </form>
    </div>
</div>
