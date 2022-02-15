<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validated = Validator::make($request->all(),[
        //     "name"  => 'required|max:255|unique:categories',
        // ],);
        // if ($validated->fails())
        // {return $validated->errors();}

        $createCategory = Category::create([
            'name' => request()->name,
            'created_by' => request()->user()->id
        ]);
        $getAllCategories= Category::all();
        return response()->json(["success" => "Category Added Successfully",'getAllCategories'=>$getAllCategories], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getAllCategories = Category::where(['course_id'=>$id,'department_id'=>request()->user()->department_id])->get();
        return response()->json(["categories" => $getAllCategories], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validated = Validator::make($request->all(),[
        //     "name"  => 'required|max:255|unique:categories,name,'.$id,
        // ],);
        // if ($validated->fails())
        // {return $validated->errors();}

        $checkCategory = Category::find($id);
        $updateCategory = $checkCategory->update([
            'name' => request()->name,
        ]);
        $getAllCategories= Category::all();
        return response()->json(["success" => "Category Updated Successfully",'getAllCategories'=>$getAllCategories], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getCategory = Category::find($id);
        if($getCategory)
        {
            $getCategory->delete();
        }
        return response()->json(["success" => "Category Deleted Successfully"], 201);
    }
}
