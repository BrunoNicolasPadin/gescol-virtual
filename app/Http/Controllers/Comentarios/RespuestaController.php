<?php

namespace App\Http\Controllers\Comentarios;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comentarios\StoreComentarioRequest;
use App\Models\Comentarios\Comentario;
use App\Models\Comentarios\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($comentario_id)
    {
        return Inertia::render('Respuestas/Index', [
            'comentario' => Comentario::with('user:id,name')->findOrFail($comentario_id),
            'respuestas' => Respuesta::where('comentario_id', $comentario_id)
                ->with('user:id,name')
                ->orderBy('created_at', 'DESC')
                ->paginate(10),
        ]);
    }

    public function paginarRespuestas(Request $request, $comentario_id)
    {
        return Respuesta::where('comentario_id', $comentario_id)
            ->with('user:id,name')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComentarioRequest $request, $comentario_id)
    {
        $respuesta = new Respuesta();
        $respuesta->user()->associate(Auth::id());
        $respuesta->comentario()->associate($comentario_id);
        $respuesta->contenido = $request->contenido;
        $respuesta->save();

        echo 'Respuesta - Store';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreComentarioRequest $request, $comentario_id, $id)
    {
        $respuesta = Respuesta::findOrFail($id);
        $respuesta->contenido = $request->contenido;
        $respuesta->save();

        echo 'Respuesta - Update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comentario_id, $id)
    {
        Respuesta::destroy($id);
        echo 'Respuesta - Eliminado';
    }
}
