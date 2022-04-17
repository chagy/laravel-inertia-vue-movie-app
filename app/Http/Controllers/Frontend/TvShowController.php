<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TvShowController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/TvShows/Index',[
            'tvShows' => TvShow::orderBy('created_at','desc')->paginate(12)
        ]);
    }

    public function show(TvShow $tvShow)
    {
        $latests = TvShow::orderBy('created_at', 'desc')->take(9)->get();

        return Inertia::render('Frontend/TvShows/Show',[
            'tvShow' => $tvShow,
            'seasons' => $tvShow->seasons,
            'latests' => $latests
        ]);
    }

    public function seasonShow(TvShow $tvShow,Season $season)
    {
        $latests = TvShow::orderBy('created_at', 'desc')->take(9)->get();

        return Inertia::render('Frontend/TvShows/Seasons/Show',[
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => $season->episodes,
            'latests' => $latests,
        ]);
    }

    public function showEpisode(Episode $episode)
    {

    }
}
