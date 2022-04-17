<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Movies/Index',[
            'movies' => Movie::orderBy('created_at','desc')->with('genres')->paginate(12)
        ]);
    }

    public function show(Movie $movie)
    {

    }
}
