<div class="modal-dialog" role="document">
    <div class="modal-content mcontent">
        <div class="modal-header mheader newHrProModalhead ">
            <h5 class="modal-title" id="exampleModalLabel">Request Leave</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body mbody">
            <form id="form-create-leave" data-action="{{ route('leave.store')}}" autocomplete="off">
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
                </div>
                <div class="form-part-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input name="email" type="email" class="form-control custom-form-control"
                                    placeholder="Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">

                        </div>
                        <div class="col-6">
                            <button type="button"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-submit pull-right btn-check-email">Next</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>