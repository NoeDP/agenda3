
<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editarModalUsuario" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarModalLabel">Editar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('usuario.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="editNombreUser" class="block font-medium">Nombre</label>
                        <input type="text" name="editNombreUser" id="editNombreUser" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-3">
                        <label for="editTelefonoUser" class="block font-medium">Telefono</label>
                        <input type="text" name="editTelefonoUser" id="editTelefonoUser" class="w-full p-2 border rounded" maxlength="10" required
                            onKeypress=" if (!(event.charCode >= 48 && event.charCode <= 57)) event.preventDefault()">
                    </div>

                    <div class="mb-3">
                        <label for="editCodigoUser" class="block font-medium">Código</label>
                        <input type="text" name="editCodigoUser" id="editCodigoUser" class="w-full p-2 border rounded" maxlength="8" required
                            onKeypress=" if (!(event.charCode >= 48 && event.charCode <= 57)) event.preventDefault()">
                    </div>

                    <div class="mb-3">
                        <label for="editEmailUser" class="block font-medium">Email Electrónico</label>
                        <input type="email" name="editEmailUser" id="editEmailUser" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="block font-medium">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="block font-medium">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEditarModalUsuario()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Scripts para manejar el modal -->
<script>
    function openEditarModalUsuario(id,name,codigo,telefono,email){
        // Aquí puedes cargar los datos del usuario mediante AJAX si es necesario
        console.log(id,name,telefono,codigo,email)
        document.getElementById("id").value = id;
        document.getElementById("editNombreUser").value = name;
        document.getElementById("editCodigoUser").value = codigo;
        document.getElementById("editEmailUser").value = email;
        document.getElementById("editTelefonoUser").value = telefono;

        
        let userModal = new bootstrap.Modal(document.getElementById('editarModalUsuario'));
        userModal.show();
    }
</script>
