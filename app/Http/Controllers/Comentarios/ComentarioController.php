<?php

namespace App\Http\Controllers\Comentarios;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comentarios\StoreComentarioRequest;
use App\Models\Comentarios\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComentarioRequest $request)
    {
        $comentario = new Comentario();
        $comentario->commentable_type = $request->type;
        $comentario->commentable_id = $request->id;
        $comentario->contenido = $request->contenido;
        $comentario->user()->associate(Auth::id());
        $comentario->save();

        echo 'Comentario - Guardado';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreComentarioRequest $request, $id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->contenido = $request->contenido;
        $comentario->save();

        echo 'Comentario - Actualizado';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comentario::destroy($id);

        echo 'Comentario - Eliminado';
    }
}
