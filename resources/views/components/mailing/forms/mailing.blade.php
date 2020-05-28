<div class="block-mailing row">
    <div class="col-10">
        @if(@isset($companies))
            <form action="" id="mailing-company" method="POST">
                <div class="form-row d-flex align-items-end">
                    <div class="form-group col-4">
                        <label for="id-company">Сhoose company</label>
                        <select class="form-control" name="id-company" id="id-company">
                            @foreach($companies as $company)
                                <option
                                        value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button id="start-mailing" class="btn btn-primary">Send</button>
                    </div>

                    <div class="form-group ml-auto">
                        <button id="remove-company" class="btn btn-outline-danger">Remove company</button>
                    </div>
                </div>
            </form>
        @else
            <div>Companies list is empty!</div>
        @endif
    </div>
</div>