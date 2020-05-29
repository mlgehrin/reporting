@extends('layouts.app')
<?php //dd($participants);//var_dump($_POST); ?>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Move Mountains Admin Page</h1>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="block-upload-csv">
                        <div class="card-body">


                            {{--START block mailing--}}
                            @include('components.mailing.forms.mailing')
                            {{--END block mailing--}}

                            <div class="row">
                                <div class="col-10" id="sendSuccessful">

                                </div>
                            </div>

                            {{--START block participant list--}}
                            @include('components.mailing.blocks.participantList')
                            {{--END block participant list--}}

                            {{--START upload csv--}}
                            @include('components.mailing.forms.addCompanyFile')
                            {{--END block upload csv--}}

                            {{--START block add participant--}}
                            @include('components.mailing.blocks.addParticipant')
                            {{--END block add participant--}}

                            {{--START block confirm remove company--}}
                            @include('components.mailing.forms.confirmRemoveCompany')
                            {{--END block confirm remove company--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
