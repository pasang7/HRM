
<div class="modal-dialog" role="document">
    <div class="modal-content mcontent">
        <div class="modal-header mheader bg-grey">
            <h5 class="modal-title" id="changeHolidayLabel">Leave Report</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body table-responsive mbody">
            <table class="table table-bordered table-sm mb-2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th>Joined Date</th>
                        <td>{{$user->joined->format('Y-m-d')}}</td>
                    </tr>
                    <tr>
                        <th>Fiscal Year</th>
                        <td>{{$fiscal_year['this_start']}} to {{$fiscal_year['this_end']}}</td>
                    </tr>
                </thead>
            </table>
            <table class="table  table-sm" style="width:100%;">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Yearly</th>
                        <th>Taken</th>
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user_leave_types as $user_leave_type)
                        <tr>
                            <td>{{$user_leave_type['name']}}</td>
                            <td>{{$user_leave_type['yearly']}}</td>
                            <td>{{$user_leave_type['taken']}}</td>
                            <td>{{$user_leave_type['available']}}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        
    </div>
</div>
