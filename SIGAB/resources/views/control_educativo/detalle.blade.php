@extends('layouts.app')

@section('titulo')
Detalle del estudiante {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- No hay --}}
@endsection

@section('scripts')
{{-- <script src="{{ asset('js/control_educativo/estudiante/detalle.js') }}" defer></script> --}}
@endsection

@section('contenido')
<div class="container-fluid">
    <h3 class="text-dark mb-4">{{ $estudiante->persona->nombre }}</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="dogs/Foto.jpg" width="160" height="160" />
                    <div class="mb-3"><i class="fa fa-id-card mr-3 texto-rojo"></i><small class="texto-negro" style="font-size: 17px;"><strong>117380366</strong></small></div>
                    <div class="mb-3"><button class="btn btn-primary btn-sm rojo" type="button">Change Photo</button></div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary font-weight-bold m-0 texto-rojo">Información académica</h6>
                </div>
                <div class="card-body pb-5">
                    <form>
                        <div class="form-group"><label for="city"><strong>Año de ingreso a la carrera</strong><br /></label><input class="form-control " type="text" placeholder="Los Angeles" name="anio_ingreso_ebdi" value="2020" disabled/></div>
                        <div class="form-group"><label for="city"><strong>Segunda Carrera</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" value="No tiene" /></div>
                    </form>
                    <form>
                        <div class="form-group"><label for="city"><strong>Tipo de colegio de procedencia</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" value="Privado" /></div>
                        <div class="form-group"><label for="city"><strong>Nota de admisión</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" value="740" /></div>
                    </form>
                    <form>
                        <div class="form-group"><label for="city"><strong>Beca</strong><br /></label>
                            <div class="d-flex justify-content-center">
                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-2" /><label class="form-check-label" for="formCheck-2">Si</label></div>
                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-3" /><label class="form-check-label" for="formCheck-3">No</label></div>
                            </div>
                        </div>
                        <div class="form-group"><label for="city"><strong>Apoyo Educativo</strong><br /></label>
                            <div class="d-flex justify-content-center">
                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-4" /><label class="form-check-label" for="formCheck-2">Si</label></div>
                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-5" /><label class="form-check-label" for="formCheck-3">No</label></div>
                            </div>
                        </div>
                        <div class="form-group"><label for="city"><strong>Recodencias UNA</strong><br /></label>
                            <div class="d-flex justify-content-center pb-4">
                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-6" /><label class="form-check-label" for="formCheck-2">Si</label></div>
                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-7" /><label class="form-check-label" for="formCheck-3">No</label></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row mb-3 d-none">
                <div class="col">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Peformance</p>
                                    <p class="m-0"><strong>65.2%</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Peformance</p>
                                    <p class="m-0"><strong>65.2%</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold texto-rojo">Contacto</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="username"><strong>Nombre</strong></label><input class="form-control" type="text" name="username" value="David" /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="email"><strong>Apellidos</strong></label><input class="form-control" type="email" placeholder="user@example.com" value="Aguilar Rojas" name="apellidos" /></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="first_name"><strong>Correo</strong><br /></label><input class="form-control" type="text" name="first_name" value="user@example.com" /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="last_name"><strong>Número de teléfono</strong><br /></label><input class="form-control" type="text" name="telefono" value="84494891" /></div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center py-2"><button class="btn btn-primary btn-sm rojo" type="submit">Save Settings</button></div>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold texto-rojo">Información adicional</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group"><label for="address"><strong>Dirección residencia</strong><br /></label><input class="form-control" type="text" name="address" value="San Jose, Piedades de Santana 300m noreste del super Piedades." /></div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Correo institucional</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Telefono fijo</strong><br /></label><input class="form-control" type="text" placeholder="USA" name="country" /></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Fecha de nacimiento</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Carrera principal matriculada</strong><br /></label><input class="form-control" type="text" placeholder="USA" name="country" /></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Apoyo Educativo</strong><br /></label>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-8" /><label class="form-check-label" for="formCheck-2">Si</label></div>
                                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-9" /><label class="form-check-label" for="formCheck-3">No</label></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Directivos lectivos*</strong><br /></label><input class="form-control" type="text" placeholder="?????" name="country" /></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Fecha de nacimiento</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" value="26/03/1999" /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Género</strong><br /></label>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-10" /><label class="form-check-label" for="formCheck-2">Si</label></div>
                                                <div class="form-check px-2 mx-3"><input class="form-check-input" type="radio" id="formCheck-11" /><label class="form-check-label" for="formCheck-3">No</label></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Fecha de nacimiento</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" /></div>
                                        <div class="form-group"><label for="city"><strong>Trabaja</strong><br /></label><input class="form-control" type="text" placeholder="Los Angeles" name="city" value="No" /></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Carrera principal matriculada</strong><br /></label><input class="form-control" type="text" placeholder="USA" name="country" /></div>
                                        <div class="form-group"><label for="city"><strong>Trabaja</strong><br /></label>
                                            <div class="w-100 d-flex justify-content-center"><button class="btn btn-primary w-50 rojo-ferrari" type="button" value="Ver trabajo" data-target="#trabajoModal" data-toggle="modal">Ver trabajo</button></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-5">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Forum Settings</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="form-group"><label for="signature"><strong>Signature</strong><br /></label><textarea class="form-control" rows="4" name="signature"></textarea></div>
                        <div class="form-group">
                            <div class="custom-control custom-switch"><input class="custom-control-input" type="checkbox" id="formCheck-1" /><label class="custom-control-label" for="formCheck-1"><strong>Notify me about new replies</strong></label></div>
                        </div>
                        <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('pie')
Copyright
@endsection
