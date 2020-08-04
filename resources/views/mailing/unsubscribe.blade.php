@extends('layouts.app')
@section('content')
    @if($result === true)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div>You have successfully unsubscribed!</div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div>Your mail has already been removed from the mailing list.</div>
                </div>
            </div>
        </div>
    @endif
@endsection
