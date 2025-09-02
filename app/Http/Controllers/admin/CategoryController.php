<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function categoryCreatePage()
    {
        return view('admin.pages.create-category');
    }

    public function categorylistpage()
    {
        return view('admin.pages.category-list');
    }
}
