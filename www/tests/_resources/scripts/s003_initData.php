<?php

class s003_initData
{
    public function up(): string
    {
        $password = password_hash('aa', PASSWORD_BCRYPT);
        return /** @lang SQL */ "
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (1, 'sa@sa.a', '0-0-0', '$password', 'Admin', 'Admin');
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'luis.villalaz1@utp.ac.pa', '1-1-1', '$password', 'Juan', 'Valdez'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-1', '12345678', '2000-01-01');
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'paciente2@sa.a', '1-1-2', '$password', 'NombreP2', 'ApellidoP2'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-2', '698745123', '2000-02-02');
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'paciente3@sa.a', '1-1-3', '$password', 'NombreP3', 'ApellidoP3'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-3', '2233445566', '2000-02-02');

            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor1@sa.a', '8-999-1', '$password', 'Manuel', 'Osas'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor2@sa.a', '8-999-2', '$password', 'Vanessa', 'Patrick'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor3@sa.a', '8-999-3', '$password', 'Diego', 'Pinto'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor4@sa.a', '8-999-4', '$password', 'Samuel', 'Villareal'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor6@sa.a', '8-999-6', '$password', 'Jessica', 'Gimenez'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor7@sa.a', '8-999-7', '$password', 'Martin', 'Osorio'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor8@sa.a', '8-999-8', '$password', 'Carlos', 'Feng'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor9@sa.a', '8-999-9', '$password', 'Oriel', 'Molina'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor10@sa.a', '8-999-10', '$password', 'Luigina', 'Martinez'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor11@sa.a', '8-999-11', '$password', 'Angel', 'Bernabeu'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor12@sa.a', '8-999-12', '$password', 'Alvaro', 'Rico'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor13@sa.a', '8-999-13', '$password', 'Ernesto', 'Castellano'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor14@sa.a', '8-999-14', '$password', 'Natalia', 'Bilbao'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor15@sa.a', '8-999-15', '$password', 'Ester', 'Benito'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor16@sa.a', '8-999-16', '$password', 'Simon', 'Llamas'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor17@sa.a', '8-999-17', '$password', 'Jose', 'Singh'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor18@sa.a', '8-999-18', '$password', 'Pedro', 'Singh'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor19@sa.a', '8-999-19', '$password', 'Sofia', 'Moreno'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor20@sa.a', '8-999-20', '$password', 'Irina', 'Moran'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 2);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor21@sa.a', '8-999-21', '$password', 'Mia', 'Amador'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor22@sa.a', '8-999-22', '$password', 'Montserrat', 'Nieves'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor23@sa.a', '8-999-23', '$password', 'Daniel', 'Miralles'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor24@sa.a', '8-999-24', '$password', 'Alfonso', 'Ros'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor25@sa.a', '8-999-25', '$password', 'Jon', 'Lloret'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor26@sa.a', '8-999-26', '$password', 'Flor', 'Ruz'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor27@sa.a', '8-999-27', '$password', 'Paulo', 'Jara'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor28@sa.a', '8-999-28', '$password', 'Anastasia', 'Pazos'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor29@sa.a', '8-999-29', '$password', 'Jose', 'Lago'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor30@sa.a', '8-999-30', '$password', 'Maria', 'Lago'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 3);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor31@sa.a', '8-999-31', '$password', 'Tomas', 'Heredia'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor32@sa.a', '8-999-32', '$password', 'Matilde', 'Navas'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor33@sa.a', '8-999-33', '$password', 'Angelica', 'Tomas'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor34@sa.a', '8-999-34', '$password', 'Ines', 'Veiga'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor35@sa.a', '8-999-35', '$password', 'Xavier', 'Ferrer'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor36@sa.a', '8-999-36', '$password', 'Ramon', 'Dominguez'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor37@sa.a', '8-999-37', '$password', 'Christian', 'Carrero'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor38@sa.a', '8-999-38', '$password', 'Noah', 'Alemany'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor39@sa.a', '8-999-39', '$password', 'Mariano', 'Cristobal'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor40@sa.a', '8-999-40', '$password', 'Nina', 'Duque'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 4);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor41@sa.a', '8-999-41', '$password', 'Miguel', 'Juarez'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor42@sa.a', '8-999-42', '$password', 'Narciso', 'Villalba'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 1);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor43@sa.a', '8-999-43', '$password', 'Karim', 'Varela'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor44@sa.a', '8-999-44', '$password', 'Claudia', 'Valera'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 2);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor45@sa.a', '8-999-45', '$password', 'Estela', 'España'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor46@sa.a', '8-999-46', '$password', 'Octavio', 'Reig'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor47@sa.a', '8-999-47', '$password', 'Esmeralda', 'Tema'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor48@sa.a', '8-999-48', '$password', 'Luz', 'Polo'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 4);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor49@sa.a', '8-999-49', '$password', 'Elsa', 'Zeng'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);
            
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor50@sa.a', '8-999-50', '$password', 'Yoel', 'Andrade'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 5);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 5);            

            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
               VALUE (3, 'doctor5@sa.a', '8-999-5', '$password', 'Eduardo', 'Amador'); 
            INSERT INTO doctor (doctorCuentaID, doctorClinicaID) VALUE (LAST_INSERT_ID(), 1);
            INSERT INTO doctor_especialidad (doctorEspecialidadDoctorID, doctorEspecialidadEspecialidadID) VALUE (LAST_INSERT_ID(), 3);

            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'paciente4@sa.a', '1-1-4', '$password', 'NombreP4', 'ApellidoP4'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-4', '2233445566', '2000-02-02');
                
            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'paciente5@sa.a', '1-1-5', '$password', 'NombreP5', 'ApellidoP5'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-5', '2233445566', '2000-02-02');

            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'paciente6@sa.a', '1-1-6', '$password', 'NombreP6', 'ApellidoP6'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-6', '2233445566', '2000-02-02');

            INSERT INTO cuenta (cuentaTipoID, cuentaCorreo, cuentaCedula, cuentaContrasenaHash, cuentaNombre, cuentaApellido) 
                VALUE (2, 'paciente7@sa.a', '1-1-7', '$password', 'NombreP7', 'ApellidoP7'); 
            INSERT INTO paciente (pacienteCuentaID, pacienteNSS, pacienteNumeroContacto, pacienteFechaNacimiento) 
                VALUE (LAST_INSERT_ID(), '1-1-7', '2233445566', '2000-02-02');
        ";
    }

    public function down()
    {
        return null;
    }
}