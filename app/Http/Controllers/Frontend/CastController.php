<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cast;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CastController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Casts/Index',[
            'casts' => Cast::orderBy('updated_at','desc')->paginate(12)
        ]);
    }

    public function show(Cast $cast)
    {
        
    }
}
