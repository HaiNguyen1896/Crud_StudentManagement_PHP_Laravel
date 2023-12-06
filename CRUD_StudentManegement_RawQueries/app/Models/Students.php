<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students';

    public function getAll($filter, $keyword)
    {
//        DB::enableQueryLog();
        $studentList = DB::table($this->table)
            ->select('students.*', 'classrooms.classname as class')
            ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->orderBy('students.id', 'DESC');
        if (!empty($filter)) {
            $studentList = $studentList->where($filter);
        }
        if (!empty($keyword)) {
            $studentList = $studentList->where(function ($query) use ($keyword) {
                $query->orWhere('students.name', 'like', '%' . $keyword . '%');
            });
        }
        $studentList = $studentList->get();
//        $sql = DB::getQueryLog();
//        dd($sql);
        return $studentList;
    }

    public function createStudent($data)
    {
        return DB::insert('INSERT INTO ' . $this->table . ' (name,age,image,classroom_id) VALUES (?,?,?,?)', $data);
    }

    public function getStudent($id)
    {
        return DB::select('SELECT * FROM ' . $this->table . ' where id=:id', ["id" => $id]);
    }

    public function updateStudent($data, $id)
    {
        $data[] = $id;
        return DB::update('UPDATE ' . $this->table . ' SET name=?,age=?,image=?,classroom_id=? WHERE id=?', $data);
    }

    public function deleteStudent($id)
    {
        DB::delete('delete from ' . $this->table . ' where id=?', [$id]);
    }

    public function findListStudent($keyword = null, $classroom_id = null)
    {
        return DB::select('SELECT students.*,classrooms.classname as class FROM ' . $this->table . ' INNER JOIN classrooms ON ' . $this->table . '.classroom_id=classrooms.id where name LIKE ?', ['%' . $keyword . '%']);
    }
}
