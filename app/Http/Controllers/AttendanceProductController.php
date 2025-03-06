<?php

namespace App\Http\Controllers;

use App\Models\AttendanceProduct;
use Illuminate\Http\Request;

class AttendanceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('attendanceproduct.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceProduct $attendanceProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceProduct $attendanceProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceProduct $attendanceProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceProduct $attendanceProduct)
    {
        //
    }
}
