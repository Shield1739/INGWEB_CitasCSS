$(document).ready(function()
{
    let selectedCitaID = $("#selectedCitaID").val();
    let selectedDoctorID = $("#selectedDoctorID").val();

    if (selectedCitaID)
    {
        var modal = new bootstrap.Modal(document.getElementById('rescheduleModal'), {
            keyboard: false
        });
        modal.toggle();

        const fechaInput = document.getElementById('fechaInput');
        if ($(fechaInput).val())
        {
            loadHoras(fechaInput, selectedDoctorID, selectedCitaID);
        }
    }
});

function loadHoras(fechaInput, doctorID, citaID)
{
    horaSelect = $('#bloqueHoraIDSelect');
    var fecha = $(fechaInput).val();

    console.log(fecha, doctorID, citaID);

    $.ajax
    ({
        url: "/doctor/citas",
        type: "POST",
        cache: false,
        data: {
            ajax:true,
            doctorID:doctorID,
            fecha:fecha
        },
        success: function (data)
        {
            horaSelect.empty();
            horaSelect.prop('disabled', false);

            $.each(JSON.parse(data), function (key, name)
            {
                horaSelect.append(new Option(name, key));
            });

            horaSelect.selectpicker('refresh');
        }
    });
}
