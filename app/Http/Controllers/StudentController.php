<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    private function ensureDefaultInstitutions()
    {
        $defaultInstitutions = [
            ['name' => 'latiseducation'],
            ['name' => 'tutorindonesia'],
        ];

        foreach ($defaultInstitutions as $instData) {
            Institution::firstOrCreate(
                ['name' => $instData['name']],
                $instData
            );
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->ensureDefaultInstitutions();

        $institutions = Institution::all();

        $selectedInstitutions = $request->query('institutions');


        $query = Student::with('institution');

        if ($selectedInstitutions) {
            $query->where('institution_id', $selectedInstitutions);
        }

        $students = $query->get();

        return view('students.index', compact('students', 'institutions', 'selectedInstitutions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->ensureDefaultInstitutions();

        $institution = Institution::all();

        return view('students.create', compact('institution'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'institution_id' => 'required|exists:institution_id',
            'nis' => 'required|numeric|unique:students,nis',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png|max:100',
        ]);

        $data = $request->only(['institution_id', 'nis', 'name', 'email']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '-' . $file->getClientOriginalName();

            $path = $file->storeAs('photos', $filename, 'public');
            $data['photo'] = $path;
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $this->ensureDefaultInstitutions();

        $institutions = Institution::all();

        return view('students.edit', compact('student', 'institutions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'nis' => 'required|numeric|unique:students,nis,' . $student->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png|max:100',
        ]);

        $data = $request->only(['institution_id', 'nis', 'name', 'email']);

        if ($request->hasFile('photo')) {

            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');
            $data['photo'] = $path;
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student data deleted successfully.');
    }

    public function getData(Request $request): JsonResponse
    {
        $query = Student::with('institution');

        // Tambahkan pencarian (hanya NIS dan Nama)
        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('nis', 'like', "%{$searchValue}%")
                    ->orWhere('name', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('institution') && $request->institution) {
            $query->where('institution_id', $request->institution);
        }

        $students = $query->get();

        $data = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'institution' => $student->institution->name,
                'nis' => $student->nis,
                'name' => $student->name,
                'email' => $student->email,
                'photo' => $student->photo ? asset('storage/' . $student->photo) : null,
                'actions' => '<a href="' . route('students.edit', $student->id) . '" class="btn btn-sm btn-primary">Edit</a>
                              <form action="' . route('students.destroy', $student->id) . '" method="POST" class="d-inline">
                                  ' . csrf_field() . '
                                  ' . method_field('DELETE') . '
                                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                              </form>'
            ];
        });

        return response()->json([
            'data' => $data
        ]);
    }
}
