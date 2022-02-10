<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $offers = Offer::with(['category','brand','location'])->get();
        return response()->json(['categories' => $categories,'offers' => $offers], 200);
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
            "title"  => 'required|max:255|unique:offers',
            "discount"  => 'required',
            "category_id" => 'required|exists:categories,id',
            "brand_id" => 'required|exists:brands,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        DB::transaction(function () {
            $createOffer = Offer::create([
                'category_id' => request()->category_id,
                'brand_id' => request()->brand_id,
                'location_id' => request()->location_id?request()->location_id:0,
                'title' => request()->title,
                'discount' => request()->discount,
                'description' => request()->description,
                'created_by' => request()->user()->id
            ]);
            if (request()->hasFile('logo')) {
                //* set file store folder
                $storeFolder = "images/offers/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('logo')->getClientOriginalName();
                $image_fileExtension = request()->file('logo')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . time() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('logo')->move($storeFolder, $image_UniqueName);
                $createOffer->update([
                    'logo' => $image_fullPath,
                ]);
                // $image = Image::make($basic_fullPath)->fit(300, 300);
                // $image->save();
            }
        },3);
        $offers = Offer::with(['category','brand','location'])->get();
        return response()->json(["success" => "Offer Added Successfully",'offers' => $offers], 201);
        // return response()->json(['offers' => request()->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locations = Location::where('brand_id',$id)->get();
        return response()->json(['locations'=>$locations], 200);
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
            "title"  => 'required|max:255|unique:offers,title,'.$id,
            "discount"  => 'required',
            "category_id" => 'required|exists:categories,id',
            "brand_id" => 'required|exists:brands,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        $checkOffer = Offer::find($id);
        if($checkOffer){
            $updateOffer = $checkOffer->update([
                'category_id' => request()->category_id,
                'brand_id' => request()->brand_id,
                'location_id' => request()->location_id?request()->location_id:0,
                'title' => request()->title,
                'discount' => request()->discount,
                'description' => request()->description,
            ]);
        }
        if (request()->hasFile('logo')) {
            if ($checkOffer->logo != '' || $checkOffer->logo != null) {
                $imageLocation = str_replace(url('') . "/", "", $checkOffer->logo);
                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }
                //* set file store folder
                $storeFolder = "images/offers/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('logo')->getClientOriginalName();
                $image_fileExtension = request()->file('logo')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . time() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('logo')->move($storeFolder, $image_UniqueName);
                $checkOffer->update([
                    'logo' => $image_fullPath,
                ]);
                // $image = Image::make($basic_fullPath)->fit(300, 300);
                // $image->save();
            } else {
                //* set file store folder
                $storeFolder = "images/offers/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('logo')->getClientOriginalName();
                $image_fileExtension = request()->file('logo')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . time() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('logo')->move($storeFolder, $image_UniqueName);
                $checkOffer->update([
                    'logo' => $image_fullPath,
                ]);
                // $image = Image::make($basic_fullPath)->fit(300, 300);
                // $image->save();
            }
        }
        $offers = Offer::with(['category','brand','location'])->get();
        return response()->json(["success" => "Offer Updated Successfully",'offers' => $offers], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
