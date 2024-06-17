<div class="pt-1 mb-3">
    <div class="hrproTableHead">
        <h5>Leave Details of the Month</h5>
    </div>
    <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
        <table class="table  table-sm" style="width:100%;">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Starts From</th>
                    <th>End To</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($today_leaves as $tl=>$leave)
                <tr id={{ $tl+1 }}>
                    <td>{{ $leave->user->name }}</td>
                    <td>{{ date('d M, Y', strtotime($leave->from)) }}</td>
                    <td>{{ date('d M, Y', strtotime($leave->to)) }}</td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="3">Records Not Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="pt-1 mb-3">
    <div class="hrproTableHead">
        <h5>Travel History of the Month</h5>
    </div>
    <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
        <table class="table  table-sm" style="width:100%;">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Starts</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($today_travels as $tl=>$travel)
                <tr id={{ $tl+1 }}>
                    <td>{{ $travel->user->name }}</td>
                    <td>{{ date('d M, Y', strtotime($travel->from)) }}</td>
                    <td>{{ date('d M, Y', strtotime($travel->to)) }}</td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="3">Records Not Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
