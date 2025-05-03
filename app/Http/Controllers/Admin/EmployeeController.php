<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('position', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%');
            });
        }

        $employees = $query->orderBy('id')->paginate(10);  // Added pagination for better performance

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'nic' => 'required|string|max:20|unique:employees,nic',
            'phone' => 'required|regex:/^\+94[0-9]{9}$/',
            'position' => 'required',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'nic' => $request->nic,
            'password' => bcrypt($request->nic), // Default password set as NIC
            'position' => $request->position,
            'phone' => $request->phone,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'nic' => 'required|string|max:20',
            'position' => 'required|in:Administrator,Chef,Kitchen Staff,Driver',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'nic' => $request->nic,
            'phone' => $request->phone,
            'position' => $request->position,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }
}