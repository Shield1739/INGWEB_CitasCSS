$(document).ready(function()
{

});

function toggleModal(bsTarget)
{
    const modalEL = document.querySelector(bsTarget);
    const modal = bootstrap.Modal.getOrCreateInstance(modalEL);
    modal.toggle();
}

function addTableRowCell(row, txt)
{
    var cell = row.insertCell();
    var text = document.createTextNode(txt);
    cell.appendChild(text);
}

function createDeleteButton(context, func) {
    var button = document.createElement("input");
    button.type = "button";
    button.className = "btn btn-danger align-self-end"
    button.value = 'Borrar'
    //button.onclick = func;
    context.appendChild(button);
}

function openClinicaModal(button)
{
    const mode = button.dataset.mode;

    if (mode !== 'create')
    {
        const id = button.dataset.id;
        const nombre = button.dataset.nombre;
        const direccion = button.dataset.direccion;

        let clinicaIdInput;
        let clinicaNombreInput;
        let clinicaDireccionInput;

        if (mode === 'edit')
        {
            clinicaIdInput = document.getElementById('clinicaEditModalClinicaID');
            clinicaNombreInput = document.getElementById('clinicaEditModalClinicaNombre');
            clinicaDireccionInput = document.getElementById('clinicaEditModalClinicaDireccion');
        }
        else
        {
            clinicaIdInput = document.getElementById('clinicaDeleteModalClinicaID');
            clinicaNombreInput = document.getElementById('clinicaDeleteModalClinicaNombre');
            clinicaDireccionInput = document.getElementById('clinicaDeleteModalClinicaDireccion');
        }

        clinicaIdInput.value = id;
        clinicaNombreInput.value = nombre;
        clinicaDireccionInput.value = direccion;
    }

    toggleModal(button.dataset.bsTarget)
}

function openEspecialidadModal(button)
{
    const mode = button.dataset.mode;

    if (mode !== 'create')
    {
        const id = button.dataset.id;
        const nombre = button.dataset.nombre;

        let especialidadIdInput;
        let especialidadNombreInput;

        if (mode === 'edit')
        {
            especialidadIdInput = document.getElementById('especialidadEditModalEspecialidadID');
            especialidadNombreInput = document.getElementById('especialidadEditModalEspecialidadNombre');
        }
        else
        {
            especialidadIdInput = document.getElementById('especialidadDeleteModalEspecialidadID');
            especialidadNombreInput = document.getElementById('especialidadDeleteModalEspecialidadNombre');
        }

        especialidadIdInput.value = id;
        especialidadNombreInput.value = nombre;
    }

    toggleModal(button.dataset.bsTarget)
}

function openDoctorModal(button)
{
    const mode = button.dataset.mode;

    if (mode !== 'create')
    {
        const id = button.dataset.id;
        const cuentaID = button.dataset.cuentaId;
        const correo = button.dataset.correo;
        const cedula = button.dataset.cedula;
        const nombre = button.dataset.nombre;
        const apellido = button.dataset.apellido;
        const clinicaID = button.dataset.clinicaId;

        let doctorIdInput;
        let doctorCuentaIdInput;
        let doctorCorreoInput;
        let doctorCedulaInput;
        let doctorNombreInput;
        let doctorApellidoInput;
        let doctorClinicaIdInput;

        if (mode === 'edit')
        {
            doctorIdInput = document.getElementById('doctorEditModalDoctorID');
            doctorCuentaIdInput = document.getElementById('doctorEditModalDoctorCuentaID');
            doctorCorreoInput = document.getElementById('doctorEditModalDoctorCorreo');
            doctorCedulaInput = document.getElementById('doctorEditModalDoctorCedula')
            doctorNombreInput = document.getElementById('doctorEditModalDoctorNombre');
            doctorApellidoInput = document.getElementById('doctorEditModalDoctorApellido');

            doctorClinicaIdInput = document.getElementById('doctorEditModalDoctorClinicaID');
            doctorClinicaIdInput.value = clinicaID;

            $.ajax
            ({
                url: "/admin/dashboard/ajax",
                type: "POST",
                cache: false,
                data: {
                    action:'loadDoctor',
                    doctorID:id
                    },
                success: function (data)
                {
                    let parsedData = JSON.parse(data);

                    // Populate Clinica
                    let clinicaSelect = $('#doctorEditModalDoctorClinica');
                    clinicaSelect.empty();

                    $.each(parsedData['clinicas'], function (key, name)
                    {
                        let selected = false;
                        if (parsedData['clinica']['clinicaID'] === name['clinicaID'])
                        {
                            selected = true;
                        }

                        clinicaSelect.append(new Option(name['clinicaNombre'], name['clinicaID'], false, selected));
                    });

                    clinicaSelect.selectpicker('refresh');

                    // Populate Especialidad
                    let doctorEspecialidadTable = document.getElementById('doctorEspecialidadTable').getElementsByTagName('tbody')[0];

                    i = 1;
                    $.each(parsedData['especialidades'], function (key, name)
                    {
                        // Insert a row at the end of table
                        var newRow = doctorEspecialidadTable.insertRow();

                        addTableRowCell(newRow, i);
                        addTableRowCell(newRow, name['especialidadID']);
                        addTableRowCell(newRow, name['especialidadNombre']);

                        var cell = newRow.insertCell();
                        createDeleteButton(cell);

                        i++;
                    });
                }
            });

        }
        else
        {
            doctorIdInput = document.getElementById('doctorDeleteModalDoctorID');
            doctorCuentaIdInput = document.getElementById('doctorDeleteModalDoctorCuentaID');
            doctorCorreoInput = document.getElementById('doctorDeleteModalDoctorCorreo');
            doctorCedulaInput = document.getElementById('doctorDeleteModalDoctorCedula');
            doctorNombreInput = document.getElementById('doctorDeleteModalDoctorNombre');
            doctorApellidoInput = document.getElementById('doctorDeleteModalDoctorApellido');
            //doctorClinicaIdInput = document.getElementById('doctorDeleteModalDoctorID');
        }

        doctorIdInput.value = id;
        doctorCuentaIdInput.value = cuentaID;
        doctorCedulaInput.value = cedula;
        doctorCorreoInput.value = correo;
        doctorNombreInput.value = nombre;
        doctorApellidoInput.value = apellido;
    }

    toggleModal(button.dataset.bsTarget)
}

function openDoctorEspecialidadModal(button)
{

}