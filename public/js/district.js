function showDistrict(province_id){
    var url = $(event.currentTarget).attr('url');
    $.ajax({
        method: 'GET',
        url: url,
        data: {
            province_id: province_id,
        },
        success: function(response) {
            $('#dist').empty().html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}
function showTempDistrict(province_id){
    var url = $(event.currentTarget).attr('url');
    $.ajax({
        method: 'GET',
        url: url,
        data: {
            province_id: province_id,
        },
        success: function(response) {
            $('#temp_dist').empty().html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}