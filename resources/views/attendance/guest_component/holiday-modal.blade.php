
@php 
    $days_name=['Sunday','Monday','Tuesday','Wednesday', 'Thursday', 'Friday','Satday'];
@endphp
<div class="modal-dialog" role="document">
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
                        <th colspan=2 class="text-center">Holiday({{$days_name[$holiday_reason]}})</th>
                    </tr>
                </thead>
            </table>

           
        </div>
    </div>
</div>