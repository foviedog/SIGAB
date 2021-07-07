<div class="modal fade" id="detalle-guia-modal" tabindex="-1" aria-labelledby="detalle-guia-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog   modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold" id="detalle-guia-modal">Detalle de Guía Académica</h5>
                    <div class="d-flex justify-content-end">

                        @if(Accesos::ACCESO_MODIFICAR_GUIAS_ACADEMICAS())
                        <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                            Habilitar edición
                        </button>
                        <button type="button" class="btn btn-rojo" id="cancelar-edicion">
                            Cancelar edición
                        </button>
                        @endif

                    </div>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="d-flex justify-content-center mb-2">
                        <img class="rounded mb-3" width="160" height="160" id="imagen-modal" />
                    </div>
                    <div class="d-flex justify-content-center align-items-center border-bottom">
                        <div class="text-center mb-3">
                            <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula"></span> <br>
                            <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"></span> <br>
                            <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"></span> <br>
                        </div>
                    </div>

                    @if(Accesos::ACCESO_MODIFICAR_GUIAS_ACADEMICAS())
                    <form autocomplete="off" action="" method="post" id="form-actualizar" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @endif

                        <div class="form-group">
                            <label for="motivo" class="col-form-label mt-3">Tipo &nbsp;<i class="text-danger">*</i></label>
                            <select class="form-control mb-3" id="tipo" name="tipo" size="10" required disabled>
                                @foreach($tipos as $tipo)
                                <option>{{ $tipo }}</option>
                                @endforeach
                            </select>
                            <div id="tipo-mostrar"></div>
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between w-100">
                                <label for="lugar" class="col-form-label">Lugar de atención &nbsp;<i class="text-danger">*</i></label>
                                <span class="text-muted" id="mostrar_lugar"></span>
                            </div>
                            <input type="text" class="form-control" id="lugar" name="lugar" onkeypress="contarCaracteres(this,44)" required disabled>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="fecha" class="col-form-label">Fecha &nbsp;<i class="text-danger">*</i></label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required disabled>
                                </div>
                            </div>
                            <div class="col mt-2">
                                <div class="form-group">
                                    <label for="ciclo">Ciclo lectivo &nbsp;<i class="text-danger">*</i></label>
                                    <select class="form-control" id="ciclo" name="ciclo" required disabled>
                                        <option value="Ciclo I">Ciclo I </option>
                                        <option value="Ciclo II">Ciclo II </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <label class="col-form-label">Solicitado por &nbsp;<i class="text-danger">*</i></label><br>
                        <div class="row my-3 mx-1">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio" id="radio1" value="est" disabled>
                                    <label class="form-check-label" for="radio">
                                        Estudiante
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio" id="radio2" value="docen" disabled>
                                    <label class="form-check-label" for="radio">
                                        Docente
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="collapse mb-3" id="lista_docentes">
                            Seleccione el docente
                            <select class="form-control mb-3" size="10" id="docente" disabled>
                                @foreach($docentes as $docente)
                                <option>{{ $docente->persona->persona_id." - ".$docente->persona->nombre." ".$docente->persona->apellido }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div id="docente-mostrar"></div>

                        {{-- Input oculto que envia si es la guía es solicitada por un estudiante o por un educador --}}
                        <input type="hidden" name="solicitud" id="solicitud">

                        <div class="form-group">
                            <label for="situacion" class="col-form-label">Situación &nbsp;<i class="text-danger">*</i></label>
                            <textarea class="form-control" id="situacion" rows="2" cols="50" name="situacion" disabled required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="recomendaciones">Recomendaciones </label>
                            <textarea class="form-control" id="recomendaciones" rows="4" cols="50" name="recomendaciones" disabled></textarea>
                            <span class="text-muted" id="mostrar_cant_recomendaciones"></span>
                        </div>


                        <div class="form-group mb-3">
                            <label class="col-form-label" for="adjuntar-archivo">Adjuntar archivo</label> <br>
                            <input type="file" name="archivo" class="border" id="adjuntar-archivo" disabled> &nbsp;
                            <span data-toggle="tooltip" id="tooltip" data-placement="bottom" title="Si el archivo adjunto ya existe, se reemplazará al elegir otro"><i class="far fa-question-circle fa-lg"></i></span>
                            <br><span style="cursor: pointer" onclick="quitarArchivo()" id="quitar-archivo">Quitar archivo</span>
                            <div class="text-danger" id="mensaje-informacion-archivo">Los formatos permitidos son: <b>docx, odt, doc, txt, rar, zip, 7z, rar5, xls, xlsm, xlsx, ods, csv, pps, ppt, ppsx, pptm, potx, pptx, jpg, png, svg, jpeg</b>.
                                <br>El archivo no debe pesar más de <b>30MB</b>.</div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>

                        <div id="archivo-adjunto-existente"></div>

                        @if(Accesos::ACCESO_ELIMINAR_EVIDENCIAS_GUIAS_ACADEMICAS())
                        <div id="eliminar-archivo"></div>
                        @endif

                        <div class="alert alert-danger text-center" role="alert" id="rellenar-campos-modificar">
                            Hay campos vacíos que son obligatorios.
                        </div>

                        @if(Accesos::ACCESO_MODIFICAR_GUIAS_ACADEMICAS())
                    </form>
                    @endif

                </div>

            </div>
            <input type="hidden" name="id-guia-modal" id="id-guia-modal">


            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-gris" data-dismiss="modal" id="cerrar-modal-edicion">Cerrar</button>
                @if(Accesos::ACCESO_MODIFICAR_GUIAS_ACADEMICAS())
                <button type="button" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                @endif
            </div>

        </div>
    </div>
</div>
