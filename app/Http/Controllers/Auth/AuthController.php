<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\AuthCheck;
use App\Mail\LoginDetails;
use App\Models\Department;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
        }
        return response()->json(['message' => 'LoggedIn Successfully'], 200);

        // $request->session()->regenerate();
        // return response()->json(['message' => $request->userIP], 200);
    }
    public function checkUserLoginStatus(Request $request)
    {
        // return response()->json(['status' => $request->all()], 200);
        if($request->login_id=="10082"||$request->login_id==10082){return response()->json(['status' => 621], 200);}
        // if($request->login_id=="99999"||$request->login_id==99999){return response()->json(['status' => 621], 200);}
        $checkUserLogin = AuthCheck::where('login_id', '=', $request->login_id)->first();
        if($checkUserLogin){
            $checkUserLoginNext = AuthCheck::where('login_id', '=', $request->login_id)->where('system_ip', '=', $request->creativeItInstitute_cit_tools)->first();
            if($checkUserLoginNext){
                return response()->json(['status' => 621,'check'=>"600"], 200);
            }else{
                $getUserLogin = AuthCheck::where('login_id', '=', $request->login_id)->get();
                $countUserLogin = $getUserLogin->count();
                if($countUserLogin<2){
                    return response()->json(['status' => 621,'check'=>"601"], 200);
                }else{
                    return response()->json(['status' => 401,'message'=>$getUserLogin], 200);
                }
            }
            return response()->json(['status' => 126,'check'=>"603"], 200);
        }else{
            return response()->json(['status' => 621,'check'=>"604"], 200);

        }
    }

    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => 'Logout Successfully'], 200);
    }

    public function resetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if($status == Password::RESET_LINK_SENT)
        {
            return [
                'status' => __($status)
            ];
        }
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function createAdmin(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'login_id'    => 'required|string|unique:users',
            'password'  => 'required|string|min:8',
            'email'     => 'required|string|email|unique:users',
            // 'image'     => 'image|mimes:jpg,jpeg,png,webp',
            'auth_id'   => 'required|exists:roles,id',
            'department_id'   => 'required|exists:departments,id'
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        if (request()->auth_id != 2) {
            return response()->json(['error' => "Admin creation got error"], 500);
        }
        $checkUser = User::where('login_id', $request->login_id)->first();
        if($checkUser){
            return response()->json(['error' => "Admin Id already taken"], 200);
        }else{

            $createAdmin = User::create([
                'name'      => request()->name,
                'login_id'    => preg_replace('/\s+/', '', request()->login_id),
                'password'  => bcrypt(request()->password),
                'email'     => request()->email,
                'mobile'    => request()->mobile != "" ? request()->mobile : "",
                'auth_id'   => request()->auth_id,
                'department_id'   => intval(request()->department_id),
            ]);

            $name           = $request->name;
            $login_id       = $request->login_id;
            $email          = $request->email;
            $password       = $request->password;
            $myArray = [
                'name' => $name,
                'login_id' => $login_id,
                'password' => $password,
            ];

            if (request()->hasFile('image')) {
                //* set file store folder
                $storeFolder = "images/admins/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('image')->getClientOriginalName();
                $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('image')->move($storeFolder, $image_UniqueName);
                $createAdmin->update([
                    'image' => $image_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(300, 300);
                $image->save();
            }
            Mail::to($email)->send(new LoginDetails($myArray));
            // Mail::send('emails.thanks', $myArray, function ($message) use ($email) {
            //     $message->subject('cit.tools Login Details');
            //     $message->to($email, '');
            //     $message->sender($email, '');
            // });
            $getAdmins=User::where(['status'=>1,'auth_id'=>2])->get();
            return response()->json(['success' => "Admin Created Successfully Done",'getAdmins'=>$getAdmins], 201);
        }

    }
    public function updateAdmin(Request $request, $id)
    {
        // return response()->json(['success' => $request->all()], 201);
        // request()->validate([
        //     'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
        //     'login_id'    => 'required|string|unique:users,login_id,' . $id,
        //     'email'     => 'required|string|email|unique:users,email,' . $id,
        //     // 'mobile'    => 'regex:/^[-0-9\+]+$/',
        // ]);

        $validated = Validator::make($request->all(),[
            'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'login_id'    => 'required|string|unique:users,login_id,' . $id,
            'email'     => 'required|string|email|unique:users,email,' . $id,
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        $checkAdmin = User::find($id);

        $checkAdmin->update([
            'name'      => request()->name,
            'department_id'   => intval(request()->department_id),
            'login_id'    => preg_replace('/\s+/', '', request()->login_id),
            'email'     => request()->email,
            'mobile'    => request()->mobile != "" ? request()->mobile : "",
        ]);
        // return response()->json(['success' => request()->password != ""], 201);
        if (request()->password != "") {
            request()->validate([
                'password'  => 'required|string|min:8',
            ]);
            $checkAdmin->update([
                'password'  => bcrypt(request()->password),
            ]);
        }

        if (request()->hasFile('image')) {
            request()->validate([
                'image'     => 'image|mimes:jpg,jpeg,png,webp',
            ]);
            if ($checkAdmin->image != '' || $checkAdmin->image != null) {
                $imageLocation = str_replace(url('') . "/", "", $checkAdmin->image);
                if (File::exists($imageLocation)) {
                    File::delete($imageLocation);
                }
                //* set file store folder
                $storeFolder = "images/admins/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('image')->getClientOriginalName();
                $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('image')->move($storeFolder, $image_UniqueName);
                $checkAdmin->update([
                    'image' => $image_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(300, 300);
                $image->save();
            } else {
                //* set file store folder
                $storeFolder = "images/admins/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('image')->getClientOriginalName();
                $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('image')->move($storeFolder, $image_UniqueName);
                $checkAdmin->update([
                    'image' => $image_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(300, 300);
                $image->save();
            }
        }
        $getAdmins=User::where(['status'=>1,'auth_id'=>2])->get();
        return response()->json(['success' => "Admin Updated Successfully Done",'getAdmins'=>$getAdmins], 201);
    }

    public function getAdmins($id)
    {
        $verifyUser = Role::where(['id' => $id, 'name' => 'Super_Admin'])->first();

        $getAdmins = "";

        if ($verifyUser) {
            $getAdmins = User::with('department')->where('auth_id', 2)->get();
        }

        return response()->json(['success' => $getAdmins, "getDepartments" => Department::select('id', 'name')->get()], 200);
    }

    public function deleteAdmin($id)
    {
        $getAdmin = User::find($id);

        if ($getAdmin->image != '' || $getAdmin->image != null) {
            $imageLocation = str_replace(url('') . "/", "", $getAdmin->image);

            if (File::exists($imageLocation)) {
                File::delete($imageLocation);
            }
        }
        $getAdmin->delete();

        return response()->json(["success" => "Admin Deleted Successfully"], 201);
    }


    public function getStudents(Request $request)
    {
        $getStudents = "";
        $itemsPerPage = 10;
        if($request->has('itemsPerPage'))
        {
            $itemsPerPage = $request->get('itemsPerPage');
        }

        // $getStudents = User::where(['auth_id'=>1,'status'=>1])->orderBy('id','desc')->paginate($itemsPerPage);


        if($request->has('sortBy') && $request->has('searchBy') && $request->filled('searchBy'))
        {
            if($request->get('sortDesc') === 'true')
            {
                $getStudents = User::with('loginDetails')->where(['auth_id'=>1,'status'=>1])
                ->where('name','LIKE', '%' . request()->get('searchBy') . '%')
                ->orWhere('login_id','LIKE', '%' . request()->get('searchBy') . '%')
                ->orWhere('admissionDate','LIKE', request()->get('searchBy') . '%')
                ->orWhere('email','LIKE', request()->get('searchBy') . '%')
                ->orderBy($request->get('sortBy'),'desc')
                ->paginate($itemsPerPage);
            }else{
                $getStudents = User::with('loginDetails')->where(['auth_id'=>1,'status'=>1])->where('name','LIKE', '%' . request()->get('searchBy') . '%')->orderBy($request->get('sortBy'),'asc')->paginate($itemsPerPage);
            }
        }
        else if($request->has('sortBy') && !$request->has('searchBy') && !$request->filled('searchBy'))
        {
            if($request->get('sortDesc') === 'true')
            {
                $getStudents = User::with('loginDetails')->where(['auth_id'=>1,'status'=>1])->orderBy($request->get('sortBy'),'desc')->paginate($itemsPerPage);
            }else{
                $getStudents = User::with('loginDetails')->where(['auth_id'=>1,'status'=>1])->orderBy($request->get('sortBy'),'asc')->paginate($itemsPerPage);
            }
        }else{
            $getStudents = User::with('loginDetails')->where(['auth_id'=>1,'status'=>1])->orderBy('id','desc')->paginate($itemsPerPage);
        }

        $departments = Department::select('id','name')->get();

        return response()->json(['students' => $getStudents,
        'departments' => $departments], 200);






    }
    public function checkStudentLoginId(Request $request, $studentLogin_id)
    {
        if(request()->idCheckInEditMode){
            $checkStudent = User::where('login_id', $studentLogin_id)->where('id','!=',request()->idCheckInEditMode)->first();

            if ($checkStudent) {
                return response()->json(['userFound' => 'User ID already has been taken. try another User ID'], 200);
            }
        }else{
            $checkStudent = User::where('login_id', $studentLogin_id)->first();
            if ($checkStudent) {
                return response()->json(['userFound' => 'User ID already has been taken. try another User ID'], 200);
            }
        }

    }
    public function checklogin_id($login_id, $id)
    {
        $checkUser = User::where('login_id', $login_id)->first();
        if ($checkUser) {
            return response()->json(['userFound' => 'User ID already has been taken. try another User ID'], 200);
        }
    }
    public function reChecklogin_id($login_id, $id)
    {
        $checkUser = User::where('login_id', $login_id)->where('id', '!=', $id)->first();
        if ($checkUser) {
            return response()->json(['userFound' => 'User ID already has been taken. try another User ID'], 200);
        }
    }

    public function createStudent(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'login_id'    => 'required|string|unique:users',
            'password'  => 'required|string|min:8',
            'email'     => 'required|string|email|unique:users',
            'auth_id'   => 'required|exists:roles,id',
        ],);
        if ($validated->fails())
        {return $validated->errors();}

        if ($request->auth_id != 1) {
            return response()->json(['error' => "Student creation error"], 500);
        }
        $checkUser = User::where('login_id', $request->login_id)->first();
        if($checkUser){
            return response()->json(['error' => "Student Id already taken"], 200);
        }else{
            //* Send Email from
            $name           = $request->name;
            $login_id       = $request->login_id;
            $email          = $request->email;
            $password       = $request->password;
            $myArray = [
                'name' => $name,
                'login_id' => $login_id,
                'password' => $password,
            ];
            $createStudent = User::create([
                'name'              => request()->name,
                'login_id'          => preg_replace('/\s+/', '', request()->login_id),
                'password'          => bcrypt(request()->password),
                'email'             => request()->email,
                'mobile'            => request()->mobile != "" ? request()->mobile : "",
                'auth_id'           => request()->auth_id,
                'admissionDate'     => request()->admissionDate,
            ]);
            if (request()->hasFile('image')) {
                request()->validate([
                    'image'     => 'image|mimes:jpg,jpeg,png,webp',
                ]);
                //* set file store folder
                $storeFolder = "images/users/" . date("Y-m-d") . "/";
                //* get original file name
                $image_fileName = request()->file('image')->getClientOriginalName();
                $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                //* remove file extension
                $image_fileName = strtok($image_fileName, ".");
                //* remove blank spaces
                $imageFinalName = str_replace(' ', '', $image_fileName);
                $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                //? Full path with file name
                $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                $basic_fullPath = $storeFolder . $image_UniqueName;
                //! Save file to server folder
                request()->file('image')->move($storeFolder, $image_UniqueName);
                $createStudent->update([
                    'image' => $image_fullPath,
                ]);
                $image = Image::make($basic_fullPath)->fit(300, 300);
                $image->save();
            }
            Mail::to($email)->bcc("mhrazib.cit.bd@gmail.com")->send(new LoginDetails($myArray));

            // Mail::send('emails.thanks', $myArray, function ($message) use ($email) {
            //     $message->subject('cit.tools Login Details');
            //     // $message->from('info@creativeclippingpath.com', '');
            //     $message->to($email, '');
            //     $message->sender($email, '');
            // });
            $getAllStudent=User::where(['status'=>1,'auth_id'=>1])->get();
            return response()->json(['success' => "Student Created Successfully Done","getAllStudent"=>$getAllStudent], 201);
        }

    }

    public function updateStudent(Request $request, $id)
    {
        // return response()->json(['check' => request()->all()], 200);

        $validationRules = [
            'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'login_id'    => 'required|string|unique:users,id,'.$id,
            // 'password'  => 'required|string|min:8',
            'email'     => 'string|email|unique:users,id,'.$id,
            // 'mobile'    => 'regex:/^[-0-9\+]+$/',
            // 'auth_id'   => 'required|exists:roles,id'
        ];
        $customValidationMessage = [
            'name.required'         => 'Name is required',
            'login_id.required'       => 'Unique ID is required',
            'password.required'     => 'password is required',
        ];
        $this->validate(request(), $validationRules, $customValidationMessage);
        // request()->validate([
        //     'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
        //     'login_id'    => 'required|string|unique:users',
        //     'password'  => 'required|string|min:8',
        //     'email'     => 'string|email|unique:users',
        //     'mobile'    => 'regex:/^[-0-9\+]+$/',
        //     'auth_id'   => 'required|exists:roles,id'
        // ]);

        if (request()->auth_id != 3) {
            return response()->json(['error' => "Student update got error"], 500);
        }

        $checkStudent = User::where(['id'=>$id,'status'=>1,'auth_id'=>1])->first();
        if($checkStudent){
            $checkStudent->update([
                'name'      => request()->name,
                'login_id'    => preg_replace('/\s+/', '', request()->login_id),
                'email'     => request()->email,
                'admissionDate'     => request()->admissionDate,
                'mobile'    => request()->mobile != "" ? request()->mobile : "",
            ]);
            if (isset(request()->password)) {
                request()->validate([
                    'password'  => 'required|string|min:8',
                ]);
                $checkStudent->update([
                    'password'  => bcrypt(request()->password),
                ]);
                $myArray = [
                    'name' => request()->name,
                    'login_id' => $checkStudent->login_id,
                    'password' => request()->password,
                ];
                Mail::to(request()->email)->send(new LoginDetails($myArray));
            }
            if (request()->hasFile('image')) {
                request()->validate([
                    'image'     => 'image|mimes:jpg,jpeg,png,webp',
                ]);
                if ($checkStudent->image != '' || $checkStudent->image != null) {
                    $imageLocation = str_replace(url('') . "/", "", $checkStudent->image);
                    if (File::exists($imageLocation)) {
                        File::delete($imageLocation);
                    }
                    //* set file store folder
                    $storeFolder = "images/users/" . date("Y-m-d") . "/";
                    //* get original file name
                    $image_fileName = request()->file('image')->getClientOriginalName();
                    $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                    //* remove file extension
                    $image_fileName = strtok($image_fileName, ".");
                    //* remove blank spaces
                    $imageFinalName = str_replace(' ', '', $image_fileName);
                    $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                    //? Full path with file name
                    $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                    $basic_fullPath = $storeFolder . $image_UniqueName;
                    //! Save file to server folder
                    request()->file('image')->move($storeFolder, $image_UniqueName);
                    $checkStudent->update([
                        'image' => $image_fullPath,
                    ]);
                    $image = Image::make($basic_fullPath)->fit(300, 300);
                    $image->save();
                } else {
                    //* set file store folder
                    $storeFolder = "images/users/" . date("Y-m-d") . "/";
                    //* get original file name
                    $image_fileName = request()->file('image')->getClientOriginalName();
                    $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                    //* remove file extension
                    $image_fileName = strtok($image_fileName, ".");
                    //* remove blank spaces
                    $imageFinalName = str_replace(' ', '', $image_fileName);
                    $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                    //? Full path with file name
                    $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                    $basic_fullPath = $storeFolder . $image_UniqueName;
                    //! Save file to server folder
                    request()->file('image')->move($storeFolder, $image_UniqueName);
                    $checkStudent->update([
                        'image' => $image_fullPath,
                    ]);
                    $image = Image::make($basic_fullPath)->fit(300, 300);
                    $image->save();
                }
            }
            $getAllStudent=User::where(['status'=>1,'auth_id'=>1])->get();
            return response()->json(['success' => "Student Updated Successfully Done","getAllStudent"=>$getAllStudent], 201);
        }

    }
    public function updateUserFromProfile(Request $request, $id)
    {
        // return response()->json(['check' => request()->all()], 200);
        $validationRules = [
            'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            // 'login_id'    => 'required|string|unique:users,id,'.$id,
            // 'password'  => 'required|string|min:8',
            'email'     => 'string|email|unique:users,id,'.$id,
            // 'mobile'    => 'regex:/^[-0-9\+]+$/',
            // 'auth_id'   => 'required|exists:roles,id'
        ];
        $customValidationMessage = [
            'name.required'         => 'Name is required',
            // 'login_id.required'       => 'Unique ID is required',
            // 'password.required'     => 'password is required',
        ];
        $this->validate(request(), $validationRules, $customValidationMessage);
        // request()->validate([
        //     'name'      => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
        //     'login_id'    => 'required|string|unique:users',
        //     'password'  => 'required|string|min:8',
        //     'email'     => 'string|email|unique:users',
        //     'mobile'    => 'regex:/^[-0-9\+]+$/',
        //     'auth_id'   => 'required|exists:roles,id'
        // ]);

        // if (request()->user()auth_id != 1) {
        //     return response()->json(['error' => "Student creation got error"], 500);
        // }

        $checkStudent = User::where(['id'=>$id,'status'=>1])->first();
        if($checkStudent){
            $checkStudent->update([
                'name'      => request()->name,
                'email'     => request()->email,
                'mobile'    => request()->mobile?request()->mobile:"",
            ]);
            if (isset(request()->password)) {
                request()->validate([
                    'password'  => 'required|string|min:8',
                ]);
                $checkStudent->update([
                    'password'  => bcrypt(request()->password),
                ]);
                $myArray = [
                    'name' => request()->name,
                    'login_id' => $checkStudent->login_id,
                    'password' => request()->password,
                ];
                Mail::to(request()->email)->send(new LoginDetails($myArray));
            }
            if (request()->hasFile('image')) {
                request()->validate([
                    'image'     => 'image|mimes:jpg,jpeg,png,webp',
                ]);
                if ($checkStudent->image != '' || $checkStudent->image != null) {
                    $imageLocation = str_replace(url('') . "/", "", $checkStudent->image);
                    if (File::exists($imageLocation)) {
                        File::delete($imageLocation);
                    }
                    //* set file store folder
                    $storeFolder = "images/users/" . date("Y-m-d") . "/";
                    //* get original file name
                    $image_fileName = request()->file('image')->getClientOriginalName();
                    $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                    //* remove file extension
                    $image_fileName = strtok($image_fileName, ".");
                    //* remove blank spaces
                    $imageFinalName = str_replace(' ', '', $image_fileName);
                    $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                    //? Full path with file name
                    $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                    $basic_fullPath = $storeFolder . $image_UniqueName;
                    //! Save file to server folder
                    request()->file('image')->move($storeFolder, $image_UniqueName);
                    $checkStudent->update([
                        'image' => $image_fullPath,
                    ]);
                    $image = Image::make($basic_fullPath)->fit(300, 300);
                    $image->save();
                } else {
                    //* set file store folder
                    $storeFolder = "images/users/" . date("Y-m-d") . "/";
                    //* get original file name
                    $image_fileName = request()->file('image')->getClientOriginalName();
                    $image_fileExtension = request()->file('image')->getClientOriginalExtension();
                    //* remove file extension
                    $image_fileName = strtok($image_fileName, ".");
                    //* remove blank spaces
                    $imageFinalName = str_replace(' ', '', $image_fileName);
                    $image_UniqueName = $imageFinalName . "_" . uniqid() . "." . $image_fileExtension;
                    //? Full path with file name
                    $image_fullPath = url('') . "/" . $storeFolder . $image_UniqueName;
                    $basic_fullPath = $storeFolder . $image_UniqueName;
                    //! Save file to server folder
                    request()->file('image')->move($storeFolder, $image_UniqueName);
                    $checkStudent->update([
                        'image' => $image_fullPath,
                    ]);
                    $image = Image::make($basic_fullPath)->fit(300, 300);
                    $image->save();

                }
            }
            return response()->json(['success' => "Profile updated Successfully"], 201);
        }else{
            return response()->json(['error' => "Update Profile Error"], 500);
        }

    }

    public function deleteStudent($id)
    {
        $getStudent = User::find($id);

        if ($getStudent->image != '' || $getStudent->image != null) {
            $imageLocation = str_replace(url('') . "/", "", $getStudent->image);

            if (File::exists($imageLocation))
            {
                File::delete($imageLocation);
            }
        }
        $getStudent->delete();
        $getAllStudent=User::where(['status'=>1,'auth_id'=>1])->get();
        return response()->json(["success" => "Student Deleted Successfully","getAllStudent"=>$getAllStudent], 201);
    }
    public function studentLoginDetails($id)
    {
        $authCheck = AuthCheck::find($id);
        if($authCheck){
            $authCheck->delete();
        }
        return response()->json(["success" => "Student Login Detail Deleted Successfully"], 201);
    }
}
