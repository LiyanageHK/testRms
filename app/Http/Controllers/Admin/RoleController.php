<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function create()
    {
        return view('admin.role.create');
    }


    public function store(Request $request)
    {
      
        $request->validate([
            'role' => 'required|max:255',
            'description' => 'nullable',
        ]);

        DB::insert('INSERT INTO role (role, description) VALUES (?,?)', [
            strtolower($request->input('role')),
            $request->input('description'),
        ]);
        $role_id = DB::getPdo()->lastInsertId();
        DB::insert('INSERT INTO user_per(role) VALUES(?)', [$role_id]);

        return redirect()->route('admin.role.index')->with('success', 'Role created successfully!');
    }


    public function edit($id)
    {
        $role = DB::select('SELECT * FROM role WHERE id = ?', [$id]);
        $permissions = DB::select('SELECT * FROM user_per WHERE role = ?', [$id]);
        return view('admin.role.edit', ['role' => $role[0], 'permissions' => $permissions[0]]);
    }

    // Update the role in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|max:255',
            'description' => 'nullable',
        ]);

        DB::update('UPDATE role SET role = ?, description = ? WHERE id = ?', [
            strtolower($request->input('role')),
            $request->input('description'),
            $id,
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Role updated successfully!');
    }

    // Delete the role from the database
    public function destroy($id)
    {
        DB::delete('DELETE FROM role WHERE id = ?', [$id]);

        return redirect()->route('admin.role.index')->with('success', 'Role deleted successfully!');
    }
    public function index()
    {
     

        $roles = DB::select('SELECT * FROM role' );
        return view('admin.role.index', ['roles' => $roles]);
    }




}