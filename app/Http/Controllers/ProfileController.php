<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Redirects to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function goToLogin()
    {
        return redirect('/login');
    }

    /**
     * Handles the profile picture upload and removal.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function profilepic()
    {
        $email = Session::get('email');

        if (isset($_POST['removepicture'])) {
            $imageString = DB::table('users')
                ->where('email', $email)
                ->value('image');

            if ($imageString != NULL) {
                File::delete(public_path('assets/uploads/' . $imageString));

                $updateEmailQuery = DB::table('users')
                    ->where('email', $email)
                    ->limit(1)
                    ->update(array('image' => NULL));

                if ($updateEmailQuery > 0) {
                    return redirect('/accountinfo');
                } else {
                    return response()->json('Error', 404);
                }
            } else {
                return back();
            }
        } else if (isset($_FILES['fileInput'])) {
            $img_name = $_FILES['fileInput']['name'];
            $img_size = $_FILES['fileInput']['size'];
            $tmp_name = $_FILES['fileInput']['tmp_name'];
            $error = $_FILES['fileInput']['error'];

            if ($error === 0) {
                if ($img_size > 3000000) {
                    return back()->withErrors(["profilepic" => "Maximum image size is 3MB."]);
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg", "jpeg", "png", "gif");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $imageString = DB::table('users')
                            ->where('email', $email)
                            ->value('image');

                        File::delete(public_path('assets/uploads/' . $imageString));

                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        move_uploaded_file($tmp_name, public_path('assets/uploads/') . $new_img_name);

                        $updateImageQuery = DB::table('users')
                            ->where('email', $email)
                            ->limit(1)
                            ->update(array('image' => $new_img_name));

                        if ($updateImageQuery > 0) {
                            return redirect('/accountinfo');
                        }
                    } else {
                        return response()->json($error, 404);
                    }
                }
            } else {
                return response()->json("some error", 404);
            }
        } else {
            return redirect('/login');
        }
    }

    /**
     * Handles the profile email change.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function changeprofileEmail(Request $request)
    {
        if (isset($_POST['email'])) {
            $newemail['email'] = $request['email'];
            $rules = array('email' => 'unique:users,email');
            $validator = Validator::make($newemail, $rules);

            if ($validator->fails()) {
                return back()->withErrors(['emailerror' => 'Email already in use!']);
            } else {
                $email = Session::get('email');

                $updateEmailQuery = DB::table('users')
                    ->where('email', $email)
                    ->limit(1)
                    ->update(array('email' => $newemail['email']));

                if ($updateEmailQuery > 0) {
                    Session::put('email', $newemail['email']);
                    return redirect('/accountinfo');
                } else {
                    return response()->json('Error', 404);
                }
            }
        } else {
            return redirect('/login');
        }
    }

    /**
     * Handles the profile username change.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function changeprofileUsername()
    {
        if (isset($_POST['username'])) {
            $newusername = $_POST['username'];
            $email = Session::get('email');

            $updateEmailQuery = DB::table('users')
                ->where('email', $email)
                ->limit(1)
                ->update(array('username' => $newusername));

            if ($updateEmailQuery > 0) {
                Session::put('username', $newusername);
                return redirect('/accountinfo');
            } else {
                return response()->json('Error', 404);
            }
        } else {
            return redirect('/login');
        }
    }

    /**
     * Handles the profile password change.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeprofilepassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'newpass' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(["passworderror" => "Current Password Doesn't match!"]);
        }

        if (strlen($request->newpass) >= 6 && strlen($request->confnewpass) >= 6) {
            if ($request->newpass == $request->confnewpass) {
                User::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->newpass)
                ]);

                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors(['passwordreset' => 'Password reset successfully!']);
            } else {
                return back()->withErrors(["passworderror" => "New password does not match with confirmation password"]);
            }
        } else {
            return back()->withErrors(["passworderror" => "The new password field must be at least 6 characters."]);
        }
    }

    /**
     * Handles the account deletion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function deleteaccount(Request $request)
    {
        $email = Session::get('email');
        $imageString = DB::table('users')
            ->where('email', $email)
            ->value('image');

        if ($imageString != NULL) {
            File::delete(public_path('assets/uploads/' . $imageString));
        }

        $deleteQuery = DB::table('users')->where('email', $email)->delete();

        if ($deleteQuery > 0) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors(['deleteaccount' => 'Account deleted successfully']);
        } else {
            return response()->json('404 Not Found', 404);
        }
    }
}
