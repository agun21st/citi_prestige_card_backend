<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use App\Models\Department;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->searchBy) {
            $allTools = Tool::with('department', 'category', 'subCategory')
                ->where('tools.name', 'LIKE', request()->searchBy . '%')
                ->orWhere('tools.id', 'LIKE', request()->searchBy . '%')
                // ->orWhere('department_id', 'LIKE', request()->searchBy . '%')
                // ->orWhere('category.name', 'LIKE', request()->searchBy . '%')
                // ->orWhere('subCategory.name', 'LIKE', request()->searchBy . '%')
                ->paginate(10);

            return response()->json(['departments' => Department::select('id', 'name')->get(), 'allTools' => $allTools], 200);
        } else {

            return response()->json(['departments' => Department::select('id', 'name')->get(), 'allTools' => Tool::with('department', 'category', 'subCategory')->paginate(10)], 200);
        }
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
            "department_id" => ['required'],
            "category_id" => ['required'],
            "subCategory_id" => ['required'],
            "name" => ['required', 'string'],
            "descriptions" => ['required', 'string'],
            "features" => ['required', 'string'],
        ]);

        DB::transaction(function () {

            $createTool = Tool::create([
                'department_id' => request()->department_id,
                'category_id' => request()->category_id,
                'subCategory_id' => request()->subCategory_id,
                'name' => request()->name,
                'downloadLink' => request()->downloadLink,
                'descriptions' => request()->descriptions,
                'features' => request()->features,
                'created_by' => request()->created_by
            ]);

            if (request()->hasFile('toolThumbnail')) {
                //* set file store folder
                $storeFolder = "images/tools/" . date("Y-m-d") . "/";
                //* get original file name
                $toolThumb_fileName = request()->file('toolThumbnail')->getClientOriginalName();
                $toolThumb_fileExtension = request()->file('toolThumbnail')->getClientOriginalExtension();
                //* remove file extension
                $toolThumb_fileName = strtok($toolThumb_fileName, ".");
                //* remove blank spaces
                $toolThumbFinalName = str_replace(' ', '', $toolThumb_fileName);
                $toolThumb_UniqueName = $toolThumbFinalName . "_" . uniqid() . "." . $toolThumb_fileExtension;
                //? Full path with file name
                $toolThumb_fullPath = url('') . "/" . $storeFolder . $toolThumb_UniqueName;
                //! Save file to server folder
                request()->file('toolThumbnail')->move($storeFolder, $toolThumb_UniqueName);
                $createTool->update([
                    'toolThumbnail' => $toolThumb_fullPath,
                ]);
            }
            $sliderImages = "";
            if (request()->hasFile('sliderImages')) {
                $files = request()->file('sliderImages');
                foreach ($files as $file) {
                    //* set file store folder
                    $storeFolder = "images/tools/" . date("Y-m-d") . "/";
                    //* get original file name
                    $sliderImages_fileName = $file->getClientOriginalName();
                    $sliderImages_fileExtension = $file->getClientOriginalExtension();
                    //* remove file extension
                    $sliderImages_fileName = strtok($sliderImages_fileName, ".");
                    //* remove blank spaces
                    $sliderImagesFinalName = str_replace(' ', '', $sliderImages_fileName);
                    $sliderImages_UniqueName = $sliderImagesFinalName . "_" . uniqid() . "." . $sliderImages_fileExtension;
                    //? Full path with file name
                    $sliderImages_fullPath = url('') . "/" . $storeFolder . $sliderImages_UniqueName;
                    //! Save file to server folder
                    $file->move($storeFolder, $sliderImages_UniqueName);

                    $sliderImages = $sliderImages . ($sliderImages !== "" ? "," : "") . $sliderImages_fullPath;
                }
                $createTool->update([
                    'sliderImages' => $sliderImages,
                ]);
            }
        }, 3);

        return response()->json(["success" => "Tool Added Successfully"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['categories' => Category::where('department_id', $id)->get()], 200);
    }

    public function getSubCategories($id)
    {
        return response()->json(['subCategories' => SubCategory::where('category_id', $id)->get()], 200);
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
            "department_id" => ['required'],
            "category_id" => ['required'],
            "subCategory_id" => ['required'],
            "name" => ['required', 'string'],
            "descriptions" => ['required', 'string'],
            "features" => ['required', 'string'],
        ]);

        $getTool = Tool::find($id);

        $updateTool = $getTool->update([
            'department_id' => request()->department_id,
            'category_id' => request()->category_id,
            'subCategory_id' => request()->subCategory_id,
            'name' => request()->name,
            'downloadLink' => request()->downloadLink,
            'descriptions' => request()->descriptions,
            'features' => request()->features
        ]);

        if (request()->hasFile('toolThumbnail')) {

            if ($getTool->toolThumbnail != '' || $getTool->toolThumbnail != null) {

                $imageLocation = str_replace(url('') . "/", "", $getTool->toolThumbnail);

                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }

                //* set file store folder
                $storeFolder = "images/tools/" . date("Y-m-d") . "/";
                //* get original file name
                $toolThumb_fileName = request()->file('toolThumbnail')->getClientOriginalName();
                $toolThumb_fileExtension = request()->file('toolThumbnail')->getClientOriginalExtension();
                //* remove file extension
                $toolThumb_fileName = strtok($toolThumb_fileName, ".");
                //* remove blank spaces
                $toolThumbFinalName = str_replace(' ', '', $toolThumb_fileName);
                $toolThumb_UniqueName = $toolThumbFinalName . "_" . uniqid() . "." . $toolThumb_fileExtension;
                //? Full path with file name
                $toolThumb_fullPath = url('') . "/" . $storeFolder . $toolThumb_UniqueName;
                //! Save file to server folder
                request()->file('toolThumbnail')->move($storeFolder, $toolThumb_UniqueName);
                $getTool->update([
                    'toolThumbnail' => $toolThumb_fullPath,
                ]);
            } else {
                //* set file store folder
                $storeFolder = "images/tools/" . date("Y-m-d") . "/";
                //* get original file name
                $toolThumb_fileName = request()->file('toolThumbnail')->getClientOriginalName();
                $toolThumb_fileExtension = request()->file('toolThumbnail')->getClientOriginalExtension();
                //* remove file extension
                $toolThumb_fileName = strtok($toolThumb_fileName, ".");
                //* remove blank spaces
                $toolThumbFinalName = str_replace(' ', '', $toolThumb_fileName);
                $toolThumb_UniqueName = $toolThumbFinalName . "_" . uniqid() . "." . $toolThumb_fileExtension;
                //? Full path with file name
                $toolThumb_fullPath = url('') . "/" . $storeFolder . $toolThumb_UniqueName;
                //! Save file to server folder
                request()->file('toolThumbnail')->move($storeFolder, $toolThumb_UniqueName);
                $getTool->update([
                    'toolThumbnail' => $toolThumb_fullPath,
                ]);
            }
        }

        $sliderImages = "";

        if (request()->hasFile('sliderImages')) {

            if ($getTool->sliderImages != '' || $getTool->sliderImages != null) {
                $getAllImage = explode(",", $getTool->sliderImages);
                foreach ($getAllImage as $key => $image) {
                    $imageLocation = str_replace(url('') . "/", "", $image);

                    if (File::exists($imageLocation)) {
                        File::delete($imageLocation);
                    }
                }

                $files = request()->file('sliderImages');
                foreach ($files as $file) {
                    //* set file store folder
                    $storeFolder = "images/tools/" . date("Y-m-d") . "/";
                    //* get original file name
                    $sliderImages_fileName = $file->getClientOriginalName();
                    $sliderImages_fileExtension = $file->getClientOriginalExtension();
                    //* remove file extension
                    $sliderImages_fileName = strtok($sliderImages_fileName, ".");
                    //* remove blank spaces
                    $sliderImagesFinalName = str_replace(' ', '', $sliderImages_fileName);
                    $sliderImages_UniqueName = $sliderImagesFinalName . "_" . uniqid() . "." . $sliderImages_fileExtension;
                    //? Full path with file name
                    $sliderImages_fullPath = url('') . "/" . $storeFolder . $sliderImages_UniqueName;
                    //! Save file to server folder
                    $file->move($storeFolder, $sliderImages_UniqueName);

                    $sliderImages = $sliderImages . ($sliderImages !== "" ? "," : "") . $sliderImages_fullPath;
                }
                $getTool->update([
                    'sliderImages' => $sliderImages,
                ]);
            } else {
                $files = request()->file('sliderImages');
                foreach ($files as $file) {
                    //* set file store folder
                    $storeFolder = "images/tools/" . date("Y-m-d") . "/";
                    //* get original file name
                    $sliderImages_fileName = $file->getClientOriginalName();
                    $sliderImages_fileExtension = $file->getClientOriginalExtension();
                    //* remove file extension
                    $sliderImages_fileName = strtok($sliderImages_fileName, ".");
                    //* remove blank spaces
                    $sliderImagesFinalName = str_replace(' ', '', $sliderImages_fileName);
                    $sliderImages_UniqueName = $sliderImagesFinalName . "_" . uniqid() . "." . $sliderImages_fileExtension;
                    //? Full path with file name
                    $sliderImages_fullPath = url('') . "/" . $storeFolder . $sliderImages_UniqueName;
                    //! Save file to server folder
                    $file->move($storeFolder, $sliderImages_UniqueName);

                    $sliderImages = $sliderImages . ($sliderImages !== "" ? "," : "") . $sliderImages_fullPath;
                }
                $getTool->update([
                    'sliderImages' => $sliderImages,
                ]);
            }
        }

        return response()->json(["success" => "Tool Updated Successfully"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getTool = Tool::find($id);


        if ($getTool->toolThumbnail != '' || $getTool->toolThumbnail != null) {

            $imageLocation = str_replace(url('') . "/", "", $getTool->toolThumbnail);

            if (File::exists($imageLocation)) {
                File::delete($imageLocation);
            }
        }

        if ($getTool->sliderImages != '' || $getTool->sliderImages != null) {
            $getAllImage = explode(",", $getTool->sliderImages);
            foreach ($getAllImage as $key => $image) {
                $imageLocation = str_replace(url('') . "/", "", $image);

                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }
            }
        }
        $getTool->delete();

        return response()->json(["success" => "Tool Deleted Successfully"], 201);
    }
}
