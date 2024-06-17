<div class="modal-dialog" role="document">
            <div class="modal-content mcontent">
                <div class="modal-header mheader bg-grey newHrProModalhead">
                    <h5 class="modal-title" id="exampleModalLabel">Request Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mbody">
                    <form id="form-create-leave" data-action="{{ route('leave.store')}}" autocomplete="off">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group date date-range date-start" id="daterange"
                                        data-date-format="mm-dd-yyyy">
                                        <input class="form-control custom-form-control" name="start" type="text" required>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group date date-range date-end" data-date-format="mm-dd-yyyy">
                                        <input class="form-control custom-form-control" name="end" type="text" required>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
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
                                        <input class="form-check-input" type="radio" name="leave_type_full" id="holidayTypeFull" value="1" checked>
                                        <label class="form-check-label" for="holidayTypeFull">Full</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="leave_type_full" id="holidayTypeHalf" value="0">
                                        <label class="form-check-label" for="holidayTypeHalf">Half</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 day-breakdown">
                              
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="description" class="form-control custom-form-control" placeholder="Reason for leave" required></textarea>
                                </div>
                            </div>
                            <div class="col-6"> </div>
                            <div class="col-6">
                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-submit pull-right">Create</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>