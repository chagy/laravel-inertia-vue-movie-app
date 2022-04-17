<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TvShowController extends Controller
{
    public function index()
    {
        
    }

    public function show(TvShow $tvShow)
    {

    }

    public function seasonShow(TvShow $tvShow,Season $season)
    {
        
    }

    public function showEpisode(Episode $episode)
    {

    }
}
