
<div class="modal-content mcontent">
    <div class="modal-header mheader bg-grey">
        <h5 class="modal-title" id="exampleModalLabel">Attendance Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body mbody">
        <table class="table table-bordered table-sm mb-2">
            <thead>
                <tr>
                    <th>Name</th>
                    <td>{{$user->name}}</td>
                </tr>
                <tr>
                    <th>Date (AD)</th>
                    <td>{{$date->format('Y-m-d')}}</td>
                </tr>
                <tr>
                    <th>Date (BS)</th>
                    <td>{{$nepali_date['year']}}-{{$nepali_date['month']}}-{{$nepali_date['date']}}</td>
                </tr>
                <tr>
                    <th>Day</th>
                    <td>{{$date->format('l')}}</td>
                </tr>
                @if($is_leave)
                <tr>
                    <th>Leave</th>
                    <td>True</td>
                </tr>
                @endif
            </thead>
        </table>
        <table class="table table-bordered table-sm mb-0" style="width:100%;">
            <thead>
                <tr>
                    <th>Shift</th>
                    <th>Clockin</th>
                    <th>Clockout</th>
                    <th>DC</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $is_present=false;
                    $is_main_late=false;
                    $is_leave=false;
                    $total_worked_time=0;
                @endphp

                @if(App\Models\AcceptedLeave::where('user_id',$user->id)->whereDate('date',Carbon\Carbon::today())->count()>0)
                    <?php $is_leave=true;?>
                @endif

                @if($attendances->count()>0)
                    <?php $is_present=true;?>
                    @foreach($attendances as $attendance)
                        @php
                            $is_late=false;
                            $is_default=false;

                            if($attendance->defaut_clockout){
                                $is_default=true;
                            }

                        @endphp
                        <tr>
                            <td>
                                {{date("g:i a", strtotime($attendance->shift->clockin))}} - {{date("g:i a", strtotime($attendance->shift->clockout))}}
                            </td>
                            <td>
                                <a class="image" data-image="{{$attendance->clockin_verification}}" href="#">{{date("g:i a", strtotime($attendance->clockin))}}</a>
                            </td>

                            @if($attendance->clockout)
                                <td>
                                    <a class="image" data-image="{{$attendance->clockout_verification}}" href="#">{{date("g:i a", strtotime($attendance->clockout))}}</a>
                                </td>
                            @else
                                <td>-</td>
                            @endif

                            @if (Carbon\Carbon::parse($attendance->clockin)->gt(Carbon\Carbon::parse($settings->max_allow_time)))
                                @php
                                    $is_late=true;
                                @endphp
                            @endif
                            <td>
                                @if($is_default)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>
                                @if($attendance->clockout && $attendance->default_clockout==0)
                                    @php
                                        $in = strtotime($attendance->clockin);
                                        $out = strtotime($attendance->clockout);
                                        $diff = $out-$in;
                                        $total_worked_time+=$diff;
                                    @endphp
                                    {{ $diff/60}}min
                                @endif
                            </td>
                            <td>
                                @if($is_late)
                                    <span class="badge badge-info">Late</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="4" class="text-right">Total Worked Time</td>
                            <td>
                                @if($total_worked_time)
                                    {{ $total_worked_time/60}}min

                                @endif
                            </td>
                            <td></td>
                        </tr>
                @else
                    <tr>
                        <td colspan=6 class="text-center">Not Clocked in</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
