$( document ).ready(function() {
  const clockin_time= $('#countdown').data('clockin')
  setInterval(function time(){

  var actual_clockin=moment(clockin_time);


  var now = moment();
  
  var d = moment.duration(now.diff(actual_clockin));
  var hours = 24 - d.hours();
  var min = 60 - d.minutes();
  if((min + '').length == 1){
    min = '0' + min;
  }
  var sec = 60 - d.seconds();
  if((sec + '').length == 1){
        sec = '0' + sec;
  }
  jQuery('#countdown #hour').html(hours);
  jQuery('#countdown #min').html(min);
  jQuery('#countdown #sec').html(sec);
}, 1000); });