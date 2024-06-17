
<div class="form-part-2">
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <input name="name" type="text" value="{{$user->name}}" class="form-control custom-form-control"
                    placeholder="Name" disabled required>
            </div>
            <div class="form-group">
                <input name="email" type="hidden" value="{{$user->email}}" class="form-control custom-form-control"
                    placeholder="Email" disabled required>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Select your Shift <span class="text-danger">*</span></label>
                <select name="shift_id" class="form-control custom-form-control" placeholder="Shifts" required>
                    @foreach($user->department->shifts as $s=>$shift)
                        <option value="{{$shift->id}}"> {{ date('h:i A', strtotime($shift->clockin)) }} to {{ date('h:i A', strtotime($shift->clockout)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Leave Type <span class="text-danger">*</span></label>
                <select name="leave_type" class="form-control custom-form-control" placeholder="Leave Type" required>
                    @foreach($user->leave_types as $type)
                        <option value="{{$type->leave_type->id}}">{{$type->leave_type->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="leave_type_full"
                        id="holidayTypeFull" value="1" checked>
                    <label class="form-check-label" for="holidayTypeFull">Full</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="leave_type_full"
                        id="holidayTypeHalf" value="0">
                    <label class="form-check-label" for="holidayTypeHalf">Half</label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <textarea name="description" class="form-control custom-form-control"
                    placeholder="Reason for Leave" required></textarea>
            </div>
        </div>
        <div class="col-6"></div>
        <div class="col-6">
            <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-submit pull-right">Create</button>
        </div>
    </div>
</div>