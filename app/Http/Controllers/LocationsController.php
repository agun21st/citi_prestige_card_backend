<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $locations = Location::with(['category','brand'])->get();
        return response()->json(['categories' => $categories,'locations' => $locations], 200);
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
            // "name"  => 'required|max:255|unique:locations',
            "category_id" => 'required|exists:categories,id',
            "brand_id" => 'required|exists:brands,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        $location = Location::create([
            'name' => request()->name,
            'category_id' => request()->category_id,
            'brand_id' => request()->brand_id,
            'created_by' => request()->user()->id
        ]);
        $locations = Location::with(['category','brand'])->get();
        return response()->json(["success" => "Location Added Successfully",'locations'=>$locations], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            // "name"  => 'required|max:255|unique:locations,name,'.$id,
            "category_id" => 'required|exists:categories,id',
            "brand_id" => 'required|exists:brands,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        $checkLocation = Location::find($id);
        if($checkLocation){
            $updateLocation = $checkLocation->update([
                'name' => request()->name,
                'category_id' => request()->category_id,
                'brand_id' => request()->brand_id,
            ]);
        }
        $locations = Location::with(['category','brand'])->get();
        return response()->json(["success" => "Location Added Successfully",'locations'=>$locations], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getLocation = Location::find($id);
        if($getLocation)
        {
            $getLocation->delete();
        }
        return response()->json(["success" => "Location Deleted Successfully"], 201);
    }
}
