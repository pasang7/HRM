<div class="modal-dialog" role="document">
    <form action="" data-action="{{route('attendance.default-clockout')}}" id="form-default-clockout">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="hidden" name="attendance_id" value="{{$attendance->id}}">

        <div class="modal-content mcontent">
            <div class="modal-header mheader bg-grey">
                <h5 class="modal-title" id="changeHolidayLabel">Default Clockout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mbody">
                <div class="form-group">
                    <div id="my_camera" style="width:100%; margin: 0px auto;"></div>
                </div>
                <div class="form-group">
                    <input type="password" pattern="[0-9]*" class="form-control custom-form-control" name="pin"
                        placeholder="Enter pin" inputmode="numeric" required>
                </div>
                <div class="form-group">
                    <input type="time" value="now" class="form-control custom-form-control" name="time"
                        min="{{$attendance->clockin}}" placeholder="Enter time" required>
                </div>
                <div class="form-group">
                    @php 
                        $totalDuration = \Carbon\Carbon::now()->diffInSeconds($attendance->clockin);
                    @endphp
                    You worked for {{gmdate('H:i:s', $totalDuration)}}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Clockout</button>
            </div>
        </div>
    </form>
</div>
