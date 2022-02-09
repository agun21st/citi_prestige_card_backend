<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Department;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['courses' => Course::where('department_id', request()->user()->department_id)->get(),'categories' => Category::where('department_id', request()->user()->department_id)->get(), 'subCategories' => SubCategory::with(['courses', 'categories'])->where('department_id', request()->user()->department_id)->get()], 200);
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
        request()->validate([
            "name" => ['required', 'string'],
            "course_id" => ['required'],
            "category_id" => ['required'],
        ]);

        DB::transaction(function () {

            SubCategory::create([
                'name' => request()->name,
                'department_id' => request()->user()->department_id,
                'course_id' => request()->course_id,
                'category_id' => request()->category_id,
                'created_by' => request()->user()->id
            ]);
        }, 3);
        return response()->json(["success" => "Sub-Category Added Successfully",'subCategories' => SubCategory::with(['courses', 'categories'])->where('department_id', request()->user()->department_id)->get()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['subCategories' => SubCategory::where(['category_id'=>$id, 'department_id'=>request()->user()->department_id])->get()], 200);
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
        request()->validate([
            "name" => ['required', 'string'],
            "course_id" => ['required'],
            "category_id" => ['required'],
        ]);

        $checkSubCategory = SubCategory::find($id);
        if($checkSubCategory){
            $checkSubCategory->update([
                'name' => request()->name,
                'course_id' => request()->course_id,
                'category_id' => request()->category_id,
                'created_by' => request()->user()->id
            ]);
        }
        return response()->json(["success" => "Sub-Category Updated Successfully",'subCategories' => SubCategory::with(['courses', 'categories'])->where('department_id', request()->user()->department_id)->get()], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getSubCategory = SubCategory::find($id);
        $getSubCategory->delete();

        return response()->json(["success" => "Sub-Category Deleted Successfully"], 201);
    }
}
