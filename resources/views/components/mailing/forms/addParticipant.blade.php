<div class="block-participant-add">
    <div class="participant-add">
        @if(@isset($companies))
        <form action="" id="participant-add" method="POST">
            <div class="form-row">
                <input type="hidden" name="_token"
                       value="{{ csrf_token() }}">
                <div class="form-group col-12">
                    <label for="company-id">Сhoose company</label>
                    <select class="form-control" name="company_id"
                            id="company-id">
                        @foreach($companies as $company)
                        <option
                            value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="user-first-name">Participant first
                        name</label>
                    <input class="form-control" id="user-first-name"
                           type="text"
                           name="first_name">
                </div>
                <div class="form-group col-12">
                    <label for="user-last-name">Participant last
                        name</label>
                    <input class="form-control" id="user-last-name"
                           type="text"
                           name="last_name">
                </div>
                <div class="form-group col-12">
                    <label for="user-email">Participant email</label>
                    <input class="form-control" id="user-email"
                           type="email" name="email"
                           placeholder="name@example.com">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <input class="" type="checkbox" id="self-reflection"
                           name="self_reflection" value="1">
                    <label class="form-check-label"
                           for="self-reflection">Self
                        Reflection</label>
                </div>
                <div class="form-group col-12">
                    <input class="" type="checkbox" id="peer-reflection"
                           name="peer_reflection" value="1">
                    <label class="form-check-label"
                           for="peer-reflection">Leadership
                        Reflection</label>
                </div>
            </div>
        </form>
        @else
        <div>Companies list is empty!</div>
        @endif
    </div>
</div>
