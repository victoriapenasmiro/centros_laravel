@extends('layouts.base')
@section('title', 'Editar centro ' . $centro->name)

@section('content')

    <h1 class="mb-5 text-center">Editar centro {{ $centro->name }}</h1>

    {{-- warning de errores de validacion del formulario --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('centros.update', [$lang, $centro]) }}" method="POST" enctype="multipart/form-data">

        {{-- genero token para poder enviar el formulario. Directoiva obligatoria en Laravel --}}
        @csrf

        {{-- Para actualizar registro, se debe hacer con el metodo PUT, y como html no permite 
            más que GET y POST, utilizamos esta directiva para especificarlo dejando el méthod en POST --}}
        @method("put")

        <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">{{ __('centros.nombre') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nombre" name="nombre"
                    placeholder="{{ __('centros.nombre') }}" value="{{ old('nombre', $centro->nombre) }}">
                @error('nombre')
                    <small class="text-danger">*{{ "$message" }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="asd" class="col-sm-2 col-form-label">{{ __('centros.asd') }}</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="asd" name="cod_asd"
                    value="{{ old('cod_asd', $centro->cod_asd) }}" placeholder="{{ __('centros.asd') }}">
                @error('cod_asd')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="descripcion" class="col-sm-2 col-form-label">{{ __('centros.descripcion') }}</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion"
                    placeholder="{{ __('centros.descrip_centro') }}">{{ old('descripcion', $centro->descripcion) }}</textarea>
                @error('descripcion')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="fecha_alta" class="col-sm-2 col-form-label">@lang('centros.fec_alta')</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="fecha_alta" name="fec_comienzo_actividad"
                    value="{{ old('fec_comienzo_actividad', $centro->fec_comienzo_actividad) }}"
                    placeholder="@lang('centros.fec_alta')">
                @error('fec_comienzo_actividad')
                    <small class="text-danger">*{{ $message }}</small>

                @enderror
            </div>
        </div>

        <fieldset class="form-group">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcion_radio" id="radio1" value="option1"
                            {{-- Si no existe y no es la primera vez que se accede al registro se marca checked --}} @if (old('opcion_radio') == 'option1')
                        checked
                    @elseif(!old('opcion_radio') && !$errors->any())
                        checked
                        @endif
                        > <label class="form-check-label" for="radio1">
                            @lang('centros.primer_radio')
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcion_radio" id="radio2" value="option2"
                            @if (old('opcion_radio') == 'option2')
                        checked
                    @elseif(!old('opcion_radio') && !$errors->any())
                        checked
                        @endif
                        >
                        <label class="form-check-label" for="radio2">
                            @lang('centros.segundo_radio')
                        </label>
                    </div>
                    <div class="form-check disabled">
                        <input class="form-check-input" type="radio" name="opcion_radio" id="radio3" value="option3"
                            disabled>
                        <label class="form-check-label" for="radio3">
                            @lang('centros.tercer_radio')
                        </label>
                    </div>
                    @error('opcion_radio')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

            </div>
        </fieldset>
        <div class="form-group row">
            <div class="col-sm-2">@lang('centros.guarderia')</div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="guarderia" name="guarderia" value="1"
                        {{-- Si no existe y no es la primera vez que se accede al registro se marca checked --}} @if (old('guarderia'))
                    checked
                @elseif(!old('guarderia') && !$errors->any())
                    checked
                    @endif
                    >

                    <label class="form-check-label" for="guarderia">
                        @lang('centros.con_guarderia')
                    </label>
                </div>
                @error('guarderia')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="categoria">{{ __('centros.categoria') }}</label>
            <select class="form-control" id="categoria" name="categoria">

                @for ($i = 0; $i < 6; $i++)
                    @if ($i === 0)
                        <option disabled selected>@lang('centros.selecciona')</option>
                    @else
                        <option value="{{ $i }}"
                            {{ old('categoria', $centro->categoria) == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endif
                @endfor

            </select>
            @error('categoria')
                <small class="text-danger">*{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="ambitos">{{ __('centros.ambitos') }} </label>
            <select multiple class="form-control" id="ambitos" name="ambitos[]">

                @foreach ($ambitos as $ambito)
                    <option value="{{ $ambito->id }}" @if (old('ambitos'))
                        {{ in_array($ambito->id, old('ambitos')) ? 'selected' : '' }}
                    @elseif(!old('ambitos') && !$errors->any() && in_array($ambito->id, $ambitos_id))
                        selected
                @endif
                >
                {{ __('centros.' . $ambito->nombre) }}</option>
                @endforeach

            </select>
            @error('ambitos')
                <small class="text-danger">*{{ $message }}</small>
            @enderror
        </div>

        {{-- Por razones de seguridad, los navegadores no pueden recuperar la ubicacion
            del fichero, por tanto, no es posible utilizar old values aquí
            + info en https://stackoverflow.com/questions/16365668/pre-populate-html-form-file-input --}}
        <div class="form-group">
            <label for="logo"><strong>LOGO</strong></label>
            <input type="file" class="form-control-file" id="logo" name="logo">
            @error('logo')
                <small class="text-danger">*{{ $message }}</small>
            @enderror
        </div>

        @if ($centro->logo)
            <div class="col-12 my-3">
                <img src="{{ asset('storage/' . $centro->logo) }}" alt="logo {{ $centro->nombre }}" height="150" />
            </div>
        @endif

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success">{{ __('centros.actualizar') }}</button>
                <a href="{{ route('centros.index', $lang) }}" class="btn btn-primary">@lang('centros.volver')</a>
            </div>
        </div>
    </form>

@endsection
