$(document).on('click', '.btn-clockin', function () {
    var user_id=$(this).data('user-id')
    $.ajax({
            url: get_clockin_form,
            method: "POST",
            data:{
                user_id:user_id
            },
            beforeSend: function (xhr) {

            }
        })
        .done(function (data) {
            var res = JSON.parse(data)
            if (res.status) {
                $('#modal-clockin').html(res.view)
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: "jpg",
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');
                var d = new Date(),
                    h = d.getHours(),
                    m = d.getMinutes();
                if (h < 10) h = '0' + h;
                if (m < 10) m = '0' + m;
                $('input[type="time"][value="now"]').each(function () {
                    $(this).attr({
                        'value': h + ':' + m
                    });
                });
                $('#modal-clockin').modal('show')
            } else {
                showAlert('error', res.title, res.text)

            }

        });
})
$('.modal').on('hidden.bs.modal', function (e) {
    Webcam.reset();
    $('#modal-clockin').html("")
})
$(document).on('submit', '#form-clockin', function (e) {
    e.preventDefault();
    var form = $(this)
    var image = take_snapshot()
    var data = form.serialize() + '&image=' + image;
    var url = form.data('action')
    $.ajax({
            url: url,
            method: "POST",
            data: data,
            beforeSend: function (xhr) {

            }
        })
        .done(function (data) {
            var res = JSON.parse(data)
            if (res.status) {
                showAlert('success', 'Done', 'Clockin Success')
                location.reload()
            } else {
                showAlert('error', res.title, res.text)

            }

        });
})

$(document).on('change','#clockin-time',function(){
    var time = $(this).val();
    var now =moment().subtract(1, 'h').format('HH:mm')
    // console.log('Now:'+now)
    // console.log('input:'+time)
    if(time<=now){
        document.getElementById('remarks-here').innerHTML = '<textarea name="remarks" id="remarks" ' +
            'class="form-control" cols="20" rows="5" placeholder="Remarks" required></textarea>' +
            '<input type="checkbox" name="is_changed" checked hidden/>';
   }else{
        document.getElementById('remarks-here').innerHTML = '';
    }

})


//Clockout
$(document).on('click', '.btn-clockout', function () {
    var user_id=$(this).data('user-id')

    $.ajax({
            url: get_clockout_form,
            method: "POST",
            data:{
                user_id:user_id
            },
            beforeSend: function (xhr) {

            }
        })
        .done(function (data) {
            var res = JSON.parse(data)
            if (res.status) {

                $('#modal-clockin').html(res.view)
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: "jpg",
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');
                var d = new Date(),
                    h = d.getHours(),
                    m = d.getMinutes();
                if (h < 10) h = '0' + h;
                if (m < 10) m = '0' + m;
                $('input[type="time"][value="now"]').each(function () {
                    $(this).attr({
                        'value': h + ':' + m
                    });
                });
                $('#modal-clockin').modal('show')
            } else {
                showAlert('error', res.title, res.text)

            }

        });
})
$(document).on('submit', '#form-clockout', function (e) {
    e.preventDefault();
    var form = $(this)
    var image = take_snapshot()
    var data = form.serialize() + '&image=' + image;
    var url = form.data('action')
    $.ajax({
            url: url,
            method: "POST",
            data: data,
            beforeSend: function (xhr) {

            }
        })
        .done(function (data) {
            var res = JSON.parse(data)
            if (res.status) {
                showAlert('success', 'Done', 'Clockout Success')
                location.reload()
            } else {
                showAlert('error', res.title, res.text)

            }

        });
})
$(document).on('change','#clockout-time',function(){
    var time= $(this).val()
    // alert(time)
})
//Default Clockout
$(document).on('click', '.btn-default-clockout', function () {
    var id = $(this).data('id')
    var user_id=$(this).data('user-id')
    var attendance_id =$(this).data('id')
    $.ajax({
            url: get_default_clockout_form,
            method: "POST",
            data: {
                id: id,
                user_id:user_id,
                attendance_id:attendance_id
            },
            beforeSend: function (xhr) {

            }
        })
        .done(function (data) {
            var res = JSON.parse(data)
            if (res.status) {

                $('#modal-clockin').html(res.view)
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: "jpg",
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');
                var d = new Date(),
                    h = d.getHours(),
                    m = d.getMinutes();
                if (h < 10) h = '0' + h;
                if (m < 10) m = '0' + m;
                $('input[type="time"][value="now"]').each(function () {
                    $(this).attr({
                        'value': h + ':' + m
                    });
                });
                $('#modal-clockin').modal('show')
            } else {
                showAlert('error', res.title, res.text)

            }

        });
})
$(document).on('submit', '#form-default-clockout', function (e) {

    e.preventDefault();
    var form = $(this)
    var image = take_snapshot()
    var data = form.serialize() + '&image=' + image;
    var url = form.data('action')
    $.ajax({
            url: url,
            method: "POST",
            data: data,
            beforeSend: function (xhr) {

            }
        })
        .done(function (data) {
            var res = JSON.parse(data)
            if (res.status) {
                showAlert('success', 'Succesfull', 'Clockout successfull')
                location.reload()
            } else {
                showAlert('error', res.title, res.text)

            }

        });
})




var data;

function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function (data_uri) {
        // display results in page
        data = data_uri
    });
    return data;
}
