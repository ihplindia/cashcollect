$(document).ready(function() {
  $('#allTableInfo').DataTable({
      "paging": true,
      "lengthchange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autowidth": false
  });
});
$('#reportsTableInfo').DataTable({
  "paging": false,
  "lengthchange": false,
  "searching": false,
  "ordering": true,
  "info": false,
  "autowidth": false,
  "order": [[ 0, 'desc']],
})

//date piker code Start
$(function () {
  $("#myDate").datepiker({
    autoclose:true,
    format:'yyyy-mm-dd',
    todayHighlight:true,
  })
})
// Modal alart j1uery
$(document).ready(function(){
  $(document).on("click", "#softDelete", function () {
    var deleteID = $(this).data('id');
    $(".modal_body #modal_id").val( deleteID );
  });
  $(document).on("click", "#restore", function () {
    var restoreID = $(this).data('id');
    $(".modal_body #modal_id").val( restoreID );
  });
  $(document).on("click", "#Delete", function () {
    var deleteID = $(this).data('id');
    $(".modal_body #modal_id").val( deleteID );
  });

  $(document).on("click", "#Search", function () {
    $("#searchBox").attr("class", "card-body");
  });
  
  $(document).on("click", "#searchCloseIcon", function () {
    $("#searchBox").attr("class", "card-body d-none");
  });

});
// Success and errore massage timeout code
setTimeout(function() {
  $('.alertsuccess').fadeOut(1000);
},5000);
setTimeout(function() {
  $('.alerterror').fadeOut(1000);
},5000);

countDownDate = '';

// Countdown timer start
var startTimer = function(mins, url)
{
    d1 = new Date ();
    d2 = new Date ( d1 );
    d2.setMinutes ( d1.getMinutes() + mins );
    countDownDate = d2.getTime();
    distance = 0;

    is_time_plus = false;
    expire_alert = false;
    
    var x = setInterval(function() {
      var now = new Date().getTime();
      distance = countDownDate - now;
      var min = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var sec = Math.floor((distance % (1000 * 60)) / 1000);
      $('#timer').html(min + "m " + sec + "s");      

      // show session expire alert
      if (!expire_alert && distance < 50000) {
        $('#timer').css('background','#fff0a5');
        expire_alert = true;
        alert('You session is about to expire!!!');
      }
      
      // time over
      if (distance <= 0) {
        clearInterval(x);
        window.location.href = url;
      }
    }, 1000);
}

var plus2timer = function(secs){
    if(!is_time_plus && secs > 0)
    {
    	countDownDate = countDownDate + secs*60000;
      is_time_plus = true;
    }
    else
    {
    	alert('Error: Session time already increased');
    }
}
// Countdown timer start
function toggleDiv(boxId,flag)
{
  $(document).ready(function(){
      boxId = '#'+boxId;
      if(flag=='show')
      {
        $(boxId).show();
      }
      else
      {
        $(boxId).hide();
      }
  });
}


// $(function() {
//   /* For jquery.chained.js */
//   $("#series").chained("#mark");
//   $("#model").chained("#series");
//   $("#engine").chained("#series, #model");
// });
