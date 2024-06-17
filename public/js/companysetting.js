$(document).on('change','input[type=radio][name="overtime"]',function(){
    if ($(this).attr("value") == "yes") {
        $("#overtimeDiv").css('display', "");
    }else{
        $("#overtimeDiv").css('display', "none");
    }
});
$(document).on('change','input[type=radio][name="pf_facility"]',function(){
    if ($(this).attr("value") == "yes") {
        $("#PFValue").css('display', "");
    }else{
        $("#PFValue").css('display', "none");
    }
});
$(document).on('change','input[type=radio][name="gratuity_facility"]',function(){
    if ($(this).attr("value") == "yes") {
        $("#grValue").css('display', "");
    }else{
        $("#grValue").css('display', "none");
    }
});
$(document).on('change','input[type=radio][name="bonus"]',function(){
    if ($(this).attr("value") == "yes") {
        $("#bonusTypeDiv").css('display', "");
    }else{
        $("#bonusTypeDiv").css('display', "none");
    }
});
$(document).on('change','input[type=radio][name="bonus_type"]',function(){
    if ($(this).attr("value") == "customize") {
        $("#customizeBonusDiv").css('display', "");
    }else{
        $("#customizeBonusDiv").css('display', "none");
    }
});

