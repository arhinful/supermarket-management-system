<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return ['users' => $users];
    }

    public function update(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'salary' => 'required|numeric',
            'admin' => 'required',
        ]);
        // check admin
        $admin = false;
        if ($request->admin == 'Administrator'){
            $admin = true;
        }
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->salary = $request->salary;
        $user->admin = $admin;
        $user->update();
        return ['mess'=> $user->name."'s profile has been updated successfully"];
    }

    public function update_password(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $this->validate($request, [
            'id' => 'required|numeric',
            'password' => 'required|confirmed',
        ]);
        $user = User::find($request->id);
        $user->password = bcrypt($request->password);
        $user->update();
        return ['mess'=> $user->name."'s password updated successfully"];
    }

    public function destroy(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $this->validate($request, ['id'=>'required']);
        $user = User::find($request->id);
        $user->delete();
        return ['mess' => 'User deleted successfully'];
    }

    public function create(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
        $role = false;
        if ($request->role == 'Administrator'){ $role = true; }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->username,
            'admin' => $role,
            'salary' => $request->salary,
            'password' => bcrypt($request->password),
        ]);

        return ['mess' => 'user added successfully'];
    }

    public function view(){
        if (!Auth::user()->admin){
            return abort(404);
        }
        return ['user' => Auth::user()];
    }

    // update own profile
    public function umprof(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required|string',
            'username' => 'required|string',
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->username;
        $user->update();
        return ['mess' => 'profile updated successfully'];
    }

    // update own password
    public function umpass(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->update();
        return ['mess' => 'Password updated successfully'];
    }

    public function checkUserPassword(Request $request){
        if (!Auth::user()->admin){
            return abort(404);
        }
        if (Hash::check($request->password, Auth::user()->password)){
            return ['result' => 'match'];
        }
        else{
            return ['result' => 'not-match'];
        }
    }
}
