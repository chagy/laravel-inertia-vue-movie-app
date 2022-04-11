<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Movie;
use App\Models\TrailerUrl;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;


class MovieAttachController extends Controller
{
    public function index(Movie $movie)
    {
        return Inertia::render('Movies/Attach',[
            'movie' => $movie,
            'trailers' => $movie->trailers
        ]);
    }

    public function addTrailer(Movie $movie)
    {
        $movie->trailers()->create(Request::validate([
            'name' => 'required',
            'embed_html' => 'required'
        ]));

        return Redirect::back()->with('flash.banner','Trailer Added.');
    }

    public function destroyTrailer(TrailerUrl $trailerUrl)
    {
        $trailerUrl->delete();
        return Redirect::back()->with('flash.banner','Trailer destroy.');
    }
}
