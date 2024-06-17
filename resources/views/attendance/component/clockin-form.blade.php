<div class="modal-dialog" role="document">
    <form action="" data-action="{{route('attendance.clockin')}}" id="form-clockin">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <div class="modal-content mcontent">
            <div class="modal-header mheader bg-grey">
                <h5 class="modal-title" id="changeHolidayLabel">Clockin</h5>
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
                        placeholder="Enter pin" inputmode="numeric" required max="4">
                </div>
                <div class="form-group">
                    <input type="time" value="now" class="form-control custom-form-control" id="clockin-time" name="time"
                        placeholder="Enter time" required readonly>
                </div>
                <div class="form-group">
                    @foreach($shifts as $shift)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="shift_id" value="{{$shift->id}}"
                            @if($loop->first) checked @endif>
                        <label class="form-check-label" for="exampleRadios1">
                            {{date('h:i A', strtotime($shift->clockin))}}-{{date('h:i A', strtotime($shift->clockout))}}
                        </label>
                    </div>
                    @endforeach
                </div>
                @if(Carbon\Carbon::now()->gt(Carbon\Carbon::parse($settings->max_allow_time)))
                <div class="form-group">
                    <textarea name="remarks" class="form-control" cols="20" rows="5" placeholder="Enter Reason" required></textarea>
                </div>
                @endif
                {{-- <div class="form-group">
                    <div id="remarks-here">
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm">Clockin</button>
            </div>
        </div>
    </form>
</div>
