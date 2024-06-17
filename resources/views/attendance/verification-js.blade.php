<script>
    let attendance = {!! json_encode($attendances) !!};

    function verifyAttendance(firstIndex, secondIndex) {
        let employee = attendance[firstIndex]['users'][secondIndex]['user'];
        let userAttendance = employee['today_attendance'][0];
        console.log(userAttendance);
        $("#verify-attendance-modal").modal('show');
        document.getElementById('verification-detail').innerHTML = '';
        let content = "<input type='hidden' name='attendanceId' value='" + userAttendance.id + "'/>" +
            "<div class='col-md-4'><h5 class='font-weight-bold'>Employee</h5></div><div class='col-md-8'><h5>" + employee.name + "</h5></div>" +
            "<div class='col-md-4'><h5 class='font-weight-bold'>Clock In</h5></div><div class='col-md-8'><h5>" + userAttendance.actual_time + "</h5></div>" +
            "<div class='col-md-4'><h5 class='font-weight-bold'>Actual Time</h5></div><div class='col-md-8'><h5>" + userAttendance.clockin + "</h5></div>" +
            "<div class='col-md-4'><h5 class='font-weight-bold'>Remarks</h5></div><div class='col-md-8'><h5>" + userAttendance.remarks + "</h5></div>";
        document.getElementById('verification-detail').innerHTML = content;
    }

    $(document).on('submit', '#form-verify-attendance', function (e) {
        e.preventDefault();
        let action = $(document.activeElement).attr('id');
        $(".form-submit").prop('disabled', true);
        let form = $(this)
        let data = form.serialize() + '&action=' + action;
        let url = form.data('action')
        $.ajax({
            url: url,
            method: "POST",
            data: data,
            beforeSend: function (xhr) {

            }
        }).done(function (data) {
            let res = JSON.parse(data)
            if (res.status) {
                alert('success', res.title, res.text)
            } else {
                alert('error', res.title, res.text)
            }
            $(".form-submit").prop('disabled', false);
            $("#verify-attendance-modal").modal('hide');
        });
    });

    function alert(type,title,text){
        Swal.fire({
            title: title,
            text: text,
            icon: type,
            showCancelButton: false,
            showConfirmButton: true
        }).then(function() {
            location.reload()
        });
    }
</script>
