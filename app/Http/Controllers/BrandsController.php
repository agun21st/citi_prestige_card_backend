<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::with('category')->get();
        return response()->json(['categories' => $categories, 'brands' => $brands], 200);
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
        $validated = Validator::make($request->all(),[
            // "name"  => 'required|max:255|unique:brands',
            "category_id" => 'required|exists:categories,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        $brand = Brand::create([
            'name' => request()->name,
            'category_id' => request()->category_id,
            'created_by' => request()->user()->id
        ]);
        $brands = Brand::with('category')->get();
        return response()->json(["success" => "Brand Added Successfully",'brands'=>$brands], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brands = Brand::where('category_id',$id)->get();
        return response()->json(['brands'=>$brands], 200);
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
        $validated = Validator::make($request->all(),[
            // "name"  => 'required|max:255|unique:brands,name,'.$id,
            "category_id" => 'required|exists:categories,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        $checkBrand = Brand::find($id);
        if($checkBrand){
            $updateBrand = $checkBrand->update([
                'name' => request()->name,
                'category_id' => request()->category_id,
            ]);
        }
        $brands = Brand::with('category')->get();
        return response()->json(["success" => "Brand Updated Successfully",'brands'=>$brands], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if($brand)
        {
            $brand->delete();
        }
        return response()->json(["success" => "Brand Deleted Successfully"], 201);
    }
}
