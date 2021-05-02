@if(Session::has('mensaje-exito'))
    <div class="mensaje-container" id="mensaje-sticky" style="display:none;">
        <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
        <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8;">{!! \Session::get('mensaje-exito') !!}</div>
    </div>
@endif

@if(Session::has('mensaje-error'))
    <div class="mensaje-container" id="mensaje-sticky" style="display:none;">
        <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style=" background-image: url('/img/recursos/iconos/error.png');"></div>
        <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #b30808e8; ">{!! \Session::get('mensaje-error') !!}</div>
    </div>
@endif

@isset($mensajeExito)
    <div class="mensaje-container" id="mensaje-sticky" style="display:none;">
        <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
        <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8;">{{ $mensajeExito }}</div>
    </div>
@endisset

@isset($mensajeError)
    <div class="mensaje-container" id="mensaje-sticky" style="display:none;">
        <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style=" background-image: url('/img/recursos/iconos/error.png');"></div>
        <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #b30808e8; ">{{ $mensajeError }}</div>
    </div>
@endisset