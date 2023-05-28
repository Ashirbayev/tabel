$(window).load(function(){
    $(document).ready(function(){
      var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
      //defaultView: 'agendaWeek',
      editable: true,
      selectable: true,
      droppable: true,                    
      //header and other values
      select: function(start, end, allDay) {
          endtime = $.fullCalendar.formatDate(end,'h:mm tt');
          starttime = $.fullCalendar.formatDate(start,'ddd, MMM d, h:mm tt');
          var mywhen = starttime + ' - ' + endtime;
          $('#createEventModal #apptStartTime').val(start);
          $('#createEventModal #apptEndTime').val(end);
          $('#createEventModal #apptAllDay').val(allDay);
          $('#createEventModal #when').text(mywhen);
          $('#createEventModal').modal('show');
       },
       drop: function(date, allDay) {
        var originalEventObject = $(this).data('eventObject');
        var copiedEventObject = $.extend({}, originalEventObject);
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
        if ($('#drop-remove').is(':checked')) {
            $(this).remove();
        }
       }
       
    });

  $('#submitButton').on('click', function(e){    
    e.preventDefault();
    doSubmit();
  });

  function doSubmit(){
    $('#createEventModal').modal('hide');
    console.log($('#apptStartTime').val());
    console.log($('#apptEndTime').val());
    console.log($('#apptAllDay').val());  
    console.log($('#patientName').val());  
        
    $('#calendar').fullCalendar('renderEvent',
    {
        title: $('#patientName').val(),
        start: new Date($('#apptStartTime').val()),
        end: new Date($('#apptEndTime').val()),
        allDay: ($('#apptAllDay').val() == 'true'),
    },
    true);
    
    $('#patientName').val('');
   }
});
});