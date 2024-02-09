$(document).ready(function(){
  var currentDate = new Date();

  function displayCalendar(date){
    $('.days').empty();
    $('.timeslots').empty();


    for(var hour = 0; hour < 24; hour++){
      var timeSlot = ('0' + hour).slice(-2) + ':00';
      $('.timeslots').append('<div class="timeslot">' + timeSlot + '</div>');
    }

    var currentWeekStart = new Date();
    currentWeekStart.setDate(currentWeekStart.getDate() - currentWeekStart.getDay());


    for (var i = 0; i < 7; i++){
      var day = new Date(currentWeekStart);
      day.setDate(currentWeekStart.getDate() + i );
      var weekday = day.toLocaleDateString('en-US', {weekday: 'short'});
      var dayOfMonth = day.getDate();
      $('.weekdays').append('<div class="weekday">' + weekday + ' ' + dayOfMonth + '</div>');
    }
  }


  displayCalendar(currentDate);

  $('#prevWeek').click(function(){
    var currentWeek = $('.weekdays .weekday::first-child').text().split(' ')[1];
    var prevWeekStart = new Date(currentWeekStart);
    prevWeekStart.setDate(prevWeekStart.getDate() - 7);
    displayCalendar(prevWeekStart);
  });
  $('#nextWeek').click(function(){
    var currentWeek = $('.weekdays .weekday::first-child').text().split(' ')[1];
    var prevWeekStart = new Date(currentWeekStart);
    prevWeekStart.setDate(prevWeekStart.getDate() + 7);
    displayCalendar(prevWeekStart);
  });

});