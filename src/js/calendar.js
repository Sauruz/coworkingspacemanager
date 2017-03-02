$(document).ready(function () {

    $('#calendar').fullCalendar({
        eventSources: [
            {
                url: 'admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'calendar'
                }
            }
        ]

    });
});