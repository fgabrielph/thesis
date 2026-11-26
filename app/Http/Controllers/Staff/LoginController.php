<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect admins after login.
     *
     * @var string
     */
    protected $redirectTo = '/staff';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:staff')->except('logout');
    }

    /**
     * @return Factory|View
     */
    public function showLoginForm()
    {
        return view('staff.auth.login');
    }

    /**
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::guard('staff')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->get('remember'))) {
            return redirect()->intended(route('staff.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))->with('error', 'Wrong Credentials');
    }

    /**
     * @return Factory|View
     */
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();

        return redirect()->route('staff.login');
    }
}
