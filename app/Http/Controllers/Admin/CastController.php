<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cast;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class CastController extends Controller
{
    public function index()
    {
        return Inertia::render('Casts/Index',[
            'casts' => Cast::paginate(5),
            'filters' => Request::only(['search','perPage'])
        ]);
    }

    public function store()
    {
        $cast = Cast::where('tmdb_id', Request::input('castTMDBId'))->first();

        $tmdb_cast = Http::get(config('services.tmdb.endpoint').'person/'. Request::input('castTMDBId') .'?api_key='.config('services.tmdb.secret').'&language=en-US');

        if ($cast) {
            return Redirect::route('admin.casts.index')
                        ->with('flash.banner','Cast exisit')
                        ->with('flash.bannerStyle','danger');
        }

        if ($tmdb_cast->successful()) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name'    => $tmdb_cast['name'],
                'slug'    => Str::slug($tmdb_cast['name']),
                'poster_path' => $tmdb_cast['profile_path']
            ]);
            return Redirect::route('admin.casts.index')
                        ->with('flash.banner','Cast created.');
        } else {
            return Redirect::route('admin.casts.index')
                        ->with('flash.banner','Api Error')
                        ->with('flash.bannerStyle','danger');
        }
    }
}
