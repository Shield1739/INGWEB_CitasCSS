<?php
/** @var $model Shield1739\UTP\CitasCss\app\backend\models\doctor\DoctorCitasModel */

/** @var $user */
/** @var $userType */
/** @var $success */
/** @var $scripts */

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/lib/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="/css/lib/bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="/css/lib/bootstrap-select/bootstrap-select.css">
        <link rel="stylesheet" href="/css/lib/tui-calendar/tui-calendar.css">
        <link rel="stylesheet" href="/css/dashboard.css">

        <title><?php echo $title ?? 'Citas CSS' ?></title>
    </head>

    <body>
        <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 bg-primary" href="/">
                <img src="/media/logo.png" alt="" class="d-inline-block me-2" style="width: 60px; height: 60px">
                <span class="d-none d-sm-inline fw-bold">CAJA DE SEGURO SOCIAL</span>
                <span class="d-inline-block d-sm-none fw-bold">CSS</span>
            </a>
            <button class="navbar-toggler text-light position-absolute d-md-none collapsed" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </header>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav d-flex flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link active fs-5" href="/doctor/citas">
                                    <i class="bi bi-journal-text feather"></i>
                                    Mis Citas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-5" href="/doctor/cita/agendar">
                                    <i class="bi bi-journal-album feather"></i>
                                    Agendar Cita
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <?php echo $success ?>
                        </div>
                    <?php endif; ?>
                    {{content}}
                </main>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Bootstrap Bundle JS, then Bootstrap Select JS -->
        <script src="/js/lib/jquery/jquery-3.6.0.min.js"></script>
        <script src="/js/lib/bootstrap/bootstrap.bundle.min.js"></script>
        <?php foreach ($scripts as $script): ?>
            <?php if (is_array($script)): ?>
                <script type="module" src="/js/<?php echo $script[0] ?>.js"></script>
            <?php else: ?>
                <script src="/js/<?php echo $script ?>.js"></script>
            <?php endif; ?>
        <?php endforeach; ?>

        <script src="/js/lib/moment/moment.js"></script>
        <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
        <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
        <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
        <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>

        <script>

            const start = new Date();
            const end = new Date(new Date().setMinutes(start.getMinutes() + 30));

            const newBtn = document.getElementById("newScheduleBtn");
            const todayBtn = document.getElementById("hoyButton");
            const prevBtn = document.getElementById("prevButton");
            const nextBtn = document.getElementById("nextButton");

            const fechaInput = document.getElementById("fechaInput");
            const cancelFechaInput = document.getElementById("cancelFecha");
            const cancelHoraInput = document.getElementById("cancelHora");
            const bloqueHoraIdSelect = document.getElementById("bloqueHoraIDSelect");
            const citaID = document.getElementById("citaID");
            const cancelCitaID = document.getElementById("cancelCitaID");

            // jquery wrapper
            var calendar = new tui.Calendar('#calendar', {
                defaultView: 'week',
                taskView: false,    // Can be also ['milestone', 'task']
                scheduleView: ['time'],  // Can be also ['allday', 'time']
                //isReadOnly: true,
                useDetailPopup: true,
                timezone: {
                    zones : [
                        {
                            timezoneName: 'America/New_York',
                            displayLabel: 'GMT-05:00',
                            tooltip: 'New York',
                        }
                    ]
                },
                template: {
                    task: function(schedule) {
                        return '#' + schedule.title;
                    },
                    time: function(schedule) {
                        return '<strong>' + moment(schedule.start.getTime()).format('hh:mm a') + '</strong> ' + schedule.title;
                    },
                    goingDuration: function(schedule) {
                        return '<span class="calendar-icon ic-travel-time"></span>' + schedule.goingDuration + 'min.';
                    },
                    comingDuration: function(schedule) {
                        return '<span class="calendar-icon ic-travel-time"></span>' + schedule.comingDuration + 'min.';
                    },
                    weekDayname: function(model) {
                        return '<span class="tui-full-calendar-dayname-date">' + model.date + '</span>&nbsp;&nbsp;<span class="tui-full-calendar-dayname-name">' + model.dayName + '</span>';
                    },
                    collapseBtnTitle: function() {
                        return '<span class="tui-full-calendar-icon tui-full-calendar-ic-arrow-solid-top"></span>';
                    },
                    popupDetailDate: function(isAllDay, start, end) {
                        var isSameDate = moment(start).isSame(end);
                        var endFormat = (isSameDate ? '' : 'YYYY.MM.DD ') + 'hh:mm a';


                        if (isAllDay) {
                            return moment(start).format('YYYY.MM.DD') + (isSameDate ? '' : ' - ' + moment(end).format('YYYY.MM.DD'));
                        }

                        return '<span class="fw-bold fs-6">' + (moment(start).format('YYYY.MM.DD ') + (moment(start.getTime()).format('hh:mm a')) + ' - ' + moment(end.getTime()).format(endFormat)) + '</span>';
                    },
                    popupDetailBody: function(schedule) {
                        return '<div class="fs-6">' + schedule.body + '</div>';
                    },
                    popupEdit: function() {
                        return 'Reprogramar';
                    },
                    popupDelete: function() {
                        return 'Cancelar';
                    },
                    timezoneDisplayLabel: function(timezoneOffset, displayLabel) {
                        var gmt, hour, minutes;

                        if (!displayLabel) {
                            gmt = timezoneOffset < 0 ? '-' : '+';
                            hour = Math.abs(parseInt(timezoneOffset / 60, 10));
                            minutes = Math.abs(timezoneOffset % 60);
                            displayLabel = gmt + getPadStart(hour) + ':' + getPadStart(minutes);
                        }

                        return displayLabel;
                    },
                },
                month: {
                    daynames: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    startDayOfWeek: 0,
                    narrowWeekend: true
                },
                week: {
                    daynames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                    hourStart: 7,
                    hourEnd: 17,
                    workweek: true,
                    startDayOfWeek: 0
                },
                calendars: [
                    {
                        id: '1',
                        name: 'Caja del Seguro Social',
                        color: '#ffffff',
                        bgColor: '#003B6D',
                        dragBgColor: '#003B6D',
                        borderColor: '#003B6D'
                    }
                ]
            });

            calendar.on(
            {
                'beforeUpdateSchedule': function(e) {

                    var rescheduleModal = new bootstrap.Modal(document.getElementById('rescheduleModal'), {
                        keyboard: false
                    });
                    fechaInput.value = '';
                    citaID.value = e.schedule['id'];
                    rescheduleModal.toggle();
                },
                'beforeDeleteSchedule': function(e) {

                    var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'), {
                        keyboard: false
                    });
                    cancelFechaInput.value = moment(e.schedule['start']).toDate().toISOString().substring(0, 10);
                    cancelHoraInput.value = moment(e.schedule['start'].getTime()).format('hh:mm a');
                    cancelCitaID.value = e.schedule['id'];
                    cancelModal.toggle();
                },
            });

            $('#fechaInput').on("change", function ()
            {
                loadHoras(fechaInput, <?php echo $model->doctorID?>, $(citaID).val());
            });

            const rangeSpan = document.getElementById('rangeSpan');
            updateRange();

            todayBtn.addEventListener("click", e => {
                calendar.today();
                updateRange();
            });

            prevBtn.addEventListener("click", e => {
                calendar.prev();
                updateRange();
            });

            nextBtn.addEventListener("click", e => {
                calendar.next();
                updateRange();
            });

            function updateRange()
            {
                rangeSpan.textContent = moment(calendar.getDateRangeStart().toDate()).format('YYYY/MM/DD') + ' ~ ' + moment(calendar.getDateRangeEnd().toDate()).format('YYYY/MM/DD');
            }

            var citas = <?php echo json_encode($model->citas) ?>;

            let schedule = [];
            $.each(citas, function(key, cita)
            {
                const endTime = moment(cita['citaFecha']+'T'+cita['bloqueHoraHoraInicio']);
                endTime.add(30, 'm');

                let nombre = '<h1 class="h6 pb-1 m-0"> Paciente: </h1> <p class="">';
                if (cita['pacienteCuentaNombre'])
                {
                    nombre += cita['pacienteCuentaNombre'] + ' ' + cita['pacienteCuentaApellido'];
                }
                else
                {
                    nombre += cita['citaPacienteInfoNombre'] + ' ' + cita['citaPacienteInfoNombre'];
                }
                nombre += '</p>';

                if (cita['citaMotivo'])
                {
                    nombre += '<h1 class="h6 pb-1 m-0"> Motivo: </h1> <p>' + cita['citaMotivo'] + '</p>';
                }

                schedule.push({
                    id: cita['citaID'],
                    calendarId: '1',
                    title: 'CITA AGENDADA',
                    body: nombre,
                    category: 'time',
                    start: cita['citaFecha'] + 'T' + cita['bloqueHoraHoraInicio'],
                    end: cita['citaFecha'] + 'T' + endTime.format('HH:mm:ss').toString()
                });
            });

            calendar.createSchedules(schedule);

        </script>
    </body>
</html>
