<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeMedia;

class TypeMediaController extends Controller
{
    public function index()
    {
        $types = TypeMedia::all();
        return $types;
    }
}
