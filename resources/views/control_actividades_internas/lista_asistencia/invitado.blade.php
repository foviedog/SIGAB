{{-- Arreglos de opciones de los select utilizados --}}
@php
$generos = GlobalArrays::GENEROS;
$estadosCiviles = GlobalArrays::ESTADOS_CIVILES;
@endphp

{{-- MODAL para agregar una persona que no se encuentra registrada en el sistema --}}
<form method="POST" autocomplete="off" action="{{ route('lista-asistencia.storeInvitado') }}" id="form-actualizar" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="agregar-invitado" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog   modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title texto-rojo-oscuro font-weight-bold" id="agregar-invitado">Agregar participante invitado</h5>

                </div>
                <div class="modal-body">

                    <div class="container">
                        <span class="text-danger">

                        </span>
                        <div class="file-upload" id="file-upload">
                            <button class="file-upload-btn btn btn-contorno-rojo w-100" type="button" onclick="$('.file-upload-input').trigger( 'click' )" data-toggle="tooltip" data-placement="top" title="Formatos permitidos: JPG , PNG, JPEG , SVG.">
                                AGREGAR IMAGEN
                            </button>
                            <div class="file-upload-wrap" data-toggle="tooltip" data-placement="bottom" title="Formatos permitidos: JPG , PNG, JPEG , SVG.">
                                <input type='file' class="file-upload-input" id="avatar" name="avatar" onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                    <h4>SELECCIONE LA IMAGEN DE PERFIL</h4>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image rounded" src="#" alt="Previsualizacion de avatar" />
                                <div class="file-title-wrap">
                                    <button type="button" class="remove-file" onclick="removeUpload()"><i class="fas fa-ban"></i> &nbsp; <span class="file-title">Subir imagen</span></button>
                                </div>
                            </div>
                        </div>
                        {{-- Id, nombre, apellido --}}
                        <div class="form-row px-5">
                            {{-- Campo: Nombre Completo de usuario --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="persona_id"><strong>Identificacion <i class="text-danger">* </i> </strong></label>
                                    <span id="mostrar_persona_id" class="ml-2 text-muted"></span>

                                    <span class="text-muted" id="mostrar_persona_id"></span>
                                    <input type="text" id="persona_id" name="persona_id" class="form-control" placeholder="Identificación " onkeypress="contarCaracteres(this,15)" required />

                                </div>
                            </div>
                            {{-- Campo: Nombre Completo de usuario --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="nombre"><strong>Nombre/s<i class="text-danger">* </i> </strong></label>
                                    <span class="text-muted" id="mostrar_nombre"></span>
                                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre " onkeypress="contarCaracteres(this, 50)" required />
                                </div>
                            </div>
                            {{-- Campo: Apellidos --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="apellido"><strong>Apellido/s<i class="text-danger">* </i> </strong></label>
                                    <span class="text-muted" id="mostrar_apellido"></span>
                                    <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellidos" onkeypress="contarCaracteres(this,50)" required /> </input>
                                </div>
                            </div>
                        </div>

                        {{-- Correos  --}}
                        <div class="form-row px-5 mt-3">
                            {{-- Campo: Correo personal --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="correo_personal"><strong>Correo Personal</strong><br /></label>
                                    <span class="text-muted" id="mostrar_correo_personal"></span>
                                    <input type="email" name="correo_personal" id="correo_personal" class="form-control" onkeyup="contarCaracteres(this,45)" placeholder="Correo Personal" />
                                </div>
                            </div>
                            {{-- Correo Institucional --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="correo_institucional"><strong>Correo Institucional<i class="text-danger">* </i> </strong><br /></label>
                                    <span class="text-muted" id="mostrar_correo_institucional"></span>
                                    <input type="email" name="correo_institucional" id="correo_institucional" class="form-control" onkeyup="contarCaracteres(this,45)" placeholder="Correo Institucional" required />
                                </div>
                            </div>
                        </div>
                        {{-- Telefonos --}}
                        <div class="form-row px-5 mt-3">
                            {{-- Celular --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="telefono_celular"><strong>Teléfono Celular</strong><br /></label>
                                    <span data-toggle="tooltip" data-placement="right" title="Digitar número sin guiones ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                    <span class="text-muted" id="mostrar_telefono_celular"></span>
                                    <input type="text" name="telefono_celular" id="telefono_celular" class="form-control" onkeyup="contarCaracteres(this,30)" placeholder="Telefono Celular" />
                                </div>
                            </div>
                            {{-- Telefono Fijo --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="telefono_fijo"><strong>Teléfono Fijo</strong><br /></label>
                                    <span data-toggle="tooltip" data-placement="right" title="Digitar número sin guiones ni espacios"><i class="far fa-question-circle fa-lg mr-2"></i></span>
                                    <span class="text-muted" id="mostrar_telefono_fijo"></span>
                                    <input type="text" name="telefono_fijo" id="telefono_fijo" class="form-control" onkeyup="contarCaracteres(this,30)" placeholder="Telefono Fijo" />
                                </div>
                            </div>
                        </div>
                        {{-- Estado civil, genero y fecha de nacimiento --}}
                        <div class="form-row px-5 ">
                            {{-- Estado civil --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="estadoCivil"><strong>Estado Civil</strong></label>
                                    <select id="estado_civil" name="estado_civil" class="form-control">
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($estadosCiviles as $estadoCivil)
                                        <option value='{{ $estadoCivil }}'> {{ $estadoCivil }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Genero --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="genero"><strong>Género <i class="text-danger">* </i></strong></label>
                                    <select id="genero" name="genero" class="form-control w-100" required>
                                        <option value="" selected>Sin seleccionar</option>
                                        @foreach($generos as $genero)
                                        <option value='{{ $genero }}'> {{ $genero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="fecha_nacimiento"><strong>Fecha de Nacimiento </strong><br /></label><input type='date' name="fecha_nacimiento" class="form-control" placeholder="Fecha Nacimiento" />
                                </div>
                            </div>
                        </div>
                        {{-- Direccion--}}
                        <div class="form-row px-5 mt-3">
                            <div class="col-12">
                                {{-- Campo: Direccion Residencia --}}
                                <div class="form-group">
                                    <label for="DireccionResidencia"><strong>Dirección Residencia </strong></label>
                                    <span data-toggle="tooltip" data-placement="right" title="Lugar de residencia habitual del personal "><i class="far fa-question-circle fa-lg"></i></span>
                                    <span class="text-muted" id="mostrar_direccion_residencia"> </span>
                                    <textarea type="text" name="direccion_residencia" id="direccion_residencia" class="form-control" onkeyup="contarCaracteres(this,250)" placeholder="Direccion de residencia" /></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-gris" data-dismiss="modal" id="cerrar-modal-edicion">Cerrar</button>
                    <button type="submit" class="btn btn-rojo ml-3" id="btn-agregar-participante-modal">Agregar participante</button>
                </div>
            </div>
        </div>
    </div>
</form>
