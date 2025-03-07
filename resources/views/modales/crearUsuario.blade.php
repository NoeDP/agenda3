<!-- Modal -->
<div class="modal fade" id="crearModalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('usuario.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="name" class="block font-medium">Nombre</label>
                        <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="block font-medium">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="w-full p-2 border rounded"
                            maxlength="10" required
                            onKeypress=" if (!(event.charCode >= 48 && event.charCode <= 57)) event.preventDefault()">
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="block font-medium">Código</label>
                        <input type="text" name="codigo" id="codigo" class="w-full p-2 border rounded"
                            maxlength="8" required
                            onKeypress=" if (!(event.charCode >= 48 && event.charCode <= 57)) event.preventDefault()">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="block font-medium">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="block font-medium">Contraseña</label>
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="block font-medium">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full p-2 border rounded" required>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeCrearModalUsuario()" class="btn btn-secondary"
                            data-bs-dismiss="modal">cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Scripts para manejar el modal -->
<script>
    function openCrearModalUsuario() {
        let userModal = new bootstrap.Modal(document.getElementById('crearModalUsuario'));
        userModal.show();
    }

    function closeCrearModalUsuario() {
        document.getElementById("crearModalUsuario").classList.add("hidden");
    }
</script>
