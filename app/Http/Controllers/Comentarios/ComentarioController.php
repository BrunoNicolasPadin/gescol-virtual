<?php

namespace App\Http\Controllers\Comentarios;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comentarios\StoreComentarioRequest;
use App\Models\Comentarios\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(StoreComentarioRequest $request)
    {
        $this->authorize('create', [Comentario::class, $request->type]);

        $comentario = new Comentario();
        $comentario->commentable_type = $request->type;
        $comentario->commentable_id = $request->id;
        $comentario->contenido = $request->contenido;
        $comentario->user()->associate(Auth::id());
        $comentario->save();

        return back()->with('message', 'Comentario enviado');
    }

    public function update(StoreComentarioRequest $request, Comentario $comentario)
    {
        $this->authorize('update', $comentario);

        $comentario->contenido = $request->contenido;
        $comentario->save();

        return back()->with('message', 'Comentario actualizado');
    }

    public function destroy(Comentario $comentario)
    {
        $this->authorize('delete', $comentario);

        $comentario->delete();

        return back()->with('message', 'Comentario eliminado');
    }
}
