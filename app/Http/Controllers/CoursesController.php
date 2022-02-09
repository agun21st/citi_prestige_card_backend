<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('department')->where(['department_id' => request()->user()->department_id])->get();

        return response()->json(['courses' => $courses], 200);
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
        // return response()->json(["success" => $request->all()], 201);
        request()->validate([
            "name" => ['required', 'string','unique:courses,name'],
            "department_id" => ['required'],
        ]);

        DB::transaction(function () {

            $createcourse = Course::create([
                'name' => request()->name,
                'department_id' => request()->department_id,
                'created_by' => request()->created_by
            ]);
            if (request()->hasFile('courseThumbnail')) {
                //* set file store folder
                $storeFolder = 'images/courses/' . date('Y-m-d') . '/';
                //* get original file name
                $courseThumb_fileName = request()
                    ->file('courseThumbnail')
                    ->getClientOriginalName();
                $courseThumb_fileExtension = request()
                    ->file('courseThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $courseThumb_fileName = strtok($courseThumb_fileName, '.');
                //* remove blank spaces
                $courseThumbFinalName = str_replace(' ', '', $courseThumb_fileName);
                $courseThumb_UniqueName = $courseThumbFinalName . '_' . uniqid() . '.' . $courseThumb_fileExtension;
                //? Full path with file name
                $courseThumb_fullPath = url('') . '/' . $storeFolder . $courseThumb_UniqueName;
                //! Save file to server folder
                request()
                    ->file('courseThumbnail')
                    ->move($storeFolder, $courseThumb_UniqueName);
                $createcourse->update([
                    'courseThumbnail' => $courseThumb_fullPath,
                ]);
                $basic_fullPath = $storeFolder . $courseThumb_UniqueName;
                $image = Image::make($basic_fullPath)->fit(626, 417);
                $image->save();
            }
        }, 3);
        $getAllCourses = Course::where('department_id',$request->user()->department_id)->get();

        return response()->json(["success" => "Course Added Successfully", 'getAllCourses'=>$getAllCourses], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courses = Course::where('department_id', $id)->select('id', 'name')->get();
        return response()->json(["courses"=>$courses], 200);
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
            "department_id" => ['required'],
        ]);

        $checkCourse = Course::find($id);
        $updateCourse = $checkCourse->update([
            'name' => request()->name,
            'department_id' => request()->department_id,
        ]);
        if (request()->hasFile('courseThumbnail')) {
            if($checkCourse->courseThumbnail != '' || $checkCourse->courseThumbnail != null){
                $imageLocation = str_replace(url('') . '/', '', $checkCourse->courseThumbnail);
                // return response()->json(["success" => $imageLocation,'ok'=>request()->hasFile('courseThumbnail')], 201);
                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }
                //* set file store folder
                $storeFolder = 'images/courses/' . date('Y-m-d') . '/';
                //* get original file name
                $courseThumb_fileName = request()
                    ->file('courseThumbnail')
                    ->getClientOriginalName();
                $courseThumb_fileExtension = request()
                    ->file('courseThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $courseThumb_fileName = strtok($courseThumb_fileName, '.');
                //* remove blank spaces
                $courseThumbFinalName = str_replace(' ', '', $courseThumb_fileName);
                $courseThumb_UniqueName = $courseThumbFinalName . '_' . uniqid() . '.' . $courseThumb_fileExtension;
                //? Full path with file name
                $courseThumb_fullPath = url('') . '/' . $storeFolder . $courseThumb_UniqueName;
                //! Save file to server folder
                request()
                    ->file('courseThumbnail')
                    ->move($storeFolder, $courseThumb_UniqueName);
                $checkCourse->update([
                    'courseThumbnail' => $courseThumb_fullPath,
                ]);
                $basic_fullPath = $storeFolder . $courseThumb_UniqueName;
                $image = Image::make($basic_fullPath)->fit(626, 417);
                $image->save();
            }else{
                //* set file store folder
                $storeFolder = 'images/courses/' . date('Y-m-d') . '/';
                //* get original file name
                $courseThumb_fileName = request()
                    ->file('courseThumbnail')
                    ->getClientOriginalName();
                $courseThumb_fileExtension = request()
                    ->file('courseThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $courseThumb_fileName = strtok($courseThumb_fileName, '.');
                //* remove blank spaces
                $courseThumbFinalName = str_replace(' ', '', $courseThumb_fileName);
                $courseThumb_UniqueName = $courseThumbFinalName . '_' . uniqid() . '.' . $courseThumb_fileExtension;
                //? Full path with file name
                $courseThumb_fullPath = url('') . '/' . $storeFolder . $courseThumb_UniqueName;
                //! Save file to server folder
                request()
                    ->file('courseThumbnail')
                    ->move($storeFolder, $courseThumb_UniqueName);
                $checkCourse->update([
                    'courseThumbnail' => $courseThumb_fullPath,
                ]);
                $basic_fullPath = $storeFolder . $courseThumb_UniqueName;
                $image = Image::make($basic_fullPath)->fit(626, 417);
                $image->save();
            }
        }
        $getAllCourses = Course::where('department_id',request()->department_id)->get();
        return response()->json(["success" => "Course Update Successfully",'getAllCourses'=>$getAllCourses], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getCourse = Course::find($id);
        if($getCourse){
            $getCourse->delete();
        }
        return response()->json(["success" => "Course Deleted Successfully"], 201);

    }
}
