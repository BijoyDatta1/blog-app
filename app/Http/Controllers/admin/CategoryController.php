<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function CreateCategory(Request $request){
        $validation = Validator::make($request->all(),[
            'category_name' => 'required',
            'status' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ]);
        }

        $category = Category::create([
            'category_name' => $request['category_name'],
            'category_slug' => $request['category_slug'],
            'status' => $request['status'],
            'user_id' => $request->header('id')
        ]);

        if($category){
            return response()->json([
                "status" => "success",
                "message" => "Category created successfully!"
            ],200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }

    }

    public function CategoryList(Request $request){
        $category = Category::orderBy('id','DESC')->get();
        if($category){
            return response()->json([
                "status" => "success",
                "category" => $category
            ], 200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }
    }

    public function CategoryItem(Request $request){
        $categoryItem = Category::where('id', $request['id'])->first();
        if($categoryItem){
            return response()->json([
                "status" => "success",
                "data" => $categoryItem
            ],200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }
    }
    public function CategoryUpdate(Request $request){
        $validation = Validator::make($request->all(),[
            'category_name' => 'required',
            'status' => 'required',
        ]);
        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ]);
        }

        $updateCategory = Category::find($request['id']);
        $updateCategory->category_name = $request['category_name'];
        $updateCategory->status = $request['status'];
        $update = $updateCategory->save();

        if($update){
            return response()->json([
                "status" => "success",
                "message" => "Category updated successfully!"
            ],200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }
    }
    public function CategoryDelete(Request $request){
        try {
            $deleting = Category::where('id', $request['id'])->delete();
            if($deleting){
                return response()->json([
                    "status" => "success",
                    "message" => "Category deleted successfully!"
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }
    }
    public function CategoryStatus(Request $request){
        try {
            $update = Category::find($request['id']);
            $update->status = $request['status'];
            $status = $update->save();
            if($status){
                return response()->json([
                    "status" => "success",
                    "message" => "Category status Changed successfully!"
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
