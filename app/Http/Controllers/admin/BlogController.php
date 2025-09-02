<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function blogCreatePage()
    {
        return view('admin.pages.create-blog');
    }
    public function blogListPage()
    {
        return view('admin.pages.blog-list');
    }
}
