<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Spatie\Permission\Models\Role;
class SUController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8']
        ]);
        $super = User::create([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => "super",
        ]);
        $newID = $super->id;
        $newlyInsertedUser = User::find($newID);
        $newlyInsertedUser->assignRole('super');
        return response(['status', 'successful'], 200);
    }

    public function update($id) {
        //update user
    }

    public function destroy($id) {
        //delete user
    }
}
