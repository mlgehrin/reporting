
<div class="block-participant-list row">
    <div id="participant-list" class="list col-10">
        @if(@isset($participants))
        <table class="participant-list table table-striped table-sm">
            @foreach($participants as $key => $participant)
            <tr class="item-row-{{ $participant->id }}">
                <td class="align-middle"><small>{{ $key + 1 }}</small></td>
                <td class="align-middle">
                    {{ $participant->first_name }}
                    {{ $participant->last_name }}
                </td>
                <td class="align-middle">{{ $participant->email }}</td>
                <td>
                    <div class="row">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   id="self-refl-{{ $participant->id }}"
                                   data-user-id="{{ $participant->id }}"
                                   name="self_reflection"
                                   value="{{ $participant->self_reflection }}"
                                   @if($participant->self_reflection == 1)
                            checked="checked"
                            @endif
                            >
                            <label class="custom-control-label"
                                   for="self-refl-{{ $participant->id }}">Self
                                Reflection</label>
                        </div>
                    </div>
                    <div class="row">
                        <small>
                            @if($participant->data_send_self_reflection === null)
                            not sent
                            @else
                            {{ $participant->data_send_self_reflection }}
                            @endif
                        </small>
                    </div>

                </td>

                <td>
                    <div class="row">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                data-user-id="{{ $participant->id }}"
                                id="peer-refl-{{ $participant->id }}"
                                name="peer_reflection"
                                value="{{ $participant->peer_reflection }}"
                                @if($participant->peer_reflection == 1)
                            checked="checked"
                            @endif
                            >
                            <label class="custom-control-label"
                                   for="peer-refl-{{ $participant->id }}"><small>Peer
                                    Reflection</small></label>
                        </div>
                    </div>
                    <div class="row">
                        <small>
                            @if($participant->data_send_peer_reflection === null)
                            not sent
                            @else
                            {{ $participant->data_send_peer_reflection }}
                            @endif
                        </small>
                    </div>
                </td>
                <td id="remove-participant" data-user-id="{{ $participant->id }}" class="align-middle">
                    <button class="btn btn-outline-danger btn-sm">Remove</button>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div>Participant list is empty!</div>
        @endif
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addCompanyFile">
            Add Company
        </button>
        <button type="button" class="btn btn-success btn-block" data-toggle="modal"
                data-target="#addParticipant">
            Add Participant
        </button>
        <button type="button" id="selectAllSelfReflections" class="btn btn-outline-primary btn-block btn-sm">
            <small>Select All Self Reflections</small>
        </button>
        <button type="button" id="disableAllSelfReflections" class="btn btn-outline-primary btn-block btn-sm">
            <small>Disable All Self Reflections</small>
        </button>
        <button type="button" id="selectAllPeerReflections" class="btn btn-outline-primary btn-block btn-sm">
            <small>Select All Leadership Reflections</small>
        </button>
        <button type="button" id="disableAllPeerReflections" class="btn btn-outline-primary btn-block btn-sm">
            <small>Disable All Leadership Reflections</small>
        </button>
    </div>
</div>
