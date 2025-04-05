<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;


class MediaController extends Controller
{
    public function index()
    {
        // Verifica si el usuario es administrador o cliente
        if (Auth::user()->role == 'admin') {
            // Si es admin, mostrar todos los medios y la opción de editar/eliminar
            $media = Media::all();
        } else {
            // Si es cliente, solo mostrar los medios disponibles (por ejemplo, sin la opción de editar/eliminar)
            $media = Media::where('is_available', true)->get();
        }

        return view('media.index', compact('media'));
    }

    public function show($id)
    {
        // Verifica si el usuario es admin o cliente y devuelve los detalles del medio
        $media = Media::findOrFail($id);

        if (Auth::user()->role == 'admin') {
            // Los administradores pueden editar/eliminar el medio
            return view('media.show', compact('media'));
        } else {
            // Los clientes solo pueden ver el detalle del medio
            return view('media.show-client', compact('media'));
        }
    }
}
