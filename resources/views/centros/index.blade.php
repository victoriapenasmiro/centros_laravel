@extends('layouts.base')
@section('title', 'Listado de centros educativos')

@section('idiomas')

    @php
        $other_lang = $lang == 'es' ? 'en' : 'es';
    @endphp

    ¡Cambia el idioma!
    <a href={{ route('centros.index', $other_lang) }}>{{ Str::upper($other_lang) }}</a>

@endsection

@section('content')

    <h1 class="mb-5 text-center">Listado de centros educativos</h1>

    @if (session('eliminado'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('eliminado') }}
        </div>

    @elseif (session('exito'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('exito') }}
        </div>
    @endif

    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Codigo ASD</th>
                <th scope="col">Inicio actividad</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($centros as $centro)
                <tr>
                    <td>{{ $centro->nombre }}</td>
                    <td>{{ $centro->cod_asd }}</td>
                    <td>{{ $centro->fec_comienzo_actividad }}</td>
                    <td><a href={{ route('centros.show', [$lang, $centro]) }} class="btn btn-primary">Ver</a></td>
                    <td>
                        @can('update', $can_modify)
                        <a href={{ route('centros.edit', [$lang, $centro]) }} class="btn btn-success">Editar</a>
                        @endcan
                    </td>
                    <td>
                        @can('delete', $can_modify)
                        <form action="{{ route('centros.destroy', [$lang, $centro]) }}" method="POST">
                            @csrf
                            @method('delete')

                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        @endcan
                </tr>
            @endforeach
        </tbody>
    </table>

    @can('create', $can_modify)
    <a href="{{ route('centros.create', $lang) }}" class="btn btn-primary mb-5">Crear nuevo centro</a>
    @endcan

@endsection
