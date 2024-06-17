<form action="{{route('leave.partial.accept')}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="leave_id" value="{{$leave->id}}">
    <div class="row leavePartial">
        <div class="col-6">
            <span>Sent By: {{ $leave->user->name }}</span><br>
            <span>Shift: {{ date('h:i A', strtotime($leave->shift->clockin)) }} to {{ date('h:i A', strtotime($leave->shift->clockout)) }}</span>
        </div>
        <div class="col-6">
            <span>Leave Type: {{ $leave->type->name }} ({{ $leave->leave_type_full ? 'Full' : 'Half' }})</span>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $loop=1;
            $user= $leave->user;
            $dh=$user->department->holidays;
                foreach($dh as $row){
                    $days[]=$row->day;
                }
                while (strtotime($begin) <= strtotime($end)) {
                    $day = $begin->format('w');
                        if (!empty($days)) {
                            if(!in_array($day, $days)){
                        
                                $prev_leave = App\Models\Attendance::where('user_id',$leave->user->id)
                                                            ->where('date',date ("Y-m-d", strtotime($begin)))
                                                            ->where('is_leave',1)
                                                            ->first();
                                if(!$prev_leave){
                                    echo '<tr><td>';
                                    echo $begin->format('F d, Y (l)');
                                    echo '</td>';
                                    ?>
    
                                    <td class="text-center">
                                        <input type="radio" name="x[{{$begin->format('Y/m/d')}}]" value="1" class="radio-custom radio-green" title="Paid" checked>&nbsp; Paid &nbsp;
                                        <input type="radio" name="x[{{$begin->format('Y/m/d')}}]" value="2" class="radio-custom radio-black" title="Unpaid">&nbsp; Unpaid &nbsp;
                                        <input type="radio" name="x[{{$begin->format('Y/m/d')}}]" value="3" class="radio-custom radio-red" title="Reject">&nbsp; Reject &nbsp;
                                    </td>
                                    
                                    <?php
                                }
                            }
                        }else{

                            $prev_leave = App\Attendance::where('user_id',$leave->user->id)
                            ->where('date',date ("Y-m-d", strtotime($begin)))
                            ->where('on_leave',1)
                            ->first();
                            if(!$prev_leave){
                                echo '<tr><td>';
                                echo $begin->format('F d, Y');
                                echo '</td>';
                                echo '<td>';
                                echo $begin->format('l');
                                echo '</td>';
                                ?>

                                <td class="text-center">
                                    <input type="radio" name="x[{{$begin->format('Y/m/d')}}]" value="1" class="radio-custom radio-green" title="Paid" checked>  
                                    <input type="radio" name="x[{{$begin->format('Y/m/d')}}]" value="2" class="radio-custom radio-black" title="Unpaid">
                                    <input type="radio" name="x[{{$begin->format('Y/m/d')}}]" value="3" class="radio-custom radio-red" title="Reject">
                                </td>
                                
                                <?php
                            }
                        }


                        $begin = date ("Y-m-d", strtotime("+1 day", strtotime($begin)));
                        $begin = \Carbon\Carbon::parse($begin);
                        $loop++;
                }                        
            ?>  
        </tbody>
    </table>
    <div class="modal-footer">
        <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Grant</button>
    </div>
</form>
