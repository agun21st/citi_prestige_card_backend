<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['departments' => Department::all()], 200);
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
            'name' => ['required', 'string', 'unique:departments,name'],
            'deptThumbnail' => ['required'],
            'heroBackground' => ['required'],
            'heroOne' => ['required', 'string'],
            'heroTwo' => ['required', 'string'],
            'heroDescription' => ['required', 'string'],
            'heroVideo' => ['required', 'string'],
            'descriptionHeader' => ['required', 'string'],
            'descriptions' => ['required', 'string'],
        ]);

        DB::transaction(function () {
            $department = Department::create(request()->except('deptThumbnail', 'heroBackground'));

            if (request()->hasFile('deptThumbnail') && request()->hasFile('heroBackground')) {
                //* set file store folder
                $storeFolder = 'images/department/' . date('Y-m-d') . '/';
                //* get original file name
                $deptThumb_fileName = request()
                    ->file('deptThumbnail')
                    ->getClientOriginalName();
                $deptThumb_fileExtension = request()
                    ->file('deptThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $deptThumb_fileName = strtok($deptThumb_fileName, '.');
                $heroBackground_fileName = request()
                    ->file('heroBackground')
                    ->getClientOriginalName();
                $heroBackground_fileExtension = request()
                    ->file('heroBackground')
                    ->getClientOriginalExtension();
                //* remove file extension
                $heroBackground_fileName = strtok($heroBackground_fileName, '.');
                //* remove blank spaces
                $deptThumbFinalName = str_replace(' ', '', $deptThumb_fileName);
                $heroBackgroundFinalName = str_replace(' ', '', $heroBackground_fileName);
                $deptThumb_UniqueName = $deptThumbFinalName . '_' . uniqid() . '.' . $deptThumb_fileExtension;
                $heroBackground_UniqueName = $heroBackgroundFinalName . '_' . uniqid() . '.' . $heroBackground_fileExtension;
                //? Full path with file name
                $deptThumb_fullPath = url('') . '/' . $storeFolder . $deptThumb_UniqueName;
                $heroBackground_fullPath = url('') . '/' . $storeFolder . $heroBackground_UniqueName;
                $basic_fullPath_thumb = $storeFolder . $deptThumb_UniqueName;
                $basic_fullPath = $storeFolder . $heroBackground_UniqueName;
                //! Save file to server folder
                request()
                    ->file('deptThumbnail')
                    ->move($storeFolder, $deptThumb_UniqueName);
                request()
                    ->file('heroBackground')
                    ->move($storeFolder, $heroBackground_UniqueName);
                $department->update([
                    'deptThumbnail' => $deptThumb_fullPath,
                    'heroBackground' => $heroBackground_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(960, 640);
                $image->save();
                $image = Image::make($basic_fullPath_thumb)->fit(360, 270);
                $image->save();
            }
        }, 3);

        return response()->json(['success' => 'Department Added Successfully', 'request' => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['user_department' => Department::where('id',$id)->select('id','name','deptThumbnail')->first()], 200);
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
            'name' => ['required', 'string', 'unique:departments,name,' . $id],
            'heroOne' => ['required', 'string'],
            'heroTwo' => ['required', 'string'],
            'heroDescription' => ['required', 'string'],
            'heroVideo' => ['required', 'string'],
            'descriptionHeader' => ['required', 'string'],
            'descriptions' => ['required', 'string'],
        ]);

        $checkDepartment = Department::find($id);
        $updateDepartment = $checkDepartment->update(request()->except('deptThumbnail', 'heroBackground'));
        if (request()->hasFile('deptThumbnail')) {
            if ($checkDepartment->deptThumbnail != '' || $checkDepartment->deptThumbnail != null) {
                $imageLocation = str_replace(url('') . '/', '', $checkDepartment->deptThumbnail);

                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }

                //* set file store folder
                $storeFolder = 'images/department/' . date('Y-m-d') . '/';
                //* get original file name
                $deptThumb_fileName = request()
                    ->file('deptThumbnail')
                    ->getClientOriginalName();
                $deptThumb_fileExtension = request()
                    ->file('deptThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $deptThumb_fileName = strtok($deptThumb_fileName, '.');
                //* remove blank spaces
                $deptThumbFinalName = str_replace(' ', '', $deptThumb_fileName);
                $deptThumb_UniqueName = $deptThumbFinalName . '_' . uniqid() . '.' . $deptThumb_fileExtension;
                //? Full path with file name
                $deptThumb_fullPath = url('') . '/' . $storeFolder . $deptThumb_UniqueName;
                $basic_fullPath = $storeFolder . $deptThumb_UniqueName;
                //! Save file to server folder
                request()
                    ->file('deptThumbnail')
                    ->move($storeFolder, $deptThumb_UniqueName);
                $checkDepartment->update([
                    'deptThumbnail' => $deptThumb_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(360, 270);
                $image->save();
            } else {
                //* set file store folder
                $storeFolder = 'images/department/' . date('Y-m-d') . '/';
                //* get original file name
                $deptThumb_fileName = request()
                    ->file('deptThumbnail')
                    ->getClientOriginalName();
                $deptThumb_fileExtension = request()
                    ->file('deptThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $deptThumb_fileName = strtok($deptThumb_fileName, '.');
                //* remove blank spaces
                $deptThumbFinalName = str_replace(' ', '', $deptThumb_fileName);
                $deptThumb_UniqueName = $deptThumbFinalName . '_' . uniqid() . '.' . $deptThumb_fileExtension;
                //? Full path with file name
                $deptThumb_fullPath = url('') . '/' . $storeFolder . $deptThumb_UniqueName;
                $basic_fullPath = $storeFolder . $deptThumb_UniqueName;
                //! Save file to server folder
                request()
                    ->file('deptThumbnail')
                    ->move($storeFolder, $deptThumb_UniqueName);
                $checkDepartment->update([
                    'deptThumbnail' => $deptThumb_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(360, 270);
                $image->save();
            }
        }
        if (request()->hasFile('heroBackground')) {
            if ($checkDepartment->heroBackground != '' || $checkDepartment->heroBackground != null) {
                $imageLocation = str_replace(url('') . '/', '', $checkDepartment->heroBackground);

                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }

                //* set file store folder
                $storeFolder = 'images/department/' . date('Y-m-d') . '/';
                //* get original file name
                $heroBackground_fileName = request()
                    ->file('heroBackground')
                    ->getClientOriginalName();
                $heroBackground_fileExtension = request()
                    ->file('heroBackground')
                    ->getClientOriginalExtension();
                //* remove file extension
                $heroBackground_fileName = strtok($heroBackground_fileName, '.');
                //* remove blank spaces
                $heroBackgroundFinalName = str_replace(' ', '', $heroBackground_fileName);
                $heroBackground_UniqueName = $heroBackgroundFinalName . '_' . uniqid() . '.' . $heroBackground_fileExtension;
                //? Full path with file name
                $heroBackground_fullPath = url('') . '/' . $storeFolder . $heroBackground_UniqueName;
                $basic_fullPath = $storeFolder . $heroBackground_UniqueName;
                //! Save file to server folder
                request()
                    ->file('heroBackground')
                    ->move($storeFolder, $heroBackground_UniqueName);
                $checkDepartment->update([
                    'heroBackground' => $heroBackground_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(960, 640);
                $image->save();
            } else {
                //* set file store folder
                $storeFolder = 'images/department/' . date('Y-m-d') . '/';
                //* get original file name
                $heroBackground_fileName = request()
                    ->file('heroBackground')
                    ->getClientOriginalName();
                $heroBackground_fileExtension = request()
                    ->file('heroBackground')
                    ->getClientOriginalExtension();
                //* remove file extension
                $heroBackground_fileName = strtok($heroBackground_fileName, '.');
                //* remove blank spaces
                $heroBackgroundFinalName = str_replace(' ', '', $heroBackground_fileName);
                $heroBackground_UniqueName = $heroBackgroundFinalName . '_' . uniqid() . '.' . $heroBackground_fileExtension;
                //? Full path with file name
                $heroBackground_fullPath = url('') . '/' . $storeFolder . $heroBackground_UniqueName;
                $basic_fullPath = $storeFolder . $heroBackground_UniqueName;
                //! Save file to server folder
                request()
                    ->file('heroBackground')
                    ->move($storeFolder, $heroBackground_UniqueName);
                $checkDepartment->update([
                    'heroBackground' => $heroBackground_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(960, 640);
                $image->save();
            }
        }

        // return response()->json(["success" => "Department Update Successfully"], 201);
        return response()->json(['success' => 'Department Update Successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getDepartment = Department::find($id);

        if ($getDepartment->deptThumbnail != '' || $getDepartment->deptThumbnail != null) {
            $imageLocation = str_replace(url('') . '/', '', $getDepartment->deptThumbnail);

            if (File::exists($imageLocation)) {
                File::delete($imageLocation);
            }
        }
        if ($getDepartment->heroBackground != '' || $getDepartment->heroBackground != null) {
            $imageLocation = str_replace(url('') . '/', '', $getDepartment->heroBackground);

            if (File::exists($imageLocation)) {
                File::delete($imageLocation);
            }
        }
        $getDepartment->delete();

        return response()->json(['success' => 'Department Deleted Successfully'], 201);
    }

    //? frontend api data
    public function getDepartmentsForFrontend()
    {
        $departments = Department::select('id', 'name', 'deptThumbnail')->get();
        // $myArray = array();
        // $myArray[0] = $departments[1];
        // $myArray[1] = $departments[3];
        // $myArray[2] = $departments[2];
        // $myArray[3] = $departments[4];
        // $myArray[4] = $departments[5];
        // $myArray[5] = $departments[0];
        // $myArray[6] = $departments[6];
        // $myArray[7] = $departments[7];
        // $myArray[8] = $departments[8];

        return response()->json(['departments' => $departments], 200);
    }
    public function getAlldepartmentsTools()
    {
        $departments = Department::select('id', 'name', 'deptThumbnail')->get();
        $myArray = array();
        $myArray[0] = $departments[1];
        $myArray[1] = $departments[3];
        $myArray[2] = $departments[2];
        $myArray[3] = $departments[4];
        $myArray[4] = $departments[5];
        $myArray[5] = $departments[0];
        $myArray[6] = $departments[6];
        $myArray[7] = $departments[7];
        $myArray[8] = $departments[8];
        $latestTools = Tool::select('id', 'name', 'toolThumbnail')
            ->limit(4)
            ->latest()
            ->get();
        $popularTools = Tool::select('id', 'name', 'toolThumbnail')
            ->limit(4)
            ->inRandomOrder()
            ->get();
        $totalTools = Tool::count();

        return response()->json(['departments' => $myArray, 'latestTools' => $latestTools, 'popularTools' => $popularTools, 'totalTools' => $totalTools], 200);
    }

    public function getDepartmentByIdForFrontend($id)
    {
        $department = Department::with("courses")
            ->where('id', $id)->select(
                'departments.id',
                'departments.name',
                // 'departments.deptThumbnail',
                'departments.heroBackground',
                'departments.heroOne',
                'departments.heroTwo',
                'departments.heroDescription',
                'departments.heroVideo',
                'departments.descriptionHeader',
                'departments.descriptions',
            )->first();

        return response()->json(['department' => $department], 200);
    }
}
