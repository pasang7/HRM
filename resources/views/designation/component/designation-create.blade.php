<div class="modal-dialog" role="document">
    <form action="" data-action="{{route('designation.store')}}" id="form-create-designation">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeHolidayLabel">Create Designation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label required text-md-right">Name</label>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input id="name" type="text" class="form-control custom-form-control" name="name" placeholder="Department Name" value="" required="" autofocus="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Create</button>
            </div>
        </div>
    </form>
</div>
