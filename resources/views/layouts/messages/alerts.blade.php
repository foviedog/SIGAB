@if(Session::has('mensaje-exito'))
<div class="alert alert-success text-center font-weight-bold" role="alert" id="alert">
    {!! \Session::get('mensaje-exito') !!}
</div>
@endif
@if(Session::has('mensaje-error'))
<div class="alert alert-danger text-center font-weight-bold" role="alert" id="alert">
    {!! "¡Oops! Algo salió mal. ".\Session::get('mensaje-error') !!}
</div>
@endif
@if(isset($mensaje_exito))
<div class="alert alert-success text-center font-weight-bold" role="alert" id="alert">
    {!! $mensaje_exito !!}
</div>
@endif
@if(isset($mensaje_error))
<div class="alert alert-danger text-center font-weight-bold" role="alert" id="alert">
    {!! "¡Oops! Algo salió mal. ". $mensaje_error !!}
</div>
@endif
@if(Session::has('mensaje-advertencia'))
<div class="alert alert-warning text-center font-weight-bold" role="alert" id="alert">
    {!! "¡Lo sentimos! ".\Session::get('mensaje-advertencia') !!}
</div>
@endif
