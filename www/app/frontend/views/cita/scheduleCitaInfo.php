<?php
/** @var $userType */
/** @var $model Shield1739\UTP\CitasCss\app\frontend\models\cita\ScheduleCitaModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
$formBuilder->addEntity('cita', $model->cita);
$formBuilder->addEntity('citaPacienteInfo', $model->citaPacienteInfo);

?>

<div class="container text-primary">
    <div class="pb-5">
        <h1 class="h3 fw-bold">Agendar Cita</h1>
    </div>
    <form id="appointmentForm" action="" method="post">
        <div id="appointmentAccordion" class="accordion">
            <div class="accordion-item">
                <h1 id="infoPacienteHeading" class="accordion-header">
                    <button class="accordion-button <?php echo $model->isStageInfoCita() ? 'collapsed' : '' ?>"
                            type="button" data-bs-toggle="collapse" data-bs-target="<?php echo $model->isStageInfoCita() ? '#infoPaciente' : '' ?>"
                            aria-expanded="<?php echo $model->isStageInfoCita() ? 'false' : 'true' ?>"
                            aria-controls="infoPaciente">
                        <span class="h4">Informacion del Paciente</span>
                    </button>
                </h1>
                <div id="infoPaciente"
                     class="accordion-collapse collapse <?php echo $model->isStageInfoCita() ? '' : 'show' ?>">
                    <div class="accordion-body">
                        <div class="container-sm">
                            <div class="d-block text-center pb-4">
                                <?php if ($model->isStageConfirmInfo()): ?>
                                    <h1 class="h4">Confirme su informacion</h1>
                                <?php elseif ($userType === 2): ?>
                                    <h1 class="h4">¡Sesion Iniciada Correctamente!</h1>
                                <?php else: ?>
                                    <h1 class="h4">Llene los datos solicitados</h1>
                                <?php endif; ?>
                            </div>
                            <div class="d-block pb-4">
                                <div class="row justify-content-md-center gx-3 gy-3 pb-3">
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                                            <?php
                                                $cedulaField = $formBuilder->renderFloatingInputField('citaPacienteInfoCedula', 'Cedula', "citaPacienteInfo");
                                                $cedulaField->setReadOnly(!$model->isStageInfoPaciente());
                                                echo $cedulaField
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                                            <?php
                                                $nssField = $formBuilder->renderFloatingInputField('citaPacienteInfoNSS', 'Numero de Seguro Social', "citaPacienteInfo");
                                                $nssField->setReadOnly(!$model->isStageInfoPaciente());
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
                                                $nombreField->setReadOnly(!$model->isStageInfoPaciente());
                                                echo $nombreField
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-fill fs-3"></i></span>
                                            <?php
                                            $apellidoField = $formBuilder->renderFloatingInputField('citaPacienteInfoApellido', 'Apellido', "citaPacienteInfo");
                                            $apellidoField->setReadOnly(!$model->isStageInfoPaciente());
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
                                            $correoField->setReadOnly(!$model->isStageInfoPaciente());
                                            echo $correoField
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone-fill fs-3"></i></span>
                                            <?php
                                            $numeroContactoField = $formBuilder->renderFloatingInputField('citaPacienteInfoNumeroContacto', 'Numero de Contacto', "citaPacienteInfo");
                                            $numeroContactoField->setReadOnly(!$model->isStageInfoPaciente());
                                            echo $numeroContactoField
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block text-center">
                                <?php if ($userType === 2): ?>
                                    <p class="fs-6">
                                        Si algun dato esta desactualizado, por favor editelo en
                                        <a href="#">Mi Cuenta</a>
                                    </p>
                                <?php elseif($model->isStageInfoPaciente()): ?>
                                    <button name="submit" class="btn btn-primary btn-lg" type="submit">Siguiente</button>
                                <?php else: ?>
                                    <button name="reset" value="<?php echo $model::STAGE_INFO_PACIENTE?>" class="btn btn-secondary btn-lg" type="submit">Editar Informacion</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item" <?php echo $model->isStageInfoPaciente() ? 'hidden' : ''?>>
                <h1 id="infoCitaHeading" class="accordion-header">
                    <button class="accordion-button"
                            type="button" data-bs-toggle="collapse" data-bs-target="#infoCita"
                            aria-expanded="true" aria-controls="infoCita">
                        <span class="h4">Informacion de la Cita</span>
                    </button>
                </h1>
                <div id="infoCita" class="accordion-collapse collapse show"
                     aria-labelledby="infoCitaHeading">
                    <div class="accordion-body">
                        <div class="container-sm">
                            <div class="d-block text-center pb-3">
                                <?php if ($model->isStageConfirmInfo()): ?>
                                    <h1 class="h4">Confirme su informacion</h1>
                                <?php else: ?>
                                    <h1 class="h4">Llene los datos solicitados</h1>
                                <?php endif; ?>
                            </div>
                            <div class="d-block">
                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Clinica
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $clinicaSelect = $formBuilder->renderSelectField('clinicaID', $model->getAllClinicasOptions());
                                            $clinicaSelect->setLiveSearch(true);

                                            if ($model->isStageConfirmInfo())
                                            {
                                                $clinicaSelect->setDisabled(true);

                                                $clinicaField = $formBuilder->renderSingleInputField('clinicaID');
                                                $clinicaField->setHidden(true);
                                                echo $clinicaField;
                                            }

                                            echo $clinicaSelect;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">

                                    </div>
                                </div>
                                <div class="row justify-content-center gx-3 gy-3 pb-3">
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Especialidad
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $especialidadSelect = $formBuilder->renderSelectField('especialidadID', $model->getAllEspecialidadesOptions());
                                            $especialidadSelect->setLiveSearch(true);

                                            if ($model->isStageConfirmInfo())
                                            {
                                                $especialidadSelect->setDisabled(true);

                                                $especialidadField = $formBuilder->renderSingleInputField('especialidadID');
                                                $especialidadField->setHidden(true);
                                                echo $especialidadField;
                                            }

                                            echo $especialidadSelect;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-5 col-sm-10">
                                        <h1 class="h5">
                                            Doctor
                                        </h1>
                                        <div class="d-block">
                                            <?php
                                            $doctorSelect = $formBuilder->renderSelectField('doctorID', $model->getAllDoctoresOptions());
                                            $doctorSelect->setLiveSearch(true);

                                            if ($model->isStageConfirmInfo())
                                            {
                                                $doctorSelect->setDisabled(true);

                                                $doctorField = $formBuilder->renderSingleInputField('doctorID');
                                                $doctorField->setHidden(true);
                                                echo $doctorField;
                                            }

                                            echo $doctorSelect;
                                            ?>
                                        </div>
                                    </div>
                                </div>
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

                                            if ($model->isStageConfirmInfo())
                                            {
                                                $fechaField->setReadOnly(true);
                                            }

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

                                            if ($model->isStageConfirmInfo())
                                            {
                                                $bloqueHoraSelect->setDisabled(true);

                                                $bloqueHoraField = $formBuilder->renderSingleInputField('bloqueHoraID');
                                                $bloqueHoraField->setHidden(true);
                                                echo $bloqueHoraField;
                                            }

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

                                            if  ($model->isStageConfirmInfo())
                                            {
                                                $motivoArea->setReadOnly(true);
                                            }

                                            echo $motivoArea;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block text-center">
                                <?php if($model->isStageInfoCita()): ?>
                                    <button name="submit" class="btn btn-primary btn-lg" type="submit">Siguiente</button>
                                <?php elseif($model->isStageConfirmInfo()): ?>
                                    <button name="reset" value="<?php echo $model::STAGE_INFO_CITA?>" class="btn btn-secondary btn-lg" type="submit">Editar Informacion</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($model->isStageConfirmInfo()): ?>
            <div class="d-block py-3 text-center">
                <button name="submit" class="btn btn-primary btn-lg" type="submit">Solicitar Cita</button>
            </div>
        <?php endif; ?>
    </form>
</div>