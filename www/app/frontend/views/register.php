<?php
/** @var $model Shield1739\UTP\CitasCss\app\frontend\models\RegisterModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
$formBuilder->addEntity('cuenta', $model->cuenta);
$formBuilder->addEntity('paciente', $model->paciente);

?>

<div class="container">
    <div class="row">
        <div class="col-xl-5 d-none d-xl-block text-center m-auto">
            <img class="img-fluid" src="/media/register.png" alt="">
        </div>
        <div class="col-xl-7 col-lg-8 text-center text-primary m-auto">
            <div class="pb-5">
                <h1 class="h2">¡Bienvenido!</h1>
                <h1 class="h3 mb-3 fw-bold">CREA TU CUENTA</h1>
            </div>
            <form data-bitwarden-watching="1" action="" method="post">
                <div class="row gx-3 gy-3 pb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                            <?php echo $formBuilder->renderFloatingInputField('cuentaCedula', 'Cedula', "cuenta") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                            <?php echo $formBuilder->renderFloatingInputField('pacienteNSS', 'Numero de Seguro Social', "paciente") ?>
                        </div>
                    </div>
                </div>
                <div class="row gx-3 gy-3 pb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill fs-3"></i></span>
                            <?php echo $formBuilder->renderFloatingInputField('cuentaNombre', 'Nombre', "cuenta") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group ">
                            <span class="input-group-text"><i class="bi bi-person-fill fs-3"></i></span>
                            <?php echo $formBuilder->renderFloatingInputField('cuentaApellido', 'Apellido', "cuenta") ?>
                        </div>
                    </div>
                </div>
                <div class="row gx-3 gy-3 pb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill fs-3"></i></span>
                            <?php echo $formBuilder->renderFloatingInputField('cuentaCorreo', 'Correo Electronico', "cuenta") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill fs-3"></i></span>
                            <?php echo $formBuilder->renderFloatingInputField('pacienteNumeroContacto', 'Numero de Contacto', "paciente") ?>
                        </div>
                    </div>
                </div>
                <div class="row gx-3 gy-3 pb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar2-date fs-3"></i></span>
                            <?php
                            $nacimientoField = $formBuilder->renderFloatingInputField('pacienteFechaNacimiento', 'Fecha de Nacimiento', "paciente");
                            $nacimientoField->setFieldTypeDate();
                            $nacimientoField->setMax(date('Y-m-d'));
                            echo $nacimientoField;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row gx-3 gy-3 pb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill fs-3"></i></span>
                            <?php
                            $passwordField = $formBuilder->renderFloatingInputField('contrasena', "Contraseña");
                            $passwordField->setFieldTypePassword();
                            echo $passwordField;
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill fs-3"></i></span>
                            <?php
                            $confirmPasswordField = $formBuilder->renderFloatingInputField('confirmarContrasena', "Confirmar Contraseña");
                            $confirmPasswordField->setFieldTypePassword();
                            echo $confirmPasswordField;
                            ?>
                        </div>
                    </div>
                </div>
                <button class="w-auto btn btn-primary btn-lg" type="submit">Registrate</button>
                <p class="mt-5">¿Tienes cuenta? <a class="fw-bold" href="/iniciar-sesion">INICIAR SESION</a></p>
                <p class="mt-5 mb-3 text-muted">© 2021</p>
            </form>
        </div>
    </div>
</div>
