<?php
namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Task;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function create()
    {
        // Obtener todas las tareas disponibles
        $tasks = Task::all();

        // Enviar las tareas a la vista
        return view('adminlte.alta', compact('tasks'));
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
        ]);

        // Crear el alumno
        $alumno = Alumno::create($request->only('nombre', 'email'));

        // Asignar las tareas seleccionadas al alumno
        if ($request->has('tasks')) {
            $alumno->tasks()->attach($request->input('tasks'));
        }

        return redirect()->route('alumnos.create')->with('success', 'Alumno registrado y tareas asignadas correctamente');
    }
}
