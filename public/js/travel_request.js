//accommodation total calculation
var timer;
$("#acc_day").on('keyup',function(){
    var acc_day = $(event.currentTarget).val();
    var acc_per_d = $('#acc_per_diem').val();
    var acc_per_diem = 0;
    if(acc_per_d == ''){
        acc_per_diem = 0;
    }else{
        acc_per_diem = acc_per_d;
    }
    var acc_total = parseFloat(acc_day * acc_per_diem).toFixed(2);
    $('#acc_tot').val(acc_total);
   clearInterval(timer);
   timer = setTimeout(function() { }, 400);
});
$("#acc_per_diem").on('keyup',function(){
    var acc_per_diem = $(event.currentTarget).val();
    var acc_day = $('#acc_day').val();
    var acc_total = parseFloat(acc_day * acc_per_diem).toFixed(2);
    $('#acc_tot').val(acc_total);
   clearInterval(timer);
   timer = setTimeout(function() {
   }, 400);
});

//da total calculation
$("#da_day").on('keyup',function(){
    var da_day = $(event.currentTarget).val();
    var da_per_diem = $('#da_per_diem').val();
    var da_total = parseFloat(da_day * da_per_diem).toFixed(2);
    $('#da_tot').val(da_total);
   clearInterval(timer);
   timer = setTimeout(function() {
   }, 400);
});
$("#da_per_diem").on('keyup',function(){
    var da_per_diem = $(event.currentTarget).val();
    var da_day = $('#da_day').val();
    var da_total = parseFloat(da_day * da_per_diem).toFixed(2);
    $('#da_tot').val(da_total);
   clearInterval(timer);
   timer = setTimeout(function() {
   }, 400);
});
//cont total calculation
$("#cont_day").on('keyup',function(){
    var cont_day = $(event.currentTarget).val();
    var cont_per_diem = $('#cont_per_diem').val();
    var cont_total = parseFloat(cont_day * cont_per_diem).toFixed(2);
    $('#cont_tot').val(cont_total);
   clearInterval(timer);
   timer = setTimeout(function() {
   }, 400);
});
$("#cont_per_diem").on('keyup',function(){
    var cont_per_diem = $(event.currentTarget).val();
    var cont_day = $('#cont_day').val();
    var cont_total = parseFloat(cont_day * cont_per_diem).toFixed(2);
    $('#cont_tot').val(cont_total);
   clearInterval(timer);
   timer = setTimeout(function() {
   }, 400);
});
//advance taken calculation
function calculateAdvance(){
    var daTot = 0;
    var contTot = 0;
     accTotal = $('#acc_tot').val();
    var daTot = $('#da_tot').val();
    if(daTot == ''){
        daTotal = 0;
    }else{
        daTotal = daTot;
    }
    var contTot = $('#cont_tot').val();
    if(contTot == ''){
        contTotal = 0;
    }else{
        contTotal = contTot;
    }
    var grandTotal = parseFloat(accTotal) + parseFloat(daTotal) + parseFloat(contTotal);
    if(isNaN(grandTotal)){
        grandTotal = 0;
    }else{
        grandTotal =grandTotal;
    }
    $("#advDiv").css('display', "");
    $('#adv_taken').val(grandTotal.toFixed(2));
   clearInterval(timer);
   timer = setTimeout(function() { }, 400);
};