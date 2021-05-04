<div class="modal fade" id="detalle-trabajo-modal" tabindex="-1" aria-labelledby="detalle-trabajo-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold" id="detalle-trabajo-modal">Detalle del trabajo</h5>
                    <div class="d-flex justify-content-end">

                        @if(Accesos::ACCESO_MODIFICAR_TRABAJOS())
                        <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                            Habilitar edición
                        </button>
                        <button type="button" class="btn btn-rojo" id="cancelar-edicion">
                            Cancelar
                        </button>
                        @endif
                    </div>
            </div>
            <div class="modal-body">

                @if(Accesos::ACCESO_MODIFICAR_TRABAJOS())
                {{-- Formulario para actualizar informacion laboral --}}
                <form autocomplete="off" method="POST" role="form" enctype="multipart/form-data" id="form-actualizar">
                    @csrf
                    @method('PATCH')
                @endif
                
                    <div class="row">

                        {{-- Campos de la izquierda --}}
                        <div class="col">

                            {{-- Campo: Nombre de la organizacion --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="nombre_organizacion">Nombre de la organización:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="nombre_organizacion" name="nombre_organizacion" onkeyup="contarCarNomOrg(this)" required disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_nom_org"></span>
                                </div>
                            </div>

                            {{-- Campo: Jornada laboral --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="jornada_laboral">Jornada laboral:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="jornada_laboral" name="jornada_laboral" onkeyup="contarCarJornLab(this)" required disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_jorn_lab"></span>
                                </div>
                            </div>

                            {{-- Campo: Jefe inmediato --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="jefe_inmediato">Jefe inmediato:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="jefe_inmediato" name="jefe_inmediato" onkeyup="contarCarJefInme(this)" disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_jef_inme"></span>
                                </div>
                            </div>

                            {{-- Campo: Tiempo desempleado --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="tiempo_desempleado">Tiempo desempleado:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="tiempo_desempleado" name="tiempo_desempleado" onkeyup="contarCarTiempDesempl(this)" disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_tiemp_desmp"></span>
                                </div>
                            </div>

                            {{-- Campo: Intereses Capacitacion --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="interes_capacitacion">Intereses capacitación:</label>
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control w-100" id="interes_capacitacion" name="interes_capacitacion" disabled></textarea>
                                </div>
                            </div>

                        </div>

                        {{-- Campos de la derecha --}}
                        <div class="col">

                            {{-- Campo: Tipo de organizacion --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="tipo_organizacion">Tipo de organización:</label>
                                </div>
                                <div class="col-6">
                                    {{-- <input type='text' class="form-control w-100" id="tipo_organizacion" name="tipo_organizacion" onkeyup="contarCarTipOrg(this)" required> --}}
                                    <select name="tipo_organizacion" class="form-control w-100" id="tipo_organizacion" disabled>
                                        <option value="Instituciones públicas">Instituciones públicas</option>
                                        <option value="Instituciones privadas">Instituciones privadas</option>
                                        <option value="Instituciones autónomas">Instituciones autónomas</option>
                                        <option value="Instituciones semiautónomas">Instituciones semiautónomas</option>
                                        <option value="Organismos internacionales (ONGs)">Organismos internacionales (ONGs)</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_tip_org"></span>
                                </div>
                            </div>

                            {{-- Campo: Cargo actual --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="cargo_actual">Cargo actual:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="cargo_actual" name="cargo_actual" onkeyup="contarCarCargAct(this)" required disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_carg_act"></span>
                                </div>
                            </div>

                            {{-- Campo: Telefono trabajo --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="telefono_trabajo">Teléfono trabajo:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="telefono_trabajo" name="telefono_trabajo" onkeyup="contarCarTelfTrbj(this)" disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_tel_trbj"></span>
                                </div>
                            </div>

                            {{-- Campo: Correo trabajo --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="correo_trabajo">Correo trabajo:</label>
                                </div>
                                <div class="col-6">
                                    <input type='text' class="form-control w-100" id="correo_trabajo" name="correo_trabajo" onkeyup="contarCarCorrTrbj(this)" disabled>
                                </div>
                                <div class="col-1">
                                    <span class="text-muted" id="mostrar_cant_corr_trbj"></span>
                                </div>
                            </div>

                            {{-- Campo: Otros estudios --}}
                            <div class="d-flex justify-content-start mb-3">
                                <div class="col-4">
                                    <label for="otros_estudios">Otros estudios:</label>
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control w-100" id="otros_estudios" name="otros_estudios" disabled></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    @if(Accesos::ACCESO_MODIFICAR_TRABAJOS())
                    </form>
                    @endif
            </div>

            {{-- Botones para cerrar el modal o para guardar la edición --}}
            <div class="modal-footer d-flex justify-content-center">
                @if(Accesos::ACCESO_MODIFICAR_TRABAJOS())
                <button onclick="actualizar()" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                @endif
                <button type="button" class="btn btn-gris" data-dismiss="modal" onclick="cancelarEdicion()">Cerrar</button>
            </div>
        </div>
    </div>
</div>