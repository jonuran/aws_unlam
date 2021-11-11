@extends('layout')

@section('title', 'About')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-12 col-sm-10 col-lg-6 mx-auto">
            <h1 class="display-4 text-primary">Verificar</h1>
            <p class="lead text-secondary">Seleccione un archivo para verificar si el mismo fue sellado en Blockchain Federal Argentina</p>
            <form action="{{ route('stamp.check') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="custom-file">
                  <input type="file" id="file" name="file">
                  <label class="custom-file-label" for="file">Seleccionar Archivo</label>
                </div>
                <div class="py-2">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Verificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $("#file").change(function() {
      var fileName = document.getElementById("file").files[0].name; 
      $('.custom-file-label').html(fileName);
    });
});
</script>
@endsection