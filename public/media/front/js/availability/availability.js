$(document).ready(function() {

  // var url = document.getElementById('url');
  var url = javascript_site_path;
  // url = url.textContent;
    var cDate = new Date();
    var token = $('meta[name="csrf-token"]').attr('content');

    // Calendar initialization
    $('#calendar').fullCalendar({
        editable: false,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month, agendaWeek, agendaDay'
        },
        defaultDate: cDate,
        defaultView: 'agendaWeek',
        slotMinutes: 60,
        slotDuration: '00:60:00',
        events: {
            url: url+'get-all-availability',
            success: function(e) {
                // alert("ads");
                console.log(e);
            },
            error: function() {
                $('#error').html('There was an error retrieiving Availability.');
            }
        },
        selectable: true,
        select: function(start, end) {
            if(start.isBefore(moment())) {
                //check if date is passed
                $('#calendar').fullCalendar('unselect');
                alert("Sorry, Date is passed!");
                return false;
            }else {
                // var title = confirm('Are you sure you want to set this availability?');
                var eventData;
                // Save it to DB and show
                // if (title) {
                    eventData = {
                        _token: token,
                        start: start.format(),
                        end: end.format(),
                    };

                    $.ajax({
                        type: "POST",
                        url: url+'set-availability',
                        data: eventData,
                        success: function(data) {
                            $('#calendar').fullCalendar('refetchEvents');
                        },
                        error: function(data) {
                            alert(data.responseText);
                        },
                        dataType: "json",
                    });
                // }
            }
        }
    });
    function setAvailability(eventData){
        $.ajax({
            type: "POST",
            url: url+'set-availability',
            data: eventData,
            success: function (data) {
                $('#calendar').fullCalendar('refetchEvents');
                $('#appointment_type').val('');
                $('#a_title').val('');
                $('#event_location').val('');
                $('#calendarModal').modal('hide');
                alert(data.responseText);
                window.location.reload();
            },
            error: function (data) {
                alert(data.responseText);
            },
            dataType: "json",
        });
    }
    function refreshCalendar()
    {
        $('#calendar').fullCalendar('refetchEvents');
    }
    $('#save-availability').click(function () {
        // Save it to DB and show
        var appointment_type = $('#appointment_type').val();
        var apm_title = $('#a_title').val();
        var event_location = $('#event_location').val();
        var apm_color = $('#apm_color').val();
        var date_range = $('#date_range').val();
        var eventData;
        eventData = {
            _token: token,
            start: function(){
                return $("#hidden_start_date").val();
            },
            end: function(){
                return $("#hidden_end_date").val();
            },
            appointment_type: appointment_type,
            apm_title: apm_title,
            event_location: event_location,
            apm_color: apm_color,
            date_range: date_range
        };
        var title = confirm('Are you sure you want to set this availability?');
        if (title) {
            setAvailability(eventData);
        }
    });
});