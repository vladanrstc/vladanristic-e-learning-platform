@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-success">
                            @if($lang == "en")
                                Password successfully reset
                            @else
                                Uspešno resetovana lozinka
                            @endif
                        </h1>
                        <a href="{{env("APP_FRONTEND_URL")}}">
                            @if($lang == "en")
                                Back to homepage
                            @else
                                Nazad na početnu
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
