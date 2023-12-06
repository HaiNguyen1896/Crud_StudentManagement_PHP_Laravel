<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Classrooms extends Model
{
    use HasFactory;

    public function getAll() {
        return DB::select('SELECT * FROM classrooms');
    }

}
