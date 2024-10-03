<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email'];

    public function tasks()
{
    return $this->belongsToMany(Task::class, 'alumno_task');
}

}
