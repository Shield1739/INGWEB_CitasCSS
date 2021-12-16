$(document).ready(function()
{
    doctorIdInput = $("#doctorIdInput");
    fechaInput = $("#fechaInput");
    horaSelect = $('#bloqueHoraIDSelect');

    if(!horaSelect.val())
    {
        horaSelect.prop('disabled', true).selectpicker('refresh');
    }

    fechaInput.on("change", function ()
    {
        var doctorID = doctorIdInput.val();
        var fecha = fechaInput.val();

        if (doctorID && fecha)
        {
            //Empty Depending Selects
            horaSelect.empty().selectpicker('refresh');

            $.ajax
            ({
                url: "/citas/agendar/ajax",
                type: "POST",
                cache: false,
                data: {
                    doctorID:doctorID,
                    fecha:fecha
                },
                success: function (data)
                {
                    horaSelect.prop('disabled', false);

                    $.each(JSON.parse(data), function (key, name)
                    {
                        console.log(key, name);
                        horaSelect.append(new Option(name, key));
                    });

                    horaSelect.selectpicker('refresh');
                }
            });
        }
    });
});