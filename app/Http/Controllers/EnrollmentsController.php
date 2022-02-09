<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\DB;

class EnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'department_id' => ['required'],
            'course_id' => ['required'],
            'enrollmentDate' => ['required'],
            'student_id' => ['required'],
        ]);

        $checkEnrollment = CourseEnrollment::where('department_id', '=', $request->department_id)->where('course_id', '=',$request->course_id)->where('student_id','=',$request->student_id)->first();
        if($checkEnrollment){
            return response()->json(["error" => "Course Already Enrolled"], 200);
        }else{

            DB::transaction(function () {
                $createEnrollment = CourseEnrollment::create([
                    'student_id' => request()->student_id,
                    'department_id' => request()->department_id,
                    'course_id' => request()->course_id,
                    'created_by' => request()->user()->id,
                    'enrollmentDate' => request()->enrollmentDate,
                ]);
            }, 3);
            $studentEnrollments = CourseEnrollment::with('department','course')->where(['student_id'=>request()->student_id])->get();
            return response()->json(["success" => "Course Enrolled Successfully",'studentEnrollments'=>$studentEnrollments], 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentEnrollments = CourseEnrollment::with('department','course')->where('student_id',$id)->get();
        return response()->json(['studentEnrollments'=>$studentEnrollments],200);
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
        // return response()->json(["success" => request()->all()], 201);
        request()->validate([
            'department_id' => ['required'],
            'course_id' => ['required',],
            'enrollmentDate' => ['required'],
            'student_id' => ['required'],
        ]);
        $checkEnrollmentCourseIsExists = CourseEnrollment::where('id','!=',$id)->where('student_id',request()->student_id)->where('department_id',request()->department_id)->where('course_id',request()->course_id)->first();
        if($checkEnrollmentCourseIsExists){
            $studentEnrollments = CourseEnrollment::with('department','course')->where(['student_id'=>request()->student_id])->get();
            return response()->json(["error" => "Course Already Enrolled",'studentEnrollments'=>$studentEnrollments], 200);
        }
        $checkEnrollment = CourseEnrollment::where('id',$id)->where('student_id',request()->student_id)->first();
        if($checkEnrollment){
            $checkEnrollment->update([
                'department_id' => request()->department_id,
                'course_id' => request()->course_id,
                'created_by' => request()->user()->id,
                'enrollmentDate' => request()->enrollmentDate,
            ]);
            $studentEnrollments = CourseEnrollment::with('department','course')->where(['student_id'=>request()->student_id])->get();
            return response()->json(["success" => "Course Enrolled Successfully",'studentEnrollments'=>$studentEnrollments], 201);
        }else{
            return response()->json(["error" => "Course Not Found"], 200);
        }
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
