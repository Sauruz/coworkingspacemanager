$(document).ready(function () {

    $('#calendar').fullCalendar({
//        defaultView: 'basicWeek',
        height: 550,
        eventSources: [
            {
                url: 'admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'csmcalendar'
                }
            }
        ]
    });
});