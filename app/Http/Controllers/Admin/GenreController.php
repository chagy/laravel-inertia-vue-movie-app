<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class GenreController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage') ? : 5;

        return Inertia::render('Genres/Index',[
            'genres' => Genre::query()
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
        $tmdb_genres = Http::get(config('services.tmdb.endpoint').'genre/movie/list?api_key='.config('services.tmdb.secret').'&language=en-US');
        if($tmdb_genres->successful()){
            $tmdb_genres_json = $tmdb_genres->json();
            foreach ($tmdb_genres_json as $key => $single_tmdb_genre) {
                foreach ($single_tmdb_genre as $key => $tgenre) {
                    $genre = Genre::where('tmdb_id',$tgenre['id'])->first();
                    if(!$genre){
                        Genre::create([
                            'tmdb_id' => $tgenre['id'],
                            'title' => $tgenre['name']
                        ]);
                    }
                    # code...
                }
            }

            return Redirect::back()->with('flash.banner','genre created.');
        }
        return Redirect::back()->with('flash.banner','Api Error.');
    }
}
