function showContractWiseDate(contract_type){
    if(contract_type == 'rolling'){
            $(".startDiv").slideDown();
         $(".endDiv").slideUp();
        $('#contract_end').val("");

    }else if(contract_type == 'fixed' || contract_type == 'temporary' || contract_type == 'probation' || contract_type == 'project-based'){
         $(".startDiv").slideDown();
         $(".endDiv").slideDown();
    }
    else{
        $(".startDiv").slideUp();
        $('#contract_start').val("");
        $(".endDiv").slideUp();
        $('#contract_end').val("");
    }
}
