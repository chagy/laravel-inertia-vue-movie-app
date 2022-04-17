<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Movie;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome',[
            'movies' => Movie::query()->with('genres')->get(),
            'tvShows' => TvShow::withCount('seasons')->orderBy('created_at','desc')->take(12)->get(),
            'episodes' => Episode::orderBy('created_at','desc')->with('season')->take(12)->get()
        ]);
    }
}
