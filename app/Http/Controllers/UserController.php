<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $fillable = ['username', 'email', 'password', 'secretcode', 'id'];

    public function goToLogin()
    {
        return redirect('/login');
    }

    public function goToRegister()
    {
        return redirect('/register');
    }

    public function goToCodeReset()
    {
        return redirect('/resetcode');
    }

    public function goToResetPass()
    {
        return redirect('/resetpassword');
    }

    public function register(Request $request)
    {
        if (!$request->has('check')) {
            return back()->withErrors(['password' => 'Accept the Terms and Conditions'])->onlyInput('email', 'username', 'password');
        }

        $email = $request->input('email');
        $rules = ['email' => 'unique:users,email'];
        $validator = Validator::make(['email' => $email], $rules);

        if ($validator->fails()) {
            return back()->withErrors(['password' => 'Email already in use!'])->onlyInput('email', 'username', 'password');
        }

        $sevendigit = rand(1000000, 9999999);
        $secretcode = bcrypt($sevendigit);

        $formFields = $request->validate([
            'username' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6'],
        ]);

        $userid = DB::table('users')->orderBy('id', 'desc')->value('id');
        $userid = $userid == null ? 0 : $userid + 1;

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields + ['secretcode' => $secretcode] + ['id' => $userid]);

        Session::put('email', $formFields['email']);
        $query = DB::table('users')->where('email', $formFields['email'])->value('username');
        Session::put('username', $query);

        auth()->login($user);

        return redirect('/accountinfo')->withErrors(['code' => 'SAVE THIS CODE -> ' . $sevendigit . '']);
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (Auth::attempt($formFields)) {
            $email = $formFields['email'];
            $queryUser = DB::table('users')->where('email', $email)->value('username');
            if (DB::table('users')->where('email', $email)->value('2fa_active') == "false") {
                $request->session()->regenerate();
                Session::put('email', $email);
                Session::put('password', $formFields['password']);
                Session::put('username', $queryUser);
                return redirect('/accountinfo');
            } else {
                Session::put('email', $email);
                Session::put('username', $queryUser);
                return redirect('/users/send2fa');
            }
        } else {
            return back()->withErrors(['password' => 'Invalid Credentials'])->onlyInput('email', 'password');
        }
    }

    public function activate2fa()
    {
        $email = Session::get('email');

        if ($email != NULL) {
            $update2FAActiveQuery = DB::table('users')
                ->where('email', $email)
                ->limit(1)
                ->update(['2fa_active' => "true"]);

            if ($update2FAActiveQuery > 0) {
                return back()->withErrors(['2fasuccess' => '2 factor authentication successfully enabled']);
            }
        }

        return redirect('/login');
    }

    public function verify2facode(Request $request)
    {
        $email = Session::get('email');

        if ($email != NULL) {
            $get2FACode = DB::table('users')->where('email', $email)->value('2facode');

            if ($get2FACode != "") {
                if (!Hash::check($request->code, $get2FACode)) {
                    return back()->withErrors(['codeerror' => 'Wrong Code']);
                } else {
                    $deleteUsedCode = DB::table('users')
                        ->where('email', $email)
                        ->limit(1)
                        ->update(['2facode' => NULL]);

                    if ($deleteUsedCode > 0) {
                        return redirect('/accountinfo');
                    }
                }
            }
        }

        return redirect('/login');
    }

    public function resetpass(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required',
            'password' => ['required', 'min:6'],
            'secretcode' => ['required', 'min:6'],
        ]);

        if (!$request->has('email') || !$request->has('password') || !$request->has('secretcode') || !$request->has('check')) {
            return back()->withErrors(["secretcode" => "Make sure you are sure!"])->onlyInput('email', 'password');
        }

        $getUserCode = DB::table('users')->where('email', $formFields['email'])->value('secretcode');

        if ($getUserCode != "") {
            if (!Hash::check($request->secretcode, $getUserCode)) {
                return back()->withErrors(["secretcode" => "Secret codes don't match!"])->onlyInput('email');
            }

            $updatePasswordQuery = DB::table('users')
                ->where('email', $formFields['email'])
                ->limit(1)
                ->update(['password' => Hash::make($formFields['password'])]);

            if ($updatePasswordQuery > 0) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->withErrors(['passwordreset' => 'Password reset successfully!']);
            }
        } else {
            return back()->withErrors(["secretcode" => "Account does not exist!"])->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function completeVerification(Request $request, User $email)
    {
        $userEmail = $email['email'];

        if ($userEmail != NULL) {
            $checkAccountExists = DB::table('users')->where('email', $userEmail)->value('email');

            if ($checkAccountExists != NULL) {
                $updateVerifiedQuery = DB::table('users')
                    ->where('email', $userEmail)
                    ->limit(1)
                    ->update(['verified_acc' => "true"]);

                if ($updateVerifiedQuery > 0) {
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return view('/emailverified');
                } else {
                    return response()->json($userEmail . ' is already verified', 404);
                }
            } else {
                return response()->json('Gave another error for some reason' . $userEmail . '', 404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function disable2fa()
    {
        $email = Session::get('email');

        if ($email != NULL) {
            $update2FAActiveQuery = DB::table('users')
                ->where('email', $email)
                ->limit(1)
                ->update(['2fa_active' => "false"]);

            if ($update2FAActiveQuery > 0) {
                return back()->withErrors(['2fasuccess' => '2 factor authentication successfully disabled']);
            }
        }

        return redirect('/login');
    }
}
