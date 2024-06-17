$(document).on('change','input[type=checkbox][name=has_pan]',function(){
    if ($(this).is(':checked')) {
        $("#panDiv").css('display', "");
    }else{
        $("#panDiv").css('display', "none");
    }
});
$(document).on('change','input[type=checkbox][name=has_ssf]',function(){
    if ($(this).is(':checked')) {
        $("#ssfDiv").css('display', "");
    }else{
        $("#ssfDiv").css('display', "none");
    }
});
$(document).on('change','input[type=checkbox][name=has_pf]',function(){
    if ($(this).is(':checked')) {
        $("#pfDiv").css('display', "");
    }else{
        $("#pfDiv").css('display', "none");
    }
});
$(document).on('change','input[type=checkbox][name=has_cit]',function(){
    if ($(this).is(':checked')) {
        $("#citDiv").css('display', "");
    }else{
        $("#citDiv").css('display', "none");
    }
});