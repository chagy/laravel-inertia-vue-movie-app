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
        $latest = Movie::orderBy('created_at', 'desc')->take(9)->get();
        return Inertia::render('Frontend/Movies/Show',[
            'movie'     => $movie, 
            'latests'   => $latest,
            'genres'    => $movie->genres,
            'casts'     => $movie->casts,
            'tags'      => $movie->tags,
            'trailers'  => $movie->trailers,
        ]);
    }
}
