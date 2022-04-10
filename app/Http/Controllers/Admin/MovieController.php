<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Genre;
use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class MovieController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage') ? : 5;

        return Inertia::render('Movies/Index',[
            'movies' => Movie::query()
                            ->when(Request::input('search'),function($query,$search){
                                $query->where('title','like',"%{$search}%");
                            })
                            ->paginate($perPage)
                            ->withQueryString(),
            'filters' => Request::only(['search','perPage'])
        ]);
    }

    public function store()
    {
        $movie = Movie::where('tmdb_id', Request::input('movieTMDBId'))->exists();
        if ($movie) {
            return Redirect::back()
                        ->with('flash.banner','Movie created.');
            return;
        }
        
        $apiMovie = Http::get(config('services.tmdb.endpoint').'movie/'.Request::input('movieTMDBId').'?api_key='.config('services.tmdb.secret').'&language=en-US');

        if ($apiMovie->successful()) {

            $created_movie = Movie::create([
                'tmdb_id' => $apiMovie['id'],
                'title' => $apiMovie['title'],
                'runtime' => $apiMovie['runtime'],
                'rating' => $apiMovie['vote_average'],
                'release_date' => $apiMovie['release_date'],
                'lang' => $apiMovie['original_language'],
                'video_format' => 'HD',
                'is_public' => false,
                'overview' => $apiMovie['overview'],
                'poster_path' => $apiMovie['poster_path'],
                'backdrop_path' => $apiMovie['backdrop_path']
            ]);
            $tmdb_genres = $apiMovie['genres'];
            $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
            $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
            $created_movie->genres()->attach($genres);
            return Redirect::back()->with('flash.banner','Movie Exists.');
        } else {
            return Redirect::back()->with('flash.banner','Api Error.');
        }
    }

}
