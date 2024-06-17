<div class="modal-dialog modal-lg" role="document">
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
                    <tr>
                        <th colspan=2>No entry</th>
                       
                    </tr>
                </thead>
            </table>
            @if(!$is_real)
                <form action="/" id="present-form">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="date" value="{{$date}}">
                    <table class="table table-bordered table-sm mb-2">
                        <tbody>
                                
                                @foreach($user->department->shifts as $shift)
                                    @if($loop->first)
                                        <?php $disabled='' ?>
                                    @else 
                                        <?php $disabled='disabled' ?>
                                    @endif
                                    <tr>
                                        <td>
                                            <input type="radio" name="shift" class="shift" value="{{$shift->id}}" {{$loop->first?'checked':''}}>
                                        </td>
                                        <td>{{date("g:i a", strtotime($shift->clockin))}} - {{date("g:i a", strtotime($shift->clockout))}}</td>
                                        <td>
                                            <input type="time" name="time[{{$shift->id}}][clockin]" min="{{$shift->clockin}}" value="{{$shift->clockin}}" {{$disabled}}>
                                        </td>
                                        <td>
                                            <input type="time" name="time[{{$shift->id}}][clockout]" min="{{$shift->clockout}}" value="{{$shift->clockout}}" {{$disabled}}>                            
                                        </td>
                                        <td><button type="submit" class="btn btn-sm btn-success" {{$disabled}}>Present</button></td>
                                    </tr>
                                    
                                @endforeach                    
                        
                        </tbody>
                    
                    </table>
                </form>
            @endif
        </div>
    </div>
</div>