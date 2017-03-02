$(document).ready(function () {

    $('#calendar').fullCalendar({
        events: [
            {
                title: 'Guido Jarig',
                start: '2017-03-21'
            },
            {
                title: 'event2',
                start: '2010-01-05',
                end: '2010-01-07'
            },
            {
                title: 'event3',
                start: '2010-01-09T12:30:00',
                allDay: false // will make the time show
            }
        ]
    });

});