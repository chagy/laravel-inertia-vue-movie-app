<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

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

    public function store(TvShow $tvShow)
    {
        $season = $tvShow->seasons()->where('season_number', Request::input('seasonNumber'))->exists();

        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint').'tv/'.$tvShow->tmdb_id.'/season/'. Request::input('seasonNumber') .'?api_key='.config('services.tmdb.secret').'&language=en-US');

        if ($season) {
            return Redirect::back()
                        ->with('flash.banner','Season exisits')
                        ->with('flash.bannerStyle','danger');
        }

        if ($tmdb_season->successful()) {
            
            Season::create([
                'tv_show_id' => $tvShow->id,
                'tmdb_id' => $tmdb_season['id'],
                'name'    => $tmdb_season['name'],
                'poster_path' => $tmdb_season['poster_path'],
                'season_number' => $tmdb_season['season_number'],
            ]);
            return Redirect::back()
                        ->with('flash.banner','Season created.');
        } else {
            return Redirect::back()
                        ->with('flash.banner','Api Error')
                        ->with('flash.bannerStyle','danger');
        }
    }

    public function edit(TvShow $tvShow,Season $season)
    {
        return Inertia::render('TvShows/Seasons/Edit',[
            'tvShow' => $tvShow,
            'season' => $season
        ]);
    }

    public function update(TvShow $tvShow,Season $season)
    {
        $validated = Request::validate([
            'name' => 'required',
            'poster_path' => 'required'
        ]);

        $season->update($validated);

        return Redirect::route('admin.seasons.index',$tvShow->id)
                ->with('flash.banner','Season updated.');
    }

    public function destroy(TvShow $tvShow,Season $season)
    {
        $season->delete();

        return Redirect::back()
                        ->with('flash.banner','Season deleted.')
                        ->with('flash.bannerStyle','danger');
    }
}
