<form action="{{ route('alumnos.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del Alumno" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Registrar Alumno</button>
    </div>
</form>
