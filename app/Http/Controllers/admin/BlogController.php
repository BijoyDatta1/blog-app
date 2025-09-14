<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategoris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function createBlog(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
            'display' => 'required',
            'category_id' => 'required|array',
            'category_id.*' => 'required|exists:categoris,id',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'status' => "failed",
                'message' => $validator->errors()
            ]);
        }
//        return response()->json(['data' => $request->all()]);

        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/blog');
                $imageSave = $image->move($destinationPath, $imageName);
                if ($imageSave) {
                    $blog =  Blog::create([
                        'title' => $request->title,
                        'slug' =>  $request->slug,
                        'description' => $request->description,
                        'image' => '/uploads/blog/' . $imageName,
                        'status' => $request->status,
                        'display' => $request->display,
                        'user_id' => $request->header('id')
                    ]);


                    $totalCategory = $request->category_id;
                    foreach ($totalCategory as $category) {
                        BlogCategoris::create([
                            "blog_id"  => $blog->id,
                            "category_id" => $category,
                        ]);
                    }


                     DB::commit();

                    return response()->json([
                        'status' => "success",
                        'message' => "Blog Created Successfully"
                    ],200);

                }else{
                    return response()->json([
                        'status' => "failed",
                        'message' => "Image not moved"
                    ]);
                }

            }else{
                return response()->json([
                    'status' => "failed",
                    'message' => "problem in image upload"
                ]);
            }

        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => "failed",
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getBlogList(Request $request){
        $blog =  Blog::where('user_id', $request->header('id'))->get();
        if ($blog) {
            return response()->json([
                'status' => "success",
                'data' => $blog
            ],200);
        }
    }

    public function getBlogItem(Request $request){
        $blog = Blog::where('id',$request->id)->where('user_id', $request->header('id'))->first();
        $categoryBlog = BlogCategoris::where('blog_id',$request->id)->get();
        if ($blog) {
            return response()->json([
                'status' => "success",
                'data' => $blog,
                "blogCategoris" => $categoryBlog
            ],200);
        }
    }

    public function updateBlog(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'display' => 'required',
            'category_id' => 'required|array',
            'category_id.*' => 'required|exists:categoris,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => "failed",
                'message' => $validator->errors()
            ]);
        }

        try {
            DB::beginTransaction();

            $blog = Blog::where('id',$request->id)->where('user_id', $request->header('id'))->first();

            if ($request->hasFile('image')) {
                //delete old image
                $old_image = $blog->image;

                if($old_image && file_exists(public_path( $old_image))){
                    unlink(public_path($old_image));
                }

                // create new image
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/blog');
                $imageSave = $image->move($destinationPath, $imageName);
                if ($imageSave) {
                    $blog->image = '/uploads/blog/' . $imageName;
                }
            }
            $blog->title = $request->title;
            $blog->slug = $request->slug;
            $blog->description = $request->description;
            $blog->status = $request->status;
            $blog->display = $request->display;

            if ($blog->save()) {
                $categoris = $request->category_id;
                BlogCategoris::where('blog_id', $blog->id)->delete();
                foreach ($categoris as $category) {
                    BlogCategoris::create([
                        "blog_id"  => $blog->id,
                        "category_id" => $category,
                    ]);
                }
                DB::commit();

                return response()->json([
                    'status' => "success",
                    'message' => "Blog Updated Successfully"
                ],200);
            }

        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => "failed",
                'message' => $e->getMessage()
            ]);
        }
    }
    public function deleteBlog(Request $request){
        try {
            DB::beginTransaction();
            $blog = Blog::where('id',$request->id)->where('user_id', $request->header('id'))->first();
            if ($blog) {
                if(file_exists(public_path($blog->image))){
                    unlink(public_path($blog->image));
                }
                $blog->delete();

                //delete data form Blog Categoris
                BlogCategoris::where("blog_id", $request->id)->delete();
                DB::commit();
                return response()->json([
                    'status' => "success",
                    'message' => "Blog Deleted Successfully"
                ],200);
            }
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => "failed",
                'message' => $e->getMessage()
            ]);
        }
    }

    public function blogStatus(Request $request){
        try {
            $update = Blog::find($request['id']);
            $update->status = $request['status'];
            $status = $update->save();
            if($status){
                return response()->json([
                    "status" => "success",
                    "message" => "Blog status Changed successfully!"
                ],200);
            }

        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }

    }


}
