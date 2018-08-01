// var url = document.getElementById("url").textContent;
var url = javascript_site_path;
var availableDates = [];
cDate = moment();
$('#currentDate').text("Current Date is " + cDate.format("MMMM Do, YYYY"));

$(document).ready(function ($) {
    createCalendar();
});

/**
 * Instantiates the calendar AFTER ajax call
 */
function createCalendar()
{
    var expert_id = $("#expert_id").val();
    $.get(url + "api/get-available-days?expert_id=" + expert_id, function (data) {
        $.each(data, function (index, value) {
            var d = new Date(value.booking_datetime),
             month = '' + (d.getMonth() + 1),
             day = '' + d.getDate(),
             year = d.getFullYear();
             arr = [year, month, day].join('-');
             availableDates.push(arr);
        });
        //My function to intialize the datepicker
        $('#calendar').datepicker({
            inline: true,
            minDate: 0,
            dateFormat: 'yy-mm-dd',
            beforeShowDay: available,
            onSelect: getTimes,
        });
    });
}

/**
 * Highlights the days available for booking
 * @param  {datepicker date} date
 * @return {boolean, css}
 */
function highlightDays(date)
{
    date = moment(date).format('YYYY-MM-DD');
    for (var i = 0; i < availableDates.length; i++) {
        availableDates = moment(availableDates[i]).format('YYYY-MM-DD');
        if (availableDates == date) {
            return[true, 'available'];
        }
    }
    return false;
}



function available(date) {
    dmy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    console.log(dmy + ' : ' + ($.inArray(dmy, availableDates)));
    if ($.inArray(dmy, availableDates) != -1) {
        return [true, "", "Available"];
    } else {
        return [false, "", "unAvailable"];
    }
}
/**
 * Gets times available for the day selected
 * Populates the daytimes id with dates available
 */
function getTimes(d) {
    var dateSelected = moment(d);
    document.getElementById('daySelect').innerHTML = dateSelected.format("MMMM Do, YYYY");
    $.get(url + "/api/get-booking-times?selectedDay=" + d, function (data) {
        $('#dayTimes').empty();
        $('#dayTimes').append('<h6>Times Available</h6>');
        for (var i in data) {
            var rdate = data[i].booking_datetime;
            var dateTimeId = data[i].id;
            rdate = rdate.split(" ");
            $("#dayTimes").append('<input type="radio" name="select_slot_time" value='+ dateTimeId +'>' + rdate[1] + ' ' + rdate[2] + '' + '<br>');
        }
    });
}