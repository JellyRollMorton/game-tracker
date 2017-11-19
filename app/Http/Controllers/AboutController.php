<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the static about page template
     *
     * @return mixed
     */
    public function show()
    {
        return view('about/show');
    }
}
