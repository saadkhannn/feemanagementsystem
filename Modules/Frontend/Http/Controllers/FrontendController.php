<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(auth()->check()){
            auth()->logout();
        }

        return view('frontend::auth.login', [
            'title' => 'Login'
        ]);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => "required",
            'password' => 'required'
        ]);

        if (auth()->check() && auth()->user()->hasRole('Student')) {
            return $this->redirectBackWithSuccess('You Have Already Logged In', 'student.dashboard');
        }

        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        if ($user->hasRole('Student')) {
            $check_password = Hash::check($request->password, $user->password);
            if ($check_password) {
                if ($user->status != 1) {
                    return $this->backWithError('Sorry! Your Account Is Inactive. Please verify your email or Contact With Administrator To active Account.');
                }

                if (auth()->attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                ])) {
                    return $this->redirectBackWithSuccess('Successfully Signed In', 'student.dashboard');
                }
            } else {
                return $this->backWithError('Sorry! Password Incorrect. Please Try Again!! ');
            }
        } else {
            return $this->backWithError('Sorry! No account found with this email ');
        }

        return redirect()->back();
    }

    public function dashboard(){
        $title="Welcome Dashboard";
        return view('frontend::pages.dashboard', compact('title'));
    }

    public function logout()
    {
        auth()->logout();
        return $this->redirectBackWithSuccess('Successfully Logged Out', 'homepage');
    }
}
