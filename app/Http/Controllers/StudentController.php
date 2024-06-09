<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
        return view('students.create', compact('provinces'));
    }

    public function getCities($province_id)
    {
        $cities = Regency::where('province_id', $province_id)->get();
        return response()->json($cities);
    }

    public function getDistricts($regency_id)
    {
        $districts = District::where('regency_id', $regency_id)->get();
        return response()->json($districts);
    }

    public function getVillages($district_id)
    {
        $villages = Village::where('district_id', $district_id)->get();
        return response()->json($villages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gender' => 'required',
            'alamat' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
        ]);

        $student = new Student();
        $student->name = $request->nama;
        $student->gender = $request->gender;
        $student->address = $request->alamat;
        $student->province_id = $request->province_id;
        $student->regency_id = $request->city_id;
        $student->district_id = $request->district_id;
        $student->village_id = $request->village_id;
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student = Student::find($student->id);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student = Student::findOrFail($student->id);
        $provinces = Province::all();
        $cities = Regency::where('province_id', $student->province_id)->get();
        $districts = District::where('regency_id', $student->regency_id)->get();
        $villages = Village::where('district_id', $student->district_id)->get();

        return view('students.edit', compact('student', 'provinces', 'cities', 'districts', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gender' => 'required',
            'alamat' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
        ]);

        $student = Student::findOrFail($id);
        $student->name = $request->nama;
        $student->gender = $request->gender;
        $student->address = $request->alamat;
        $student->province_id = $request->province_id;
        $student->regency_id = $request->city_id;
        $student->district_id = $request->district_id;
        $student->village_id = $request->village_id;
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student = Student::findOrFail($student->id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
