<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Media;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener todos los medios disponibles
        $media = Media::all();

        // Pasar los medios a la vista del Dashboard
        return Inertia::render('Dashboard', [
            'media' => $media,
        ]);
    }
}
