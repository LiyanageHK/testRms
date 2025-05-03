<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = DB::select("SELECT * FROM roles");
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        DB::insert("INSERT INTO roles (name, created_at, updated_at) VALUES (?, NOW(), NOW())", [
            $request->name
        ]);
        return redirect('/admin/role')->with('success', 'Role created!');
    }

    public function edit($id)
    {
        $role = DB::selectOne("SELECT * FROM roles WHERE id = ?", [$id]);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        DB::update("UPDATE roles SET name = ?, updated_at = NOW() WHERE id = ?", [
            $request->name,
            $id
        ]);
        return redirect('/admin/role')->with('success', 'Role updated!');
    }

    public function destroy($id)
    {
        DB::delete("DELETE FROM roles WHERE id = ?", [$id]);
        return redirect('/admin/role')->with('success', 'Role deleted!');
    }
}
