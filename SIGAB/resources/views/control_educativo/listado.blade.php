@extends('layouts.app')

@section('titulo')
Listado Estudiantil
@endsection

@section('css')

@endsection



@section('contenido')

{{ $estudiantes }}


<div class="card shadow">
    <div class="card-header py-3">
        <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de estudiantes </p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 text-nowrap">
                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label>Mostrar<select class="form-control form-control-sm custom-select custom-select-sm">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select></label></div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Buscar estudiante" /></label></div>
            </div>
        </div>
        <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

            <table class="table my-0" id="dataTable">
                <thead>
                    <tr>
                        <th>N° de Cédula</th>
                        <th>Nombre</th>
                        <th>Carrera (Principal) matriculada</th>
                        <th>Teléfono celular</th>
                        <th>Correo</th>
                        <th>Guía Académica</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="estudiante" class="cursor-pointer" onclick="clickEnEstudiante()">
                        <td>117380366</td>
                        <td><img class="rounded-circle mr-2" width="30" height="30" src="avatars/Foto.jpg" />Aguilar Rojas, David</td>
                        <td>Ingeniería en Sistemas de Información </td>
                        <td>84494891<br /></td>
                        <td><strong>Correo@ejemplo.com</strong><br /></td>
                        <td><strong>
                                <div class="btn btn-contorno-rojo"> Ver guías </div>
                            </strong><br /></td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>N° de Cédula<br /></strong></td>
                        <td>Nombre</td>
                        <td><strong>Carrera (Principal) matriculada<br /></strong></td>
                        <td><strong>Telefono Celular</strong><br /></td>
                        <td><strong>Correo<br /></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6 align-self-center">
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 500</p>
            </div>
            <div class="col-md-6">
                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>



@endsection


@section('scripts')

@endsection

@section('pie')
Copyright
@endsection
