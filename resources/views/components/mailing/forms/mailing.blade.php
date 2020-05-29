<?php //var_dump($companies);die; ?>
<div class="block-mailing row">
    <div class="col-10">
        @if(@isset($companies))
            <form action="" id="mailing-company" method="POST">
                <div class="form-row d-flex align-items-end">
                    <div class="form-group col-4">
                        <label for="id-company">Сhoose company</label>
                        <select class="form-control" name="id-company" id="id-company">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button id="start-mailing" class="btn btn-primary">Send</button>
                    </div>

                    <div class="form-group ml-auto">
                        <button type="button" data-toggle="modal" data-target="#confirmRemoveCompany" class="btn btn-outline-danger">Remove company</button>
                    </div>

                </div>
                <div class="form-row d-flex align-items-end">
                    <label class="col-4">
                        <input class="form-control" name="id_self_reflection" data-company-id="{{ $companies[0]->id }}" type="text" value="{{ !empty($companies[0]->id_form_self_reflection) ? $companies[0]->id_form_self_reflection : '' }}">
                        Self Reflection ID</label>
                    <label class="col-4">
                        <input class="form-control" name="id_peer_collection" data-company-id="{{ $companies[0]->id }}" type="text" value="{{ !empty($companies[0]->id_form_peer_collection) ? $companies[0]->id_form_peer_collection : '' }}">
                        Peer Collection ID
                    </label>
                    <label class="col-4">
                        <input class="form-control" name="id_peer_reflection" data-company-id="{{ $companies[0]->id }}" type="text" value="{{ !empty($companies[0]->id_form_peer_reflection) ? $companies[0]->id_form_peer_collection : '' }}">
                        Peer Reflection ID
                    </label>
                </div>
            </form>
        @else
            <div>Companies list is empty!</div>
        @endif
    </div>
</div>
