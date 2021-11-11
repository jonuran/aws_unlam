@extends('layout')

@section('title', 'About')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-12 col-sm-10 col-lg-6 mx-auto">


            <div class="py-2">
	            <img class="img-fluid mb-4" src="{{ asset('img/404.svg') }}" alt="404">
	        </div>
            <div class="py-2">
                <a href="{{ route('home') }}" class="btn btn-lg btn-block btn-outline-primary">Volver a inicio</a>
            </div>
        </div>
    </div>
</div>
@endsection



