@extends('layout')

@section('title', 'About')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <img class="img-fluid mb-4" src="{{ asset('img/about.svg') }}" alt="Quién soy">
        </div>
        <div class="col-12 col-lg-6">
            <h1 class="display-4 text-primary">Quienes Somos</h1>
            <p class="lead text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum, quasi non perspiciatis corrupti a repellendus numquam dolore dolorum corporis omnis, porro velit aut ut nostrum vel cumque fugiat labore mollitia!</p>
            @auth
                <a class="btn btn-lg btn-block btn-primary"
                    href="{{ route('stamp') }}"
                >Sellar</a>
            @endauth
            <a class="btn btn-lg btn-block btn-outline-primary"
                href="{{ route('check') }}"
            >Verificar</a>
        </div>
    </div>
</div>
@endsection
