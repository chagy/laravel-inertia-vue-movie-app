<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller
{
    public function index()
    {
        return Inertia::render('Tags/Index');
    }

    public function create()
    {
        return Inertia::render('Tags/Create');
    }

    public function store()
    {
        Tag::create([
            'tag_name' => Request::input('tagName'),
            'slug'     => Str::slug(Request::input('tagName'))
        ]);

        return Redirect::route('admin.tags.index');
    }
}
