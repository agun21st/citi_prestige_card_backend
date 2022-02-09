<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Course;
use App\Models\Category;
use App\Models\Department;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getAllTools = "";
        $itemsPerPage = 10;
        if($request->has('itemsPerPage'))
        {
            $itemsPerPage = $request->get('itemsPerPage');
        }

        if($request->has('sortBy') && $request->has('searchBy') && $request->filled('searchBy'))
        {
            if($request->get('sortBy') === 'sub_category')
            {
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', request()->get('searchBy') . '%')->orderBy('subCategory_id','desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', request()->get('searchBy') . '%')->orderBy('subCategory_id','asc')->paginate($itemsPerPage);
                }
            }
            else if($request->get('sortBy') === 'category.name')
            {
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', request()->get('searchBy') . '%')->orderBy('category_id','desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', request()->get('searchBy') . '%')->orderBy('category_id','asc')->paginate($itemsPerPage);
                }
            }
            else if($request->get('sortBy') === 'course.name')
            {
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', request()->get('searchBy') . '%')->orderBy('course_id','desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', request()->get('searchBy') . '%')->orderBy('course_id','asc')->paginate($itemsPerPage);
                }
            }
            else{
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', '%' .  request()->get('searchBy') . '%')->orderBy($request->get('sortBy'),'desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->where('name','LIKE', '%' . request()->get('searchBy') . '%')->orderBy($request->get('sortBy'),'asc')->paginate($itemsPerPage);
                }
            }
        }
        else if($request->has('sortBy') && !$request->has('searchBy') && !$request->filled('searchBy'))
        {
            if($request->get('sortBy') === 'sub_category')
            {
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('subCategory_id','desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('subCategory_id','asc')->paginate($itemsPerPage);
                }
            }
            else if($request->get('sortBy') === 'category.name')
            {
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('category_id','desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('category_id','asc')->paginate($itemsPerPage);
                }
            }
            else if($request->get('sortBy') === 'course.name')
            {
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('course_id','desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('course_id','asc')->paginate($itemsPerPage);
                }
            }
            else{
                if($request->get('sortDesc') === 'true')
                {
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy($request->get('sortBy'),'desc')->paginate($itemsPerPage);
                }else{
                    $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy($request->get('sortBy'),'asc')->paginate($itemsPerPage);
                }
            }
        }else{
            $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->orderBy('id','desc')->paginate($itemsPerPage);
        }

        $getAllCourses = Course::with('categories')->where('department_id',request()->user()->department_id)->get();

        return response()->json(['getAllTools' => $getAllTools,'getAllCourses' => $getAllCourses],200);
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
            'course_id' => ['required'],
            'category_id' => ['required'],
            'subCategory_id' => ['required'],
            'forTheMonth' => ['required'],
            'name' => ['required', 'string'],
            'toolThumbnail' => 'sometimes|file|image|max:5000'
        ]);

        DB::transaction(function () {
            $createTool = Tool::create([
                'department_id' => request()->user()->department_id,
                'course_id' => request()->course_id,
                'category_id' => request()->category_id,
                'subCategory_id' => request()->subCategory_id,
                'name' => request()->name,
                'downloadLink' => request()->downloadLink,
                'forTheMonth' => intval(request()->forTheMonth),
                'descriptions' => request()->descriptions,
                'features' => request()->features,
                'created_by' => request()->user()->id,
            ]);

            if (request()->hasFile('toolThumbnail')) {
                //* set file store folder
                $storeFolder = 'images/tools/' . date('Y-m-d') . '/';
                //* get original file name
                $toolThumb_fileName = request()
                    ->file('toolThumbnail')
                    ->getClientOriginalName();
                $toolThumb_fileExtension = request()
                    ->file('toolThumbnail')
                    ->getClientOriginalExtension();
                //* remove file extension
                $toolThumb_fileName = strtok($toolThumb_fileName, '.');
                //* remove blank spaces
                $toolThumbFinalName = str_replace(' ', '', $toolThumb_fileName);
                $toolThumb_UniqueName = $toolThumbFinalName . '_' . uniqid() . '.' . $toolThumb_fileExtension;
                //? Full path with file name
                $toolThumb_fullPath = url('') . '/' . $storeFolder . $toolThumb_UniqueName;
                $basic_fullPath = $storeFolder . $toolThumb_UniqueName;
                //! Save file to server folder
                request()->file('toolThumbnail')->move($storeFolder, $toolThumb_UniqueName);
                $createTool->update([
                    'toolThumbnail' => $toolThumb_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(360, 270);
                $image->save();
            }
            $sliderImages = '';
            if (request()->hasFile('sliderImages')) {
                $files = request()->file('sliderImages');
                foreach ($files as $file) {
                    //* set file store folder
                    $storeFolder = 'images/tools/' . date('Y-m-d') . '/';
                    //* get original file name
                    $sliderImages_fileName = $file->getClientOriginalName();
                    $sliderImages_fileExtension = $file->getClientOriginalExtension();
                    //* remove file extension
                    $sliderImages_fileName = strtok($sliderImages_fileName, '.');
                    //* remove blank spaces
                    $sliderImagesFinalName = str_replace(' ', '', $sliderImages_fileName);
                    $sliderImages_UniqueName = $sliderImagesFinalName . '_' . uniqid() . '.' . $sliderImages_fileExtension;
                    //? Full path with file name
                    $sliderImages_fullPath = url('') . '/' . $storeFolder . $sliderImages_UniqueName;
                    $basic_fullPath = $storeFolder . $sliderImages_UniqueName;
                    //! Save file to server folder
                    $file->move($storeFolder, $sliderImages_UniqueName);

                    $sliderImages = $sliderImages . ($sliderImages !== '' ? ',' : '') . $sliderImages_fullPath;
                    $image = Image::make($basic_fullPath)->fit(1065, 645);
                    $image->save();
                }
                $createTool->update([
                    'sliderImages' => $sliderImages,
                ]);
            }
        }, 3);
        $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->get();
        return response()->json(['success' => 'Tool Added Successfully','getAllTools'=>$getAllTools], 201);
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

    public function getToolsForStudents(Request $request,$course_id)
    {
        date_default_timezone_set('Asia/Dhaka');
        //or get Date difference as total difference
        $d1 = strtotime(date('Y-m-d', strtotime(request()->user()->admissionDate)));
        $d2 = strtotime(date('Y-m-d'));
        $totalSecondsDiff = abs($d1-$d2); //42600225
        $totalDaysDiff  = $totalSecondsDiff/60/60/24;
        if(request()->fromCategory){
            $getActiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','<=', $totalDaysDiff)->where('category_id', request()->fromCategory)->orderBy('name','asc')->select(['name','toolThumbnail','downloadLink'])->paginate(8);
            $getInactiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','>=', $totalDaysDiff)->where('category_id', request()->fromCategory)->orderBy('name','asc')->select(['name','toolThumbnail','forTheMonth'])->paginate(8);
            // $getCourseCategories = Category::with('subCategories')->where('course_id', $course_id)->get();
            return response()->json(['activeTools'=>$getActiveTools,'inactiveTools'=>$getInactiveTools,'daysOfEnrollment'=>$totalDaysDiff,], 200);
        }
        if(request()->fromSubCategory){
            $getActiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','<=', $totalDaysDiff)->where('subCategory_id', request()->fromSubCategory)->orderBy('name','asc')->select(['name','toolThumbnail','downloadLink'])->paginate(8);
            $getInactiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','>=', $totalDaysDiff)->where('subCategory_id', request()->fromSubCategory)->orderBy('name','asc')->select(['name','toolThumbnail','forTheMonth'])->paginate(8);
            // $getCourseCategories = Category::with('subCategories')->where('course_id', $course_id)->get();
            return response()->json(['activeTools'=>$getActiveTools,'inactiveTools'=>$getInactiveTools,'daysOfEnrollment'=>$totalDaysDiff,], 200);
        }
        if(request()->fromSearchBox){
            // return response()->json(['fromSearch'=>request()->fromSearchBox], 200);
            $getActiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','<=', $totalDaysDiff)->where('name','LIKE', '%' . request()->fromSearchBox . '%')->orderBy('name','asc')->select(['name','toolThumbnail','downloadLink'])->paginate(8);
            $getInactiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','>=', $totalDaysDiff)->where('name','LIKE', '%' . request()->fromSearchBox . '%')->orderBy('name','asc')->select(['name','toolThumbnail','forTheMonth'])->paginate(8);
            // $getCourseCategories = Category::with('subCategories')->where('course_id', $course_id)->get();
            return response()->json(['activeTools'=>$getActiveTools,'inactiveTools'=>$getInactiveTools,'daysOfEnrollment'=>$totalDaysDiff,], 200);
        }
        $getActiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','<=', $totalDaysDiff)->orderBy('id','desc')->select(['name','toolThumbnail','downloadLink'])->paginate(8);
        $getInactiveTools = Tool::where('course_id', $course_id)->where('forTheMonth','>=', $totalDaysDiff)->orderBy('id','desc')->select(['name','toolThumbnail','forTheMonth'])->paginate(8);
        $getCourseCategories = Category::with('subCategories')->where('course_id', $course_id)->get();
        return response()->json(['activeTools'=>$getActiveTools,'inactiveTools'=>$getInactiveTools,'daysOfEnrollment'=>$totalDaysDiff,'getCourseCategories'=>$getCourseCategories], 200);
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

    public function toolsByCourseForFrontend($id)
    {
        $propularTools = Tool::where('course_id', $id)->select('id', 'name','toolThumbnail')->limit(8)->inRandomOrder()->get();
        $latestTools = Tool::where('course_id', $id)->select('id', 'name','toolThumbnail')->limit(8)->latest()->get();
        return response()->json(["propularTools"=>$propularTools,'latestTools'=>$latestTools], 200);
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
            'course_id' => ['required'],
            'category_id' => ['required'],
            'subCategory_id' => ['required'],
            'forTheMonth' => ['required'],
            'name' => ['required', 'string'],
        ]);

        $getTool = Tool::find($id);
        if($getTool){
            $updateTool = $getTool->update([
                'course_id' => request()->course_id,
                'category_id' => request()->category_id,
                'subCategory_id' => request()->subCategory_id,
                'name' => request()->name,
                'downloadLink' => request()->downloadLink,
                'forTheMonth' => intval(request()->forTheMonth),
                'descriptions' => request()->descriptions,
                'features' => request()->features,
                'created_by' => request()->user()->id,
            ]);

            if (request()->hasFile('toolThumbnail')) {
                if ($getTool->toolThumbnail != '' || $getTool->toolThumbnail != null) {
                    $imageLocation = str_replace(url('') . '/', '', $getTool->toolThumbnail);

                    if (File::exists($imageLocation)) {
                        File::delete($imageLocation);
                    }

                    //* set file store folder
                    $storeFolder = 'images/tools/' . date('Y-m-d') . '/';
                    //* get original file name
                    $toolThumb_fileName = request()
                        ->file('toolThumbnail')
                        ->getClientOriginalName();
                    $toolThumb_fileExtension = request()
                        ->file('toolThumbnail')
                        ->getClientOriginalExtension();
                    //* remove file extension
                    $toolThumb_fileName = strtok($toolThumb_fileName, '.');
                    //* remove blank spaces
                    $toolThumbFinalName = str_replace(' ', '', $toolThumb_fileName);
                    $toolThumb_UniqueName = $toolThumbFinalName . '_' . uniqid() . '.' . $toolThumb_fileExtension;
                    //? Full path with file name
                    $toolThumb_fullPath = url('') . '/' . $storeFolder . $toolThumb_UniqueName;
                    $basic_fullPath = $storeFolder . $toolThumb_UniqueName;
                    //! Save file to server folder
                    request()
                        ->file('toolThumbnail')
                        ->move($storeFolder, $toolThumb_UniqueName);
                    $getTool->update([
                        'toolThumbnail' => $toolThumb_fullPath,
                    ]);
                    $image = Image::make($basic_fullPath)->fit(360, 270);
                    $image->save();
                } else {
                    //* set file store folder
                    $storeFolder = 'images/tools/' . date('Y-m-d') . '/';
                    //* get original file name
                    $toolThumb_fileName = request()
                        ->file('toolThumbnail')
                        ->getClientOriginalName();
                    $toolThumb_fileExtension = request()
                        ->file('toolThumbnail')
                        ->getClientOriginalExtension();
                    //* remove file extension
                    $toolThumb_fileName = strtok($toolThumb_fileName, '.');
                    //* remove blank spaces
                    $toolThumbFinalName = str_replace(' ', '', $toolThumb_fileName);
                    $toolThumb_UniqueName = $toolThumbFinalName . '_' . uniqid() . '.' . $toolThumb_fileExtension;
                    //? Full path with file name
                    $toolThumb_fullPath = url('') . '/' . $storeFolder . $toolThumb_UniqueName;
                    $basic_fullPath = $storeFolder . $toolThumb_UniqueName;
                    //! Save file to server folder
                    request()
                    ->file('toolThumbnail')
                    ->move($storeFolder, $toolThumb_UniqueName);
                    $getTool->update([
                        'toolThumbnail' => $toolThumb_fullPath,
                    ]);
                    $image = Image::make($basic_fullPath)->fit(360, 270);
                    $image->save();
                }
            }

            $sliderImages = '';

            if (request()->hasFile('sliderImages')) {
                if ($getTool->sliderImages != '' || $getTool->sliderImages != null) {
                    $getAllImage = explode(',', $getTool->sliderImages);
                    foreach ($getAllImage as $key => $image) {
                        $imageLocation = str_replace(url('') . '/', '', $image);

                        if (File::exists($imageLocation)) {
                            File::delete($imageLocation);
                        }
                    }

                    $files = request()->file('sliderImages');
                    foreach ($files as $file) {
                        //* set file store folder
                        $storeFolder = 'images/tools/' . date('Y-m-d') . '/';
                        //* get original file name
                        $sliderImages_fileName = $file->getClientOriginalName();
                        $sliderImages_fileExtension = $file->getClientOriginalExtension();
                        //* remove file extension
                        $sliderImages_fileName = strtok($sliderImages_fileName, '.');
                        //* remove blank spaces
                        $sliderImagesFinalName = str_replace(' ', '', $sliderImages_fileName);
                        $sliderImages_UniqueName = $sliderImagesFinalName . '_' . uniqid() . '.' . $sliderImages_fileExtension;
                        //? Full path with file name
                        $sliderImages_fullPath = url('') . '/' . $storeFolder . $sliderImages_UniqueName;
                        $basic_fullPath = $storeFolder . $sliderImages_UniqueName;
                        //! Save file to server folder
                        $file->move($storeFolder, $sliderImages_UniqueName);

                        $sliderImages = $sliderImages . ($sliderImages !== '' ? ',' : '') . $sliderImages_fullPath;
                        $image = Image::make($basic_fullPath)->fit(1065, 645);
                        $image->save();
                    }
                    $getTool->update([
                        'sliderImages' => $sliderImages,
                    ]);
                } else {
                    $files = request()->file('sliderImages');
                    foreach ($files as $file) {
                        //* set file store folder
                        $storeFolder = 'images/tools/' . date('Y-m-d') . '/';
                        //* get original file name
                        $sliderImages_fileName = $file->getClientOriginalName();
                        $sliderImages_fileExtension = $file->getClientOriginalExtension();
                        //* remove file extension
                        $sliderImages_fileName = strtok($sliderImages_fileName, '.');
                        //* remove blank spaces
                        $sliderImagesFinalName = str_replace(' ', '', $sliderImages_fileName);
                        $sliderImages_UniqueName = $sliderImagesFinalName . '_' . uniqid() . '.' . $sliderImages_fileExtension;
                        //? Full path with file name
                        $sliderImages_fullPath = url('') . '/' . $storeFolder . $sliderImages_UniqueName;
                        $basic_fullPath = $storeFolder . $sliderImages_UniqueName;
                        //! Save file to server folder
                        $file->move($storeFolder, $sliderImages_UniqueName);

                        $sliderImages = $sliderImages . ($sliderImages !== '' ? ',' : '') . $sliderImages_fullPath;
                        $image = Image::make($basic_fullPath)->fit(1065, 645);
                        $image->save();
                    }
                    $getTool->update([
                        'sliderImages' => $sliderImages,
                    ]);
                }
            }
        }
        $getAllTools = Tool::with('course', 'category', 'subCategory')->where('department_id',request()->user()->department_id)->get();
        return response()->json(['success' => 'Tool Updated Successfully','getAllTools'=>$getAllTools], 201);
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
            $imageLocation = str_replace(url('') . '/', '', $getTool->toolThumbnail);

            if (File::exists($imageLocation)) {
                File::delete($imageLocation);
            }
        }

        if ($getTool->sliderImages != '' || $getTool->sliderImages != null) {
            $getAllImage = explode(',', $getTool->sliderImages);
            foreach ($getAllImage as $key => $image) {
                $imageLocation = str_replace(url('') . '/', '', $image);

                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }
            }
        }
        $getTool->delete();

        return response()->json(['success' => 'Tool Deleted Successfully'], 201);
    }

    //? frontend api data
    public function getLatestToolsForFrontend()
    {
        $latestTools = Tool::select('id', 'name', 'toolThumbnail')
            ->limit(4)
            ->latest()
            ->get();

        return response()->json(['latestTools' => $latestTools], 200);
    }
    public function getPopularToolsForFrontend()
    {
        $popularTools = Tool::select('id', 'name', 'toolThumbnail')
            ->limit(4)
            ->inRandomOrder()
            ->get();

        return response()->json(['latestTools' => $popularTools], 200);
    }
}
