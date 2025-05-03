<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->pw)&& $user->systemrole == 'user') {
            Auth::login($user);

            return redirect()->route('admin.dashboard')->with('status', 'Login successful!');

        } else {
            return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'address' => 'required|string',
            'county' => 'required|string',
            'company_email' => 'required|string|email|unique:company,email',
            'phone' => 'required|string',
            'fax' => 'nullable|string',
            'currency' => 'required|string',
            'username' => 'required|string|unique:tbluser,username',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);


        $company = Company::create([
            'name' => $request->company_name,
            'address' => $request->address,
            'county' => $request->county,
            'email' => $request->company_email,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'currency' => $request->currency,
        ]);

        DB::insert('INSERT INTO  role (role, description, company_id) values (?, ?, ?)', ['owner', 'owner', $company->id]);
        $roleId = DB::getPdo()->lastInsertId();

        $roleId1 = $roleId; // Assign the role ID to $roleId1
        DB::insert('INSERT INTO user_per(role,sales,cus_care,chatbot,cat,product,user,roles) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', [$roleId1, 1, 1, 1, 1, 1, 1, 1]);

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'pw' => Hash::make($request->password),
            'email' => $request->company_email,
            'mobile' => $request->phone,
            'role' => $roleId,
            'company_id' => $company->id,
        ]);

        return redirect('/login')->with('status', 'Registration successful! You can now login.');
    }
    public function getUserPermissions()
    {
        $user = Auth::user();
        $role = $user->role;

        $permissions = DB::select('SELECT * FROM user_per WHERE role = ?', [$role]);
        return response()->json($permissions);
    }
    public function updatePermission(Request $request)
    {
        // Get the incoming data
        $role_id = $request->input('role_id');
        $permission = $request->input('permission');
        $status = $request->input('status');

        // Update the corresponding permission in the `user_per` table
        DB::table('user_per')
            ->where('role', $role_id)
            ->update([$permission => $status]);

        // Return a success response
        return response()->json(['message' => 'Permission updated successfully']);
    }
}