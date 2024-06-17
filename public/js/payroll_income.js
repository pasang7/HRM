function percentRate(calculationMethod){
    if(calculationMethod == "percent"){
        $("#percentRate").css('display', "");
    }else{
        $("#percentRate").css('display', "none");
    }
    if(calculationMethod == "amount"){
        $("#amountFixed").css('display', "");
    }else{
        $("#amountFixed").css('display', "none");
    }
}

function changeAssign(assignStatus){
    if(assignStatus == "partial"){
        $("#userListDiv").css('display', "");
    }else{
        $("#userListDiv").css('display', "none");
    }
}

function showAllowance(staff_id){
        income_id = $(event.currentTarget).attr('incomeId');
    if($(event.currentTarget).is(':checked')){
        $.ajax({
            method: 'GET',
            url: selectedEmployee,
            data: {
            staff_id:staff_id,
            income_id:income_id
            },
            success: function (response) {
                $('#allowanceDiv'+response.staffId).empty().append(response.result);
                $('#allowanceDiv'+response.staffId).slideDown();
            }
        });
    }else{
        $.ajax({
            method: 'GET',
            url: unselectedEmployee,
            data: {
            staff_id:staff_id,
            income_id:income_id
            },
            success: function (response) {
                $('#allowanceDiv'+response.staffId).slideUp();
            }
        });
    }
}

