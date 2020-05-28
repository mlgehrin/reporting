<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <div class='row'>
            <div class="col-10">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="custom-file">
                    <input type="file" name="csv_file" class="custom-file-input"
                           id="csv-file" required>
                    <label class="custom-file-label" for="csv-file">Choose CSV
                        file...</label>
                </div>
                <lable>Self Reflection<input id="id-form-self-reflection" name="id_form_self_reflection" type="text"></lable>
                <lable>Peer Collection<input id="id-form-peer-collection" name="id_form_peer_collection" type="text"></lable>
                <lable>Peer Reflection<input id="id-form-peer-reflection" name="id_form_peer_reflection" type="text"></lable>
            </div>
            <div class='col-2'>
                <button id="save-file" type="submit" class="btn btn-success btn-block">Parse CSV</button>
            </div>
        </div>
        <div class="row mt-2">
            <div id="fileSuccessful" class="col-9"></div>
        </div>
    </div>
</form>
