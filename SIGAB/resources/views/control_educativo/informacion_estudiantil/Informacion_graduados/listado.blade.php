@extends('layouts.app')

@section('titulo')
Listado Estudiantil
@endsection

@section('css')

@endsection



@section('contenido')

<div class="card">
    <div class="card-body">
        <span>
            @foreach($graduados as $graduado)
            {{ $graduado }}
            @endforeach
        </span>
    </div>
</div>


@endsection


@section('scripts')

@endsection

@section('pie')
Copyright
@endsection
