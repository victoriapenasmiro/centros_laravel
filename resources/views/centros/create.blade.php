@extends('layouts.base')
@section('title', 'Nuevo Centro')

@section('content')

    <h1 class="mb-5 text-center">@lang('centros.nuevo_centro')</h1>

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

    {{-- enctype --> para aceptación de envío de archivos --}}
    <form action="{{ route('centros.store', $lang) }}" method="POST" enctype="multipart/form-data">

        {{-- genero token para poder enviar el formulario. Directoiva obligatoria en Laravel --}}
        @csrf

        <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">{{ __('centros.nombre') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nombre" name="nombre"
                    placeholder="{{ __('centros.nombre') }}" value="{{ old('nombre') }}">
                @error('nombre')
                    <small class="text-danger">*{{ "$message" }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="asd" class="col-sm-2 col-form-label">{{ __('centros.asd') }}</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="asd" name="cod_asd" value="{{ old('cod_asd') }}"
                    placeholder="{{ __('centros.asd') }}">
                @error('cod_asd')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="descripcion" class="col-sm-2 col-form-label">{{ __('centros.descripcion') }}</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion"
                    placeholder="{{ __('centros.descrip_centro') }}">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="fecha_alta" class="col-sm-2 col-form-label">@lang('centros.fec_alta')</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="fecha_alta" name="fec_comienzo_actividad"
                    value="{{ old('fec_comienzo_actividad') }}" placeholder="@lang('centros.fec_alta')">
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
                            {{ old('opcion_radio') == 'option1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="radio1">
                            @lang('centros.primer_radio')
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcion_radio" id="radio2" value="option2"
                            {{ old('opcion_radio') == 'option2' ? 'checked' : '' }}>
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
                        {{ old('guarderia') ? 'checked' : '' }}>
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
                        <option value="{{ $i }}" {{ old('categoria') == $i ? 'selected' : '' }}>
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
                    <option value="{{ $ambito->id }}" @if (old('ambitos')){{ in_array($ambito->id, old('ambitos')) ? 'selected' : '' }}@endif>
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

        <div class="form-group row mt-3">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success">{{ __('centros.registrar') }}</button>
                <a href="{{ route('centros.index', $lang) }}" class="btn btn-primary">@lang('centros.volver')</a>
            </div>
        </div>

    </form>
@endsection
