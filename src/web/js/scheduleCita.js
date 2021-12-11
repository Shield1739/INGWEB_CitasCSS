$(document).ready(function()
{
    clinicaSelect = $("#clinicaIDSelect");
    especialidadSelect = $("#especialidadIDSelect");
    doctorSelect = $('#doctorIDSelect');
    fechaInput = $("#fechaInput");
    horaSelect = $('#bloqueHoraIDSelect');

    if (!especialidadSelect.val())
    {
        especialidadSelect.prop('disabled', true).selectpicker('refresh');
    }
    if(!doctorSelect.val())
    {
        doctorSelect.prop('disabled', true).selectpicker('refresh');
    }
    if(!horaSelect.val())
    {
        horaSelect.prop('disabled', true).selectpicker('refresh');
    }

    clinicaSelect.on("change", function()
    {
        var clinicaID = $(this).val();

        //Empty Depending Selects
        especialidadSelect.empty().selectpicker('refresh');
        doctorSelect.empty().prop('disabled', true).selectpicker('refresh');
        horaSelect.empty().prop('disabled', true).selectpicker('refresh');

        $.ajax
        ({
            url: "/citas/agendar/ajax",
            type: "POST",
            cache: false,
            data: {clinicaID:clinicaID},
            success: function (data)
            {
                especialidadSelect.prop('disabled', false)

                $.each(JSON.parse(data), function (key, name)
                {
                    especialidadSelect.append(new Option(name, key));
                });

                especialidadSelect.selectpicker('refresh');
            }
        });
    });

    especialidadSelect.on("change", function()
    {
        var especialidadID = $(this).val();
        var clinicaID = clinicaSelect.val();

        //Empty Depending Selects
        doctorSelect.empty().selectpicker('refresh');
        horaSelect.empty().prop('disabled', true).selectpicker('refresh');

        $.ajax
        ({
            url: "/citas/agendar/ajax",
            type: "POST",
            cache: false,
            data: {
                clinicaID:clinicaID,
                especialidadID:especialidadID
            },
            success: function (data)
            {
                doctorSelect.prop('disabled', false);

                $.each(JSON.parse(data), function (key, name)
                {
                    doctorSelect.append(new Option(name, key));
                });

                doctorSelect.selectpicker('refresh');
            }
        });
    });

    doctorSelect.add(fechaInput).on("change", function ()
    {
        var doctorID = doctorSelect.val();
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