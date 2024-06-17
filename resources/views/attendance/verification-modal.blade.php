<div class="modal fade" id="verify-attendance-modal" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content mcontent">
            <div class="modal-header mheader bg-grey">
                <h5 class="modal-title" id="exampleModalLabel">Verify Attendance Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-verify-attendance" data-action="{{ route('attendance.verifyAttendance') }}" autocomplete="off">
                <div class="modal-body mbody">
                    <div class="row" id="verification-detail">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="accept" class="btn btn-success btn-sm form-submit">Accept</button>
                    <button type="submit" id="decline" class="btn btn-danger btn-sm form-submit">Decline</button>
                </div>
            </form>
        </div>
    </div>
</div>
