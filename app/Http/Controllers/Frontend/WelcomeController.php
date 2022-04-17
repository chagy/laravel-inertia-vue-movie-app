<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome',[
            'movies' => Movie::query()->with('genres')->get()
        ]);
    }
}
