<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    //     Route::get('/', [HomeController::class, "homePage"]);
    // Route::get('/aboutpage', [HomeController::class, "aboutPage"]);
    // Route::get('/contactpage', [HomeController::class, "contactPage"]);
    // Route::get('/postpage', [HomeController::class, "postPage"]);

    public function homePage()
    {
        return view('fontend.pages.index');
    }

    public function aboutPage()
    {
        return view('fontend.pages.about');
    }

    public function contactPage()
    {
        return view('fontend.pages.contact');
    }

    public function postPage()
    {
        return view('fontend.pages.post');
    }
}
