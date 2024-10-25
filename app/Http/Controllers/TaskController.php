<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpMqtt\Client\Facades\MQTT;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        // Obtener los parámetros de búsqueda y orden
        $search = $request->input('search');
        $sort = $request->input('sort', 'desc'); // Por defecto, orden descendente (última tarea creada)

        // Consultar las tareas
        $tasks = Task::query();

        // Filtrar las tareas según la búsqueda
        if ($search) {
            $tasks->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Ordenar las tareas según la fecha de creación
        $tasks->orderBy('created_at', $sort);

        // Paginar los resultados
        $tasks = $tasks->paginate(5);

        // Retornar la vista con las tareas, el orden y la búsqueda
        return view('index', compact('tasks', 'sort', 'search'));
    }

    public function create(): View
    {
        return view('create');
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = Task::create($request->all());

        // Publicar un mensaje MQTT al crear la tarea
        $this->sendMessage($task->id, 'created');

        return redirect()->route('tasks.index')->with('success', 'Nueva tarea creada exitosamente');
    }

    public function edit(Task $task): View
    {
        return view('edit', ['task' => $task]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $task->update($request->all());

        // Publicar un mensaje MQTT al actualizar la tarea
        $this->sendMessage($task->id, 'updated');

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy(Task $task): RedirectResponse
    {
        // Publicar un mensaje MQTT antes de eliminar la tarea
        $this->sendMessage($task->id, 'deleted');

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente');
    }

    // Método para enviar mensajes MQTT
    public function sendMessage($taskId, $action)
    {
        MQTT::publish('tasks/' . $action, json_encode(['task_id' => $taskId]));
    }
}
