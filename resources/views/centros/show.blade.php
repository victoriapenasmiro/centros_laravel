@extends('layouts.base')
@section('title', $centro->nombre)

@section('content')

    <h1 class="mb-5 text-center">Centro {{ $centro->nombre }}</h1>
    <ul>
        <li>Nombre: {{ $centro->nombre }}</li>
        <li>Descripción: {{ $centro->descripcion }}</li>
        <li>Código asd: {{ $centro->cod_asd }}</li>
        <li>Fecha inicio: {{ $centro->fec_comienzo_actividad }}</li>
        <li>Radio: {{ $centro->opcion_radio }}</li>
        <li>Dispone de guardería: {{ $centro->guarderia }}</li>
        <li>Categoría: {{ $centro->categoria }}</li>
        <li>Ámbitos:

            @for ($i = 0; $i < count($listado_ambitos); $i++)
                {{ $listado_ambitos[$i] }}@if ($i < count($listado_ambitos) - 1), @endif
            @endfor

        </li>
        @if ($centro->logo)
            <li>Logo:
                <div class="col-12 my-3">
                    <img src="{{ asset('storage/' . $centro->logo) }}" alt="logo {{ $centro->nombre }}" height="200" />
                </div>
            </li>
        @endif
    </ul>

    @can('delete', $can_modify)
        <form action="{{ route('centros.destroy', [$lang, $centro]) }}" method="POST" style="display:inline;">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    @endcan

    @can('update', $can_modify)
        <a href="{{ route('centros.edit', [$lang, $centro]) }}" class="btn btn-success">Editar centro</a>
    @endcan

    <a href="{{ route('centros.index', $lang) }}" class="btn btn-primary">Volver al listado</a>

@endsection
