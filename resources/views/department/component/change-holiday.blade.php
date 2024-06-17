@php 
    $days_name=['Sunday','Monday','Tuesday','Wednesday', 'Thursday', 'Friday','Saturday'];
@endphp
<div class="modal-dialog" role="document">
    <form action="" data-action="{{route('department.update.holiday')}}" id="form-change-holiday">
        <input type="hidden" name="department_id" value="{{$department->id}}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeHolidayLabel">Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <!-- <label for="holiday">Holiday</label><br> -->
                    @foreach($days_name as $key=>$day)
                        @php 
                            $checked="";
                            if(in_array($key,$current_holiday)){
                                $checked="checked";
                            }                            
                        @endphp
                        <input class="form-check-input" type="checkbox" {{$checked}} value="{{$key}}" name="holiday[]"> {{$day}}<br>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>
