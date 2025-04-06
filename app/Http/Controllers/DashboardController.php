<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $mediaController = new MediaController();
        $media = $mediaController->index();

        // Pasar los medios a la vista del Dashboard
        return Inertia::render('Dashboard', [
            'media' => $media,
        ]);
    }
}
