<?php
use App\Models\Classrooms;
function getClassroom()
{
    $classroom = new Classrooms();
    return $classroom->getAll();
}
?>
