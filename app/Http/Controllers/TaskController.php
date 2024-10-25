<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpMqtt\Client\Facades\MQTT;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::paginate(5);
        return view('index', compact('tasks'));
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
