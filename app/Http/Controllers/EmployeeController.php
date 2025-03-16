<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::paginate(5);
        return view('employee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('employee.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees,email',
            'address' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'position' => 'required',
            'department_id' => 'required',
            'username' => 'required|unique:employees,username',
            'password' => 'required',
            'avatar' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'gender.required' => 'Vui lòng chọn giới tính',
            'position.required' => 'Vui lòng nhập vị trí',
            'department_id.required' => 'Vui lòng chọn phòng ban',
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'avatar.required' => 'Vui lòng chọn ảnh đại diện',
        ]);

        $employee = new Employee();
        $employee->name = $data['name'];
        $employee->email = $data['email'];
        $employee->address = $data['address'];
        $employee->phone = $data['phone'];
        $employee->gender = $data['gender'];
        $employee->position = $data['position'];
        $employee->department_id = $data['department_id'];
        $employee->username = $data['username'];
        $employee->password = bcrypt($data['password']);

        $file_name = $request->avatar->hashName();
        $request->avatar->move(public_path('uploads'), $file_name);
        $employee->avatar = $file_name;

        $employee->save();

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        if ($data['position'] === 'Nhân viên quản lý') {
            $user->roles = 'manager,employee';
        } else if ($data['position'] === 'Nhân viên xưởng') {
            $user->roles = 'employee';
        } else if ($data['position'] === 'Nhân viên sản xuất') {
            $user->roles = 'employee';
        } else {
            $user->roles = '';
        }
        $user->remember_token = Str::random(10);
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('employee.index')->with('success', 'Thêm nhân viên mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function search(Request $request){

    }
}
