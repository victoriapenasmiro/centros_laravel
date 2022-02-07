<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCentro;
use App\Models\Ambito;
use App\Models\Centro;
use App\Models\Centro_Ambito;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CentroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang)
    {
        $this->authorize('check-language', $lang);
        $can_modify = new Centro;

        $centros = Centro::all();

        return view('centros.index', compact('lang', 'centros', 'can_modify'));
        //return redirect()->route('centros.create', compact('lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang)
    {
        $can_create = new Centro;
        $ambitos = Ambito::all();

        $this->authorize('check-language', $lang);
        $this->authorize('create', $can_create, 403);

        return view('centros.create', compact('lang', 'ambitos', 'can_create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCentro $request, $lang)
    {

        $can_create = new Centro;
        $this->authorize('create', $can_create, 403);

        // ********* sentencia raw *********

        // $centro = [
        //     $request->input('nombre'),
        //     $request->input('descripcion'),
        //     $request->input('cod_asd'),
        //     $request->input('fec_comienzo_actividad'),
        //     $request->input('opcion_radio'),
        //     $request->input('guarderia'),
        //     $request->input('categoria'),
        //     Carbon::now(), # new \Datetime() created_at
        //     Carbon::now(),  # new \Datetime() updated_at
        //     $request->file('logo')->store('images', 'public')
        // ];

        // DB::insert(
        //     'insert into centros (nombre, descripcion, cod_asd, fec_comienzo_actividad, opcion_radio, guarderia, 
        // categoria, created_at, updated_at, logo) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        //     $centro
        // );

        //completo la tabla intermedia centros_ambitos de forma aleatoria
        // $centro_id = DB::getPdo()->lastInsertId();
        // $ambitos = $request->input('ambitos');

        // foreach ($ambitos as $ambito) {
        //     DB::insert(
        //         'insert into centros_ambitos (centro_id, ambito_id, created_at, updated_at) values (?, ?, ?, ?)',
        //         array($centro_id, $ambito, Carbon::now(), Carbon::now())
        //     );
        // }


        // ********* QueryBuilder *********

        // $centro = [
        //     'nombre' => $request->input('nombre'),
        //     'descripcion' => $request->input('descripcion'),
        //     'cod_asd' => $request->input('cod_asd'),
        //     'fec_comienzo_actividad' => $request->input('fec_comienzo_actividad'),
        //     'opcion_radio' => $request->input('opcion_radio'),
        //     'guarderia' => $request->input('guarderia'),
        //     'categoria' => $request->input('categoria'),
        //     "created_at" =>  Carbon::now(), # new \Datetime()
        //     "updated_at" => Carbon::now(),  # new \Datetime()
        //     "logo" => $request->file('logo')->store('images', 'public'),
        // ];

        //DB::table('centros')->insert($centro);

        //completo la tabla intermedia centros_ambitos de forma aleatoria
        // $centro_id = DB::getPdo()->lastInsertId();
        // $ambitos = $request->input('ambitos');

        // foreach ($ambitos as $ambito) {
        //     DB::table('centros_ambitos')->insert(['centro_id' => $centro_id, 'ambito_id' => $ambito, "created_at" =>  \Carbon\Carbon::now(), "updated_at" =>  \Carbon\Carbon::now()]);
        // }


        // ********* Eloquent *********

        //para evitar tener que realizar dos conexiones a db, evitamos hacer un primer insert con la sentencia siguiente
        //$centro = Centro::create($request->all());

        $centro = new Centro($request->all());

        //$request->file('logo') --> ubicación temporal del archivo
        //reubicamos el archivo en storage/app/public
        $centro->logo = $request->file('logo')->store('images', 'public');
        $centro->save();

        //completo la tabla centros_ambitos
        $centro->ambitos()->attach($request->input('ambitos'));

        //almaceno en una sesión un mensaje de éxito para mostrar en alert
        return redirect()->to(RouteServiceProvider::HOME)->with('exito', 'Centro registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Centro $centro)
    {

        $can_modify = new Centro;
        $this->authorize('check-language', $lang);

        //recupero el listado de ambitos de este centro
        $ambitos_id = $centro->ambitos()->allRelatedIds()->toArray();

        $listado_ambitos = [];

        foreach ($ambitos_id as $ambito) {
            array_push($listado_ambitos, Ambito::find($ambito)->nombre);
        }

        return view('centros.show', compact('lang', 'centro', 'listado_ambitos', 'can_modify'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, Centro $centro)
    {
        $ambitos = Ambito::all();
        $can_edit = new Centro;
        $this->authorize('update', $can_edit, 403);

        //recupero el listado de ambitos de este centro
        $ambitos_id = $centro->ambitos()->allRelatedIds()->toArray();

        $this->authorize('check-language', $lang);

        return view('centros.edit', compact('lang', 'centro', 'ambitos', 'ambitos_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCentro $request, $lang, Centro $centro)
    {
        $can_edit = new Centro;
        $this->authorize('update', $can_edit, 403);

        if ($request->hasFile('logo')) {

            //eliminamos anterior imagen asociada a esta entrada
            //especifico que está alojada en Storage/public, ya que por defecto busca en la raix de Storage
            Storage::disk('public')->delete($centro->logo);

            $centro->fill($request->all());
            $centro->logo = $request->file('logo')->store('images', 'public');
            $centro->save();

        } else {

            $centro->update($request->all());
        }

        //actualizo la tabla intermedia centros_ambitos
        $centro->ambitos()->sync($request->input('ambitos'));

        return redirect()->route('centros.show', compact('lang', 'centro'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Centro $centro)
    {
        $can_delete = new Centro;
        $this->authorize('delete', $can_delete, 403);

        //elimino la imagen del disco
        Storage::disk('public')->delete($centro->logo);

        //elimino el registro de la db
        $centro->delete();

        // Elimino la relación del centro con ambitos dentro de centros_ambitos
        $centro->ambitos()->detach();

        //almaceno en una sesión un mensaje de éxito para mostrar en alert
        return redirect()->route('centros.index', compact('lang'))->with('eliminado', 'Centro eliminado correctamente');
    }
}
