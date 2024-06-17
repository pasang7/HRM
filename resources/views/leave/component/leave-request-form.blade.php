<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content mcontent">
                <div class="modal-header mheader bg-grey">
                    <h5 class="modal-title" id="exampleModalLabel">Request Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mbody">
                    <form id="form-create-leave" data-action="{{ route('leave.store')}}" autocomplete="off">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label >From <span class="text-danger">*</span></label>
                                    <div class="input-group date date-range date-start" id="daterange"
                                        data-date-format="mm-dd-yyyy">
                                        <input class="form-control custom-form-control" name="start" type="text" required>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label >To <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="input-group date date-range date-end" data-date-format="mm-dd-yyyy">

                                        <input class="form-control custom-form-control" name="end" type="text" required>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Select your Shift <span class="text-danger">*</span></label>
                                    <select name="shift_id" class="form-control custom-form-control" placeholder="Shifts" required>
                                        @foreach($user->department->shifts as $s=>$shift)
                                            <option value="{{$shift->id}}"> {{ date('h:i A', strtotime($shift->clockin)) }} to {{ date('h:i A', strtotime($shift->clockout)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                        <label > Type <span class="text-danger">*</span></label>

                                    <select name="leave_type" class="form-control custom-form-control" placeholder="Leave Type" required>
                                        @foreach($user->leave_types as $type)
                                            <option value="{{$type->leave_type->id}}">{{$type->leave_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label >Leave <span class="text-danger">*</span></label>
                                    <br>
                                    <div class="clear"></div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="leave_type_full" id="holidayTypeFull" value="1" checked>
                                        <label class="form-check-label" for="holidayTypeFull">Full</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="leave_type_full" id="holidayTypeHalf" value="0">
                                        <label class="form-check-label" for="holidayTypeHalf">Half</label>
                                    </div>
                                </div>
                            </div>
                          

                            <div class="col-lg-12">
                                <div class="form-group">
                                        <label > Reason <span class="text-danger">*</span></label>

                                    <textarea name="description" class="form-control custom-form-control" placeholder="Reason for leave" required></textarea>
                                </div>
                            </div>
                   
                            <div class="col-lg-12 mt-2">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm pull-right">Request Now</button>

                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>