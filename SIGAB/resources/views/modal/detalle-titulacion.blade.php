<div class="modal fade" id="detalle-graduacion-modal" tabindex="-1" aria-labelledby="detalle-graduacion-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold" id="detalle-graduacion-modal">Detalle de la gradución</h5>
                    
                    @if(Accesos::ACCESO_MODIFICAR_TITULACIONES())
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                            Habilitar edición
                        </button>
                    </div>
                    @endif

            </div>
            <div class="modal-body">

                @if(Accesos::ACCESO_MODIFICAR_TITULACIONES())
                {{-- Formulario para actualizar informacion de la graduación --}}
                <form method="POST" role="form" enctype="multipart/form-data" id="form-actualizar">
                    @csrf
                    @method('PATCH')
                    <div class="alert alert-danger" role="alert" id="validar-edicion" style="display:none;">
                        <strong>No deben quedar espacios vacios al editar la graduacion</strong> 
                    </div>
                @endif

                    <div class="d-flex justify-content-center flex-column">
                        {{-- Campo: Grado académico --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between w-100">
                                <label for="grado_academico">Grado académico <i class="text-danger">*</i></label>
                                <span class="text-muted ml-2" id="mostrar_cant_grado_academico"></span>
                            </div>
                            
                            <select class="form-control w-100" id="grado_academico" name="grado_academico" required disabled>
                                <option value="" selected>Seleccione</option>
                                <option value="Diplomado"> Diplomado</option>
                                <option value="Bachillerato"> Bachillerato </option>
                                <option value="Licenciatura"> Licenciatura </option>
                                <option value="Maestría"> Maestría </option>
                                <option value="Doctorado"> Doctorado </option>
                            </select>
                        </div>

                        {{-- Campo: Carrera cursada--}}
                        <div class=" mb-3">
                            <div class="d-flex justify-content-between w-100">
                                <label for="carrera_cursada">Carrera cursada <i class="text-danger">*</i></label>
                                <span class="text-muted ml-2" id="mostrar_cant_carrera_cursada"></span>
                            </div>
                            <input type='text' class="form-control" id="carrera_cursada" name="carrera_cursada" onkeyup="contarCarCarrCursada(this)" required disabled>
                        </div>

                        {{-- Campo: Año de graduación --}}
                        <div class=" mb-3">
                            <div class="d-flex justify-content-between w-100">
                                <label for="anio_graduacion">Año de graduación <i class="text-danger">*</i></label>
                                <span class="text-muted ml-2" id="mostrar_cant_anio_graduacion"></span>
                            </div>
                            <input type='number' class="form-control" id="anio_graduacion" name="anio_graduacion" onkeyup="contarCarAnioGraduacion(this)" min="1975" required disabled>
                        </div>
                    </div>
                @if(Accesos::ACCESO_MODIFICAR_TITULACIONES())
                </form>
                @endif

            </div>
            
            
            {{-- Botones para cerrar el modal o para guardar la edición --}}
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-gris" data-dismiss="modal" onclick="cancelarEdicion()">Cerrar</button>
                @if(Accesos::ACCESO_MODIFICAR_TITULACIONES())
                <button onclick="actualizar()" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                @endif
            </div>
        </div>
    </div>
</div>