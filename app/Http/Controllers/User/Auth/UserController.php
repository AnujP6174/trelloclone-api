<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\NewPasswordRequest;
use App\Http\Requests\User\userLoginFormRequest;
use App\Http\Requests\User\userSignupFormRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'userLogin', 'forgotPassword', 'verifyOTP', 'setPassword']]);
    // }

    public function login()
    {
        $credentials = request(['email', 'password']);
        $anuj = Auth::guard('api')->attempt($credentials);
        if (!$anuj) {
            return response()->json(['error' => 'Please Check Credentials'], 401);
        }
        return $this->respondWithToken($anuj);
    }

    public function userLogin(userLoginFormRequest $request)
    {
        try {
            if ($some = Auth::guard('api')->attempt($request->only('email', 'password'))) {
                return $this->respondWithToken($some);
                // return redirect()->route('user.Dashboard')->with('success', 'Login Successfull');
            } else {
                // return redirect()->back()->with('error', 'Please Check Credentials');
                return response()->json(['error' => 'Please Check Credentials'], 401);
            }
            // return $this->respondWithToken($some);
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'Temporary Server error');
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout(true);
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $newToken = auth()->refresh();
        return $this->respondWithToken(auth()->refresh());
        $newToken = auth()->refresh(true, true);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->validated();
        try {
            $user = User::where('email', $email['email'])->first();
            if (!isset($user)) {
                return response()->json(['error' => 'Please enter registered email address']);
            }
            $digits = 4;
            $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $currentDateTime = Carbon::now()->addMinutes(5)->format('Y-m-d H:i:m');
            $user->update([
                'otp' => $otp,
                'otp_created_at' => $currentDateTime
            ]);
            return response()->json(['success' => 'OTP has been sent on entered email address']);
        } catch (\Exception $exception) {
            // dd($exception);
            return response()->json(['error' => 'Something Went Wrong'], 401);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $storedOTP = User::where('email', $request->email)->first();
            $enteredOTP = $request->otp;
            if ($storedOTP->otp_created_at < Carbon::now()->format('Y-m-d H:i:m')) {
                return response()->json(['error' => 'OTP has expired! Please generate new OTP']);
            } elseif ($storedOTP->otp == $enteredOTP) {
                return response()->json(['success' => 'OTP Verification Successful']);
            } else {
                return response()->json(['error' => 'Please Enter correct OTP']);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Something went wrong'], 401);
        }
    }

    public function setPassword(NewPasswordRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::where('email', $validated['email'])->first();
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
            return response()->json(['success', 'New Password has been successfully set'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Something went wrong'], 401);
        }
    }

    public function getDashboard(Request $request)
    {
        $dashboardData = [
            "associate1" => [
                "id" => '1',
                "name" => 'Anuj Panchal',
                "inprogress" => "12",
                "completed" => "08",
                "manual_completion" => "02",
                "automatic_completion" => "06"
            ],
            "associate2" => [
                "id" => '2',
                "name" => 'Umang Panchal',
                "inprogress" => "15",
                "completed" => "10",
                "manual_completion" => "05",
                "automatic_completion" => "05"
            ],
        ];
        return response()->json([
            'inprogress' => $dashboardData["associate2"]['inprogress'],
            'completed' => $dashboardData["associate2"]['completed'],
            'manual_completion' => $dashboardData["associate2"]['manual_completion'],
            'automatic_completion' => $dashboardData["associate2"]['automatic_completion']
        ]);
    }

    public function index()
    {
        return view('User.signup');
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

    public function userDashboard()
    {
        $tasks = Task::where('due_date', '>=', Carbon::now()->toDateString())->with('users')->get();
        return view('User.dashboard', ['tasks' => $tasks]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(userSignupFormRequest $request)
    {
        try {
            $validatedData = $request->validated();
            dd($validatedData);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            return response()->json(['success' => 'User Registration Successfull'], 200);
            // Auth::guard('user')->login($user);
            // return redirect()->route('user.Dashboard')->with('success', 'SignUp Successfull');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    public function userLogout()
    {
        try {
            Auth::guard('user')->logout();
            return redirect()->route('user.Login');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
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
}
