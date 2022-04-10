<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class EpisodeController extends Controller
{
    public function index(TvShow $tvShow,Season $season)
    {
        $perPage = Request::input('perPage') ? : 5;
        
        return Inertia::render('TvShows/Seasons/Episodes/Index',[
            'tvShow' => $tvShow,
            'episodes' => Episode::query()
                            ->where('season_id',$season->id)
                            ->when(Request::input('search'),function($query,$search){
                                $query->where('name','like',"%{$search}%");
                            })
                            ->paginate($perPage)
                            ->withQueryString(),
            'filters' => Request::only(['search','perPage']),
            'season' => $season
        ]);
    }
}
