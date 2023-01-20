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
});
// Success and errore massage timeout code
setTimeout(function() {
  $('.alertsuccess').fadeOut(1000);
},5000);
setTimeout(function() {
  $('.alerterror').fadeOut(1000);
},5000);
