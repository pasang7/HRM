<div class="pt-1 mb-3">
    <div class="hrproTableHead">
        <h5>Holiday for Month</h5>
    </div>
    <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
        <table class="table  table-sm" style="width:100%;">
            <thead>
                <tr>
                    <th>Holiday</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($current_month_holidays as $h=>$holiday)
                <tr id="{{ $h+1 }}">
                    <td>{{ $holiday->name }}</td>
                    <td>{{ date('d M, Y', strtotime($holiday->start)) }} to {{ date('d M, Y', strtotime($holiday->end)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pt-1 mb-3">
    <div class="hrproTableHead">
        <h5>Birthday for Month</h5>
    </div>
    <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
        <table class="table  table-sm" style="width:100%;">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($current_month_birthdays as $bd=>$birthday)
                <tr id="{{ $bd+1 }}">
                    <td>{{ $birthday->name }}</td>
                    <td>{{ date('d M', strtotime($birthday->dob)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
