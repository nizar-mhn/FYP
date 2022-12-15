<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Student;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $id = $request->input('id');
        $password = $request->input('password');

        if (!Auth::guard('student')->attempt(['studentID' => $id, 'password' => $password], $request->filled('remember'))) {
            if (!Auth::guard('admin')->attempt(['adminID' => $id, 'password' => $password], $request->filled('remember'))) {
                if (!Auth::guard('staff')->attempt(['staffID' => $id, 'password' => $password], $request->filled('remember'))) {
                    if ((!Auth::guard('supplier')->attempt(['supplierID' => $id, 'password' => $password], $request->filled('remember')))) {
                        return redirect()->route('login')->with('danger', 'Invalid credentials');
                    } else {
                        return redirect()->route('supplierMainPage');
                    }
                } else {
                    $currentUser = Staff::where('staffID', $id)->first();
                    if (!$currentUser->is_email_verified) {
                        auth()->logout();
                        return redirect()->route('login')
                            ->with('danger', 'You need to confirm your account. We have sent you an activation code, please check your email.');
                    } else {
                        return redirect()->route('staffMainPage');
                    }
                }
            } else {
                return redirect()->route('adminMainPage');
            }
        } else {
            $currentUser = Student::where('studentID', $id)->first();
            if (!$currentUser->is_email_verified) {
                auth()->logout();
                return redirect()->route('login')
                    ->with('danger', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            } else {
                return redirect()->route('document');
            }
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) // this means that the admin was logged in.
        {
            Auth::guard('admin')->logout();
            return redirect()->route('login');
        }

        if (Auth::guard('staff')->check()) // this means that the staff was logged in.
        {
            Auth::guard('staff')->logout();
            return redirect()->route('login');
        }

        if (Auth::guard('student')->check()) // this means that the student was logged in.
        {
            Auth::guard('student')->logout();
            return redirect()->route('login');
        }

        if (Auth::guard('supplier')->check()) // this means that the supplier was logged in.
        {
            Auth::guard('supplier')->logout();
            return redirect()->route('login');
        }

        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('login');
    }
}
