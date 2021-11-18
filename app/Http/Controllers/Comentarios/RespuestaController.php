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
    public function index($comentario_id)
    {
        return Inertia::render('Respuestas/Index', [
            'comentario' => Comentario::with('user:id,name')
                ->findOrFail($comentario_id),
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

    public function store(StoreComentarioRequest $request, $comentario_id)
    {
        $respuesta = new Respuesta();
        $respuesta->user()->associate(Auth::id());
        $respuesta->comentario()->associate($comentario_id);
        $respuesta->contenido = $request->contenido;
        $respuesta->save();

        return back()->with('message', 'Respuesta enviada');
    }

    public function update(
        StoreComentarioRequest $request,
        $comentario_id,
        Respuesta $respuesta
    ) {
        $this->authorize('update', $respuesta);

        $respuesta->contenido = $request->contenido;
        $respuesta->save();

        return back()->with('message', 'Respuesta actualizada');
    }

    public function destroy($comentario_id, Respuesta $respuesta)
    {
        $this->authorize('delete', $respuesta);

        $respuesta->delete();

        return back()->with('message', 'Respuesta eliminada');
    }
}
