<div id="addCompanyFile" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
             </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class='row'>
                            <div class="col-12">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="custom-file mb-3">
                                    <input type="file" name="csv_file" class="custom-file-input"
                                           id="csv-file" required>
                                    <label class="custom-file-label" for="csv-file">Choose CSV
                                        file...</label>
                                </div>
                                <div class="form-group">
                                    <label>Self Reflection</label>
                                    <input id="id-form-self-reflection" class="form-control" name="id_form_self_reflection" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Peer Collection</label>
                                    <input id="id-form-peer-collection" class="form-control" name="id_form_peer_collection" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Peer Reflection</label>
                                    <input id="id-form-peer-reflection" class="form-control" name="id_form_peer_reflection" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div id="fileSuccessful" class="col-12"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="save-file" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
   </div>
</div>
