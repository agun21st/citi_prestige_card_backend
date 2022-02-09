<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\User;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->getByDepartment) {
            // $getDepartment = DB::table('')
            $finalText = str_replace('and', '&', $request->getByDepartment);
            $getToolsbyDepartment = '';
            $getDepartment = Department::with('categories')
                ->where('name', $finalText)
                ->first();
            if ($getDepartment) {
                $getToolsbyDepartment = Tool::where('department_id', $getDepartment->id)->paginate(8);
            }

            return response()->json(['getToolsbyDepartment' => $getToolsbyDepartment, 'getDepartment' => $getDepartment], 200);
        }
        if ($request->getByCategory) {
            $getDepartment = Tool::where('department_id', $request->department_id)
                ->where('category_id', $request->category_id)
                ->paginate(8);
            return response()->json(['getToolsByCategory' => $getDepartment], 200);
        }
        if ($request->getBySubCategory) {
            $getBySubCategory = Tool::with(['category'])
                ->where('department_id', $request->department_id)
                ->where('category_id', $request->category_id)
                ->where('subCategory_id', $request->subCategory_id)
                ->paginate(8);
            return response()->json(['getBySubCategory' => $getBySubCategory], 200);
        }
        if ($request->searchByToolName) {
            $finalText = str_replace('and', '&', $request->searchWithDepartment);
            $getDepartment = Department::where('name', $finalText)->first();
            if (!empty($getDepartment)) {
                $getToolsBySearchKey = Tool::where('department_id', $getDepartment->id)
                    ->where('tools.name', 'LIKE', '%' . request()->searchByToolName . '%')
                    ->paginate(8);
                return response()->json(['getToolsBySearchKey' => $getToolsBySearchKey], 200);
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $getDepartment = Tool::where('department_id', $request->department_id)
            ->where('category_id', $request->category_id)
            ->get();
        return response()->json(['getToolsByCategory' => $getDepartment], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $getStudent = User::find($id);
        $courses = [];
        $getTools = [];
        $getCategories = [];

        // return response()->json(['courses' => $courses, 'id' => $id], 200);

        if (request()->user()->courses) {
            $courses = explode(',', request()->user()->courses);

            $getDepartment = Department::where('name', $courses[0])->first();
            $getTools = Tool::where('department_id', $getDepartment->id)->paginate(8);
            // $getTools = Tool::where('department_id', $getDepartment->id)->get();
            $getCategories = Category::with('subCategories')
                ->where('department_id', $getDepartment->id)
                ->get();
        }

        date_default_timezone_set('Asia/Dhaka');
        //or get Date difference as total difference
        $d1 = strtotime(date('Y-m-d', strtotime(request()->user()->created_at)));
        $d2 = strtotime(date('Y-m-d'));
        $totalSecondsDiff = abs($d1-$d2); //42600225
        $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30;

        return response()->json(['courses' => $courses, 'categories' => $getCategories, 'tools' => $getTools, 'joinDate' => date('Y-m-d', strtotime(request()->user()->created_at)), 'monthAfterJoin' => $totalMonthsDiff, 'studentDepartments'=>$getDepartment,], 200);

        //get Date diff as intervals
        $d1 = new DateTime("2018-01-10 00:00:00");
        $d2 = new DateTime("2019-05-18 01:23:45");
        $interval = $d1->diff($d2);
        $diffInSeconds = $interval->s; //45
        $diffInMinutes = $interval->i; //23
        $diffInHours   = $interval->h; //8
        $diffInDays    = $interval->d; //21
        $diffInMonths  = $interval->m; //4
        $diffInYears   = $interval->y; //1

        //or get Date difference as total difference
        $d1 = strtotime("2018-01-10 00:00:00");
        $d2 = strtotime("2019-05-18 01:23:45");
        $totalSecondsDiff = abs($d1-$d2); //42600225
        $totalMinutesDiff = $totalSecondsDiff/60; //710003.75
        $totalHoursDiff   = $totalSecondsDiff/60/60;//11833.39
        $totalDaysDiff    = $totalSecondsDiff/60/60/24; //493.05
        $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30; //16.43
        $totalYearsDiff   = $totalSecondsDiff/60/60/24/365; //1.35
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
        //
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
