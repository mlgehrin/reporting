<div class="modal fade" id="addParticipant" tabindex="-1" role="dialog"
     aria-labelledby="addParticipant" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add participant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--START form for adding participant--}}
                @include('components.mailing.forms.addParticipant')
                {{--END form for adding participant--}}
            </div>
            <div class="row mt-2">
                <div id="form-errors" class="col-12"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="addParticipantModalButton">
                    Add new Participant
                </button>
            </div>
        </div>
    </div>
</div>
