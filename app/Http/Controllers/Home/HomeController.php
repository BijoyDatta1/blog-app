<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategoris;
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

    public function postPage($id)
    {
        return view('fontend.pages.post',compact('id'));
    }
    public function getPostItem(Request $request){
        $blog = Blog::where('id',$request->id)->with(['user', 'categories'])->first();
        $categoryBlog = BlogCategoris::where('blog_id',$request->id)->get();
        if ($blog) {
            return response()->json([
                'status' => "success",
                'data' => $blog,
                "blogCategoris" => $categoryBlog
            ],200);
        }
    }

    public function getPost(Request $request){

        $page = $request->get('page', 1);
        $query = $request->get('query', '');

        $blog = Blog::with(['user','categories'])->when($query,function($q) use ($query){
            $q->where('title','like','%'.$query.'%')->orWhere("description","like","%$query%");
        })->paginate(4);

        if($blog){
           return response()->json([
                'status'=> "success",
                'blog' => $blog,
            ],200);
        }

    }
}
