<?php
/** @var $model Shield1739\UTP\CitasCss\app\frontend\models\LoginModel */

use Shield1739\UTP\CitasCss\core\forms\FormBuilder;

$formBuilder = new FormBuilder($model);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-8 text-center text-primary m-auto">
            <div class="pb-5">
                <h1 class="h2">¡Bienvenido!</h1>
                <h1 class="h3 mb-3 fw-bold">INGRESA A TU CUENTA</h1>
            </div>
            <form data-bitwarden-watching="1" action="" method="post">
                <div class="input-group pb-2">
                    <span class="input-group-text"><i class="bi bi-person-badge fs-3"></i></span>
                    <?php echo $formBuilder->renderFloatingInputField('cedula', "Cedula"); ?>
                </div>
                <div class="input-group pb-2">
                    <span class="input-group-text"><i class="bi bi-lock-fill fs-3"></i></span>
                    <?php
                    $passwordField = $formBuilder->renderFloatingInputField('contrasena', "Contraseña");
                    $passwordField->setFieldTypePassword();
                    echo $passwordField;
                    ?>
                </div>
                <div class="checkbox mb-3 text-end">
                    <label>
                        <input type="checkbox" value="acuerdame"> Acuerdame
                    </label>
                </div>
                <button class="w-auto btn btn-primary btn-lg" type="submit">Iniciar Sesion</button>
                <p class="mt-5">¿No tienes cuenta? <a class="fw-bold" href="/registrarse">REGISTRATE AQUÍ</a></p>
                <p class="mt-5 mb-3 text-muted">© 2021</p>
            </form>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
            <img class="img-fluid" src="/media/login.png" alt="">
        </div>
    </div>
</div>
