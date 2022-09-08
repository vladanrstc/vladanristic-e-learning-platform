<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function index(Request $request)
    {
        $param = $request->get('q');

        if ($param != null) {
            return User::where("email", 'like', '%' . $param . '%')->paginate(10);
        } else {
            return User::paginate(10);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $user)
    {
        $created_user = new User();
        $created_user->password = $user->password;
        $created_user->email = $user->email;
        $created_user->name = $user->name;
        $created_user->last_name = $user->last_name;
        $created_user->role = $user->role;
        $created_user->language = $user->language;
        $created_user->email_verified_at = new \DateTime();
        $created_user->save();
        return response()->json("Success", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {

            $user->update(request()->validate([
                'name' => 'required|max:255|min:3',
                'last_name' => 'required|max:255|min:3',
                'role' => 'required|max:255|min:3',
                'language' => 'required',
                'email' => 'required|email|max:255|min:3'
            ]));

            if($request->password != '') {

                $user->update([
                    'password' => $request->password
                ]);
            }

            $user->save();

            return response()->json("success", 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json("error", 422);
        } catch (\Throwable $e) {
            return response()->json("error", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $banned_user = User::onlyTrashed()->where("id", $user)->first();
        $banned_user->forceDelete();
        return response()->json("success", 200);
    }

    public function ban_user(User $user) {
        $user->delete();
        return response()->json("success", 200);
    }

    public function banned_users() {
        return User::onlyTrashed()->paginate(10);
    }

    public function unban_user($user) {
        $banned_user = User::where("id", $user)->onlyTrashed()->first();
        $banned_user->restore();
        return response()->json("success", 200);
    }

    public function logged_user() {
        return Auth::user();
    }

    public function edit_logged_user(Request $request) {

        $logged_user = Auth::user();

        $logged_user->update(request()->validate([
            'name' => 'required|max:255|min:3',
            'last_name' => 'required|max:255|min:3',
            'email' => 'required|email|max:255|min:3'
        ]));

        if($request->password != '') {

            if(!Hash::check($request->current_password, $logged_user->password)) {
                return response()->json('Your credentials are incorrect. Please try againnn ', 401);
            }

            $logged_user->update([
                'password' => $request->password
            ]);
        }

        $logged_user->save();

        return response()->json("success", 200);

    }

}
