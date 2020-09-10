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
Contenido

@endsection

@section('pie')
Copyright
@endsection
