<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Students;
use App\Models\Classrooms;
use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $students;
    private $classrooms;

    public function __construct()
    {
        $this->students = new Students();
        $this->classrooms = new Classrooms();
    }

    public function index(Request $request)
    {
        $filter = [];
        $keyword = null;
        if (!empty($request->classroom_id)) {
            $filter[] = ['classroom_id', '=', $request->classroom_id];
        }
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
        }
        $studentsList = $this->students->getAll($filter,$keyword);
        foreach ($studentsList as $student) {
            $relativePath = 'images/' . $student->image;
            $student->image = asset(Storage::url($relativePath));
        }
        return view('students')->with('studentList', $studentsList)->with('keyword', $request->keyword);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $studentsList = [];
        $classList = $this->classrooms->getAll();
        return view('add')->with('studentList', $studentsList)->with('classList', $classList);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Cach validate 1
//        $request->validate([
//            'name' => 'required|unique:students|max:255',
//            'age' => 'required|integer|between:0,100',
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'classroom_id' => 'required'
//        ]);

        $rules = [
            'name' => 'required|unique:students|max:255',
            'age' => 'required|integer|between:0,100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'classroom_id' => 'required'
        ];
        $message = [
            'required' => 'Input :attribute must has value',
            'unique' => 'Input :attribute must unique',
            'max' => 'Max value :attribute is 255',
            'integer' => ':attribute must be Integer',
            'between' => ':attribute is bettwen 0 - 100',
            'image' => ':attribute is a image',
            'mimes:jpeg,png,jpg,gif,svg' => ':attribute is jpeg,png,jpg,gif,svg',
            'max:2048' => 'attribute max size is 2048'
        ];
//        $request->validate($rules, $message);

//Cach validate 2
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->route('add')->withErrors($validator)->withInput();
        }

        $fileName = $request->file('image')->getClientOriginalName();
        $request->image->storeAs('public/images', $fileName);
        $data = [
            $request->name,
            $request->age,
            $fileName,
            $request->classroom_id
        ];
        $this->students->createStudent($data);
        return redirect()->route('students')->with([
            'msg' => 'Students added successfully!',
            'status' => 'success'
        ]);
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
    public function edit($id = 0)
    {
        if (!empty($id)) {
            $userDetail = $this->students->getStudent($id);
            if (!empty($userDetail[0])) {
                $classList = $this->classrooms->getAll();
                $student = $this->students->getStudent($id);
                if (!empty($student) && is_array($student)) {
                    session(['id' => $id]);
                    $relativePath = 'images/' . $student[0]->image;
                    $student[0]->image = asset(Storage::url($relativePath));
                }
                return view('edit')->with('classList', $classList)->with('student', $student);
            } else {
                return redirect()->route('students')->with('msg', 'Wrong user');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = session('id');
        $request->validate([
            'name' => 'required|max:255',
            'age' => 'required|integer|between:0,100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'classroom_id' => 'required'
        ]);
        $student = $this->students->getStudent($id);
        if (!$student) {
            return redirect()->route('students')->with([
                'msg' => 'Student not found!',
                'status' => 'error'
            ]);
        }
        $path = $student[0]->image;
        if ($request->image != null) {
            $fileName = $request->file('image')->getClientOriginalName();
            $request->image->storeAs('public/images', $fileName);
            $updatedStudentData = [
                $request->name,
                $request->age,
                $fileName,
                $request->classroom_id,
            ];
        } else {
            $updatedStudentData = [
                $request->name,
                $request->age,
                $path,
                $request->classroom_id
            ];
        }
        $this->students->updateStudent($updatedStudentData, $id);
        return redirect()->route('students')->with([
            'msg' => 'Students edited successfully!',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->students->deleteStudent($id);
        return redirect()->route('students')->with([
            'msg' => 'Students deleted!',
            'status' => 'success'
        ]);
    }

}
