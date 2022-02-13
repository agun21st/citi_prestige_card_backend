<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Location;
use App\Models\Subscription;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name',)->get();
        $brands = Brand::select('id', 'name',)->get();
        $locations = Location::select('id', 'name',)->get();
        $offers = Offer::with(['category','brand','location'])->get();
        return view('welcome',compact('categories', 'brands', 'locations','offers'));
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
    public function search(Request $request)
    {
        if($request->category!="" && $request->brand=="" && $request->location=="")
        {
            $offers = Offer::where('category_id',$request->category)->get();
            $category = Category::where('id',$request->category)->first();
            return view('search',compact('category','offers'));
        }
        if($request->category!="" && $request->brand!="" && $request->location=="")
        {
            $offers = Offer::where(['category_id'=>$request->category, 'brand_id'=>$request->brand])->get();
            $category = Category::where('id',$request->category)->first();
            return view('search',compact('category','offers'));
        }
        if($request->category!="" && $request->brand=="" && $request->location!="")
        {
            $offers = Offer::where(['category_id'=>$request->category, 'location_id'=>$request->location])->get();
            $category = Category::where('id',$request->category)->first();
            return view('search',compact('category','offers'));
        }
        if($request->category!="" && $request->brand!="" && $request->location!="")
        {
            $offers = Offer::where(['category_id'=>$request->category, 'location_id'=>$request->location, 'brand_id'=>$request->brand])->get();
            $category = Category::where('id',$request->category)->first();
            return view('search',compact('category','offers'));
        }
        // dd($offers);
    }
    public function subscribe(Request $request)
    {
        // dd($request->subscriberIP);
        if(isset($request->email) && isset($request->subscriberIP))
        {
            $checkEmail = Subscription::where('email', $request->email)->first();
            if($checkEmail){
                return redirect()->back()->with('error_message', 'This Email Already Subcribed.');
            }else{
                Subscription::create([
                    'email' => $request->email,
                    'subscriberIP' => $request->subscriberIP,
                ]);
                return redirect()->back()->with('success_message', 'Email Subcription Successfully Done.');
            }
        }
    }
}
