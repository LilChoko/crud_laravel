@extends('adminlte::page')

@section('title', 'CRUD de Tareas')

@section('content_header')
    <h1>Tareas por hacer</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Nueva Tarea</a>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>

        @if (Session::get('success'))
            <div class="alert alert-success mt-2">
                <strong> {{ Session::get('success') }} </strong> <br><br>
            </div>
        @endif

        <div class="col-12 mt-4">
            <table class="table table-bordered">
                <tr class="bg-secondary">
                    <th>Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Alumnos</th>
                    <th>Acción</th>
                </tr>
                @foreach ($tasks as $task)
                    <tr>
                        <td class="fw-bold">{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td><span class="badge bg-warning fs-6">{{ $task->status }}</span></td>
                        <td>
                            @foreach ($task->alumnos as $alumno)
                                <span>{{ $alumno->nombre }}</span><br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Editar</a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $tasks->links() }}
        </div>

    </div>
@endsection
