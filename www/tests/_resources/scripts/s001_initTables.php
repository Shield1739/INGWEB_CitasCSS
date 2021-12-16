<?php

class s001_initTables
{
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS bloquehora (bloqueHoraID tinyint NOT NULL AUTO_INCREMENT, bloqueHoraHoraInicio time NOT NULL, CONSTRAINT BloqueHora_bloqueHoraID_PK PRIMARY KEY (bloqueHoraID));
            CREATE TABLE IF NOT EXISTS cita (citaID int(10) NOT NULL AUTO_INCREMENT, citaEstadoID tinyint NOT NULL, citaDoctorID int(10) NOT NULL, citaPacienteID int(10), citaBloqueHoraID tinyint NOT NULL, citaCodigoSeguimineto varchar(6), citaFecha date NOT NULL, citaMotivo varchar(50), CONSTRAINT Cita_citaID_PK PRIMARY KEY (citaID), CONSTRAINT Cita_codigoSeguimiento_UK UNIQUE (citaCodigoSeguimineto));
            CREATE TABLE IF NOT EXISTS citaestado (citaEstadoID tinyint NOT NULL AUTO_INCREMENT, citaEstadoNombre varchar(10), CONSTRAINT CitaEstado_citaEstadoID_PK PRIMARY KEY (citaEstadoID));
            CREATE TABLE IF NOT EXISTS citapacienteinfo (citaPacienteInfoID int(10) NOT NULL, citaPacienteInfoCorreo varchar(255), citaPacienteInfoCedula varchar(30), citaPacienteInfoNSS varchar(30), citaPacienteInfoNombre varchar(40), citaPacienteInfoApellido varchar(40), citaPacienteInfoNumeroContacto varchar(40), CONSTRAINT CitaPacienteInfo_citaID_PK PRIMARY KEY (citaPacienteInfoID));
            CREATE TABLE IF NOT EXISTS clinica (clinicaID int(10) NOT NULL AUTO_INCREMENT, clinicaNombre varchar(40), clinicaDireccion varchar(255), CONSTRAINT Clinica_clinicaID_PK PRIMARY KEY (clinicaID));
            CREATE TABLE IF NOT EXISTS cuenta (cuentaID int(10) NOT NULL AUTO_INCREMENT, cuentaTipoID tinyint NOT NULL, cuentaCorreo varchar(255) NOT NULL, cuentaCedula varchar(30) NOT NULL, cuentaContrasenaHash varchar(60) NOT NULL, cuentaNombre varchar(40), cuentaApellido varchar(40), cuentaFechaCreacion date, CONSTRAINT Cuenta_cuentaID_PK PRIMARY KEY (cuentaID), CONSTRAINT Cuenta_Correo_UK UNIQUE (cuentaCorreo), CONSTRAINT Cuenta_Cedula_UK UNIQUE (cuentaCedula));
            CREATE TABLE IF NOT EXISTS cuentatipo (cuentaTipoID tinyint NOT NULL AUTO_INCREMENT, cuentaTipoNombre varchar(10), CONSTRAINT CuentaTipo_cuentaTipoID_PK PRIMARY KEY (cuentaTipoID));
            CREATE TABLE IF NOT EXISTS doctor (doctorID int(10) NOT NULL AUTO_INCREMENT, doctorCuentaID int(10) NOT NULL, doctorClinicaID int(10), CONSTRAINT Doctor_doctorID_PK PRIMARY KEY (doctorID));
            CREATE TABLE IF NOT EXISTS doctor_especialidad (doctorEspecialidadDoctorID int(10) NOT NULL, doctorEspecialidadEspecialidadID int(10) NOT NULL, CONSTRAINT Doctor_Especialidad_doctorID_especialidadID_PK PRIMARY KEY (doctorEspecialidadEspecialidadID, doctorEspecialidadDoctorID));
            CREATE TABLE IF NOT EXISTS especialidad (especialidadID int(10) NOT NULL AUTO_INCREMENT, especialidadNombre varchar(40), CONSTRAINT Especialidad_especialidadID_PK PRIMARY KEY (especialidadID));
            CREATE TABLE IF NOT EXISTS paciente (pacienteID int(10) NOT NULL AUTO_INCREMENT, pacienteCuentaID int(10) NOT NULL, pacienteNSS varchar(30), pacienteNumeroContacto varchar(20), pacienteFechaNacimiento date, CONSTRAINT Paciente_pacienteID_PK PRIMARY KEY (pacienteID));
            ALTER TABLE cita ADD CONSTRAINT Cita_bloqueHoraID_FK FOREIGN KEY (citaBloqueHoraID) REFERENCES BloqueHora (bloqueHoraID);
            ALTER TABLE cita ADD CONSTRAINT Cita_citaEstadoID_PK FOREIGN KEY (citaEstadoID) REFERENCES CitaEstado (citaEstadoID);
            ALTER TABLE cita ADD CONSTRAINT Cita_doctorID_FK FOREIGN KEY (citaDoctorID) REFERENCES Doctor (doctorID);
            ALTER TABLE cita ADD CONSTRAINT Cita_pacienteID_FK FOREIGN KEY (citaPacienteID) REFERENCES Paciente (pacienteID);
            ALTER TABLE citaPacienteInfo ADD CONSTRAINT CitaPacienteInfo_citaID_FK FOREIGN KEY (citaPacienteInfoID) REFERENCES Cita (citaID);
            ALTER TABLE cuenta ADD CONSTRAINT Cuenta_cuentaTipoID_FK FOREIGN KEY (cuentaTipoID) REFERENCES CuentaTipo (cuentaTipoID);
            ALTER TABLE doctor ADD CONSTRAINT Doctor_doctorClinicaID_FK FOREIGN KEY (doctorClinicaID) REFERENCES Clinica (clinicaID);
            ALTER TABLE doctor ADD CONSTRAINT Doctor_doctorCuentaID_FK FOREIGN KEY (doctorCuentaID) REFERENCES Cuenta (cuentaID);
            ALTER TABLE doctor_especialidad ADD CONSTRAINT Doctor_Especialidad_doctorID_FK FOREIGN KEY (doctorEspecialidadDoctorID) REFERENCES Doctor (doctorID);
            ALTER TABLE doctor_especialidad ADD CONSTRAINT Doctor_Especialidad_especialidadID_FK FOREIGN KEY (doctorEspecialidadEspecialidadID) REFERENCES Especialidad (especialidadID);
            ALTER TABLE paciente ADD CONSTRAINT Paciente_cuentaID_FK FOREIGN KEY (pacienteCuentaID) REFERENCES Cuenta (cuentaID);
        ";
    }

    public function down(): string
    {
        return "
        ALTER TABLE cita DROP FOREIGN KEY Cita_bloqueHoraID_FK;
        ALTER TABLE cita DROP FOREIGN KEY Cita_citaEstadoID_PK;
        ALTER TABLE cita DROP FOREIGN KEY Cita_doctorID_FK;
        ALTER TABLE cita DROP FOREIGN KEY Cita_pacienteID_FK;
        ALTER TABLE citapacienteinfo DROP FOREIGN KEY CitaPacienteInfo_citaID_FK;
        ALTER TABLE cuenta DROP FOREIGN KEY Cuenta_cuentaTipoID_FK;
        ALTER TABLE doctor DROP FOREIGN KEY Doctor_doctorClinicaID_FK;
        ALTER TABLE doctor DROP FOREIGN KEY Doctor_doctorCuentaID_FK;
        ALTER TABLE doctor_especialidad DROP FOREIGN KEY Doctor_Especialidad_doctorID_FK;
        ALTER TABLE doctor_especialidad DROP FOREIGN KEY Doctor_Especialidad_especialidadID_FK;
        ALTER TABLE paciente DROP FOREIGN KEY Paciente_cuentaID_FK;
        DROP TABLE IF EXISTS bloqueHora;
        DROP TABLE IF EXISTS cita;
        DROP TABLE IF EXISTS citaEstado;
        DROP TABLE IF EXISTS citaPacienteInfo;
        DROP TABLE IF EXISTS clinica;
        DROP TABLE IF EXISTS cuenta;
        DROP TABLE IF EXISTS cuentaTipo;
        DROP TABLE IF EXISTS doctor;
        DROP TABLE IF EXISTS doctor_especialidad;
        DROP TABLE IF EXISTS especialidad;
        DROP TABLE IF EXISTS paciente;
        ";
    }

}
