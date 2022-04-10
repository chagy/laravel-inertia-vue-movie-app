<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class SeasonController extends Controller
{
    public function index(TvShow $tvShow)
    {
        $perPage = Request::input('perPage') ? : 5;
        
        return Inertia::render('TvShows/Seasons/Index',[
            'tvShow' => $tvShow,
            'seasons' => Season::query()
                            ->where('tv_show_id',$tvShow->id)
                            ->when(Request::input('search'),function($query,$search){
                                $query->where('name','like',"%{$search}%");
                            })
                            ->paginate($perPage)
                            ->withQueryString(),
            'filters' => Request::only(['search','perPage'])
        ]);
    }
}
