<!-- Modal -->
  <div class="modal fade" id="editModalOrganizador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">editar Organizador</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('organizador.update') }} " method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="editOrganizadorID" id="editOrganizadorID">
    
                <div class="mb-3">
                    <label for="editOrganizadorNombre" class="block font-medium">Nombre</label>
                    <input type="text" name="editOrganizadorNombre" id="editOrganizadorNombre" class="w-full p-2 border rounded">
                </div>
    
                <div class="mb-3">
                    <label for="editOrganizadorTelefono" class="block font-medium">Telefono</label>
                    <input type="text" name="editOrganizadorTelefono" id="editOrganizadorTelefono" onKeypress=" if (!(event.charCode >= 48 && event.charCode <= 57)) event.preventDefault()" class="w-full p-2 border rounded">
                </div>
    
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModalOrganizador()"
                        class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit"
                        class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>

<script>
    function openEditModalOrganizadorEditar(id, nombre, telefono) {
        let organizadorEditarModal = new bootstrap.Modal(document.getElementById('editModalOrganizador'));
        organizadorEditarModal.show();
        document.getElementById("editOrganizadorID").value = id;
        document.getElementById("editOrganizadorNombre").value = nombre;
        document.getElementById("editOrganizadorTelefono").value = telefono;
        document.getElementById("").classList.remove("hidden");
        console.log(id + " " + nombre + " " + telefono)
        document.getElementById("editOrganizadorID").value = id;
    }

    function closeEditModalOrganizador() {
        document.getElementById("editModalOrganizador").classList.add("hidden");
    }
</script>
