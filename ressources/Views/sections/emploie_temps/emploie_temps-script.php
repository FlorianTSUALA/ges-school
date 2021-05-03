<?php 

    use App\Helpers\HTMLHelper;
?>

<script>
  /************************************************
 *				External Dragging				*
 ************************************************/
/*
https://fullcalendar.io/docs/v3
https://stackoverflow.com/questions/27688279/full-calendar-business-hours
https://stackoverflow.com/questions/17540473/agendaday-row-time-format-in-fullcalendar
 
initialize the calendar
-----------------------------------------------------------------*/

$('#fc-external-drag').fullCalendar({
    // themeSystem: 'jquery-ui',
    // themeSystem: 'bootstrap4',
    // events: 'https://fullcalendar.io/demo-events.json'
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,'//,listWeek'
    },
    hiddenDays: [0, 6],
    aspectRatio: 2,
    defaultView: 'agendaWeek',
    locale: 'fr',
    allDaySlot: false,
    timeFormat: 'HH:mm',
    minTime: '08:00:00',
    maxTime: '18:00:00',
    views: {
            basic: {
            // options apply to basicWeek and basicDay views
            },
            agenda: {
                // options apply to agendaWeek and agendaDay views
                columnHeaderFormat: 'ddd D MMM',
                titleFormat: 'D MMMM YYYY',
                titleRangeSeparator: ' - ',
                // titleFormat: '[Semaine du] D MMMM YYYY',
                // titleRangeSeparator: ' au ',
            },
            week: {
                // options apply to basicWeek and agendaWeek views
                titleFormat: 'D MMMM YYYY',
                titleRangeSeparator: ' - ',
            },
            day: {
                // options apply to basicDay and agendaDay views
            }
      },
    // columnHeaderFormat: 'ddd D MMM',
    slotLabelFormat: 'HH:mm',
    editable: true,
    handleWindowResize: true, 
    // contentHeight: 600
    // height: 500,
    droppable: true, // this allows things to be dropped onto the calendar
    defaultDate: '2020-08-12',
    /*
    events: {
        url: '../../../app-assets/data/fullcalendar/php/get-events.php',
        error: function() {
            $('#script-warning').show();
        }
    },
    loading: function(bool) {
        $('#loading').toggle(bool);
    }
    */
    events: [{
            title: 'All Day Event',
            description: 'All Day Event',
            start: '2020-08-01',
            color: '#967ADC'
        },
        {
            title: 'Long Event',
            description: 'Long Event',
            start: '2020-08-07',
            end: '2020-08-10',
            color: '#37BC9B'
        },
        {
            id: 999,
            title: 'Repeating Event',
            description: 'Repeating Event',
            start: '2020-08-09T20:00:00',
            color: '#37BC9B'
        },
        {
            id: 999,
            title: 'Repeating Event',
            description: 'Repeating Event',
            start: '2020-08-20T20:00:00',
            color: '#F6BB42'
        },
 
        {
            title: 'Lunch',
            description: 'Lunch',
            start: '2020-08-12T12:00:00',
            color: '#DA4453'
        },
        {
            title: 'Meeting',
            description: 'Meeting',
            start: '2020-08-12T14:30:00',
            color: '#DA4453'
        },
        {
            title: 'Happy Hour',
            description: 'Happy Hour',
            start: '2020-08-12T17:30:00',
            color: '#DA4453'
        },
        {
            title: 'Dinner',
            description: 'Dinner',
            start: '2020-08-12T20:00:00',
            color: '#DA4453'
        },
        {
            title: 'Birthday Party',
            description: 'Birthday Party',
            start: '2020-08-13T07:00:00',
            color: '#DA4453'
        },
        {
            title: 'Click for Google',
            description: 'Click for Google',
            url: 'http://google.com/',
            start: '2020-08-28',
            color: '#3BAFDA'
        }
    ],
    drop: function() {
        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
        }
    },
    loading: function(bool) {
        $('#loading').toggle(bool);
    },
    eventRender: function(event, el) {
        // render the timezone offset below the event title
        // render the timezone offset below the event description
        if (event.start.hasZone()) {
            el.find('.fc-title').after(
            el.find('.fc-description').after(
                $('<div class="tzo"/>').text(event.start.format('Z'))
            ));
        }
    },
    dayClick: function(date) {
        console.log('dayClick', date.format());
    },
    select: function(startDate, endDate) {
        console.log('select', startDate.format(), endDate.format());
    },
    viewRender: function(view, element) {
        var b = $('#calendar').fullCalendar('getDate');
        //alert(b);
    },
    eventDidMount: function(info) {
        console.log(info.event.extendedProps);
        // {description: "Lecture", department: "BioChemistry"}
    },
    eventMouseover: function(calEvent, jsEvent) {
        var tooltip = '<div class="btn btn-lg btn-primary font-medium-1 tooltip-track-mouse mt-1 mt-1" style="position:absolute;z-index:10001;">' + calEvent.title + '</div>';
        var $tooltip = $(tooltip).appendTo('body');

        $(this).mouseover(function(e) {
            $(this).css('z-index', 10000);
            $tooltip.fadeIn('500');
            $tooltip.fadeTo('10', 1.9);
        }).mousemove(function(e) {
            $tooltip.css('top', e.pageY + 10);
            $tooltip.css('left', e.pageX + 20);
        });
    },

    eventMouseout: function(calEvent, jsEvent) {
        $(this).css('z-index', 8);
        $('.tooltip-track-mouse').remove();
    },
});

// a convenient utility for getting the calendar object.
// you can call methods on the calendar object directly.
// var calendar = $('#calendar').fullCalendar('getCalendar');

// calendar.next();

// load the list of available timezones, build the <select> options
/*$.getJSON('../../../app-assets/data/fullcalendar/php/get-timezones.php', function(timezones) {
    $.each(timezones, function(i, timezone) {
        if (timezone != 'UTC') { // UTC is already in the list
            $('#timezone-selector').append(
                $("<option/>").text(timezone).attr('value', timezone)
            );
        }
    });
});
*/

// when the timezone selector changes, dynamically change the calendar option
$('#timezone-selector').on('change', function() {
    $('#fc-timezones').fullCalendar('option', 'timezone', this.value || false);
});


$('#external-events .fc-event').each(function() {

    // Different colors for events
    $(this).css({ 'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color') });

    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        title: $.trim($(this).text()), // use the element's text as the event title
        description: $.trim($(this).text()), // use the element's text as the event description
        color: $(this).data('color'),
        stick: true // maintain when user navigates (see docs on the renderEvent method)
    });

    // make the event draggable using jQuery UI
    $(this).draggable({
        zIndex: 999,
        revert: true, // will cause the event to go back to its
        revertDuration: 0 //  original position after the drag
    });

});

$('body').on('click', 'button.fc-prev-button', function() {
    //alert('nextis oklm');
});

$('body').on('click', 'button.fc-next-button', function() {
    //alert('previs oklm');
});


$( ".tooltip-track-mouse" ).tooltip({
    track: true,
    effect: "slideDown",
    delay: 250
});

</script>
