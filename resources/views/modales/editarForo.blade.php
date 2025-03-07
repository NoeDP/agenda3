<!-- Modal -->
  <div class="modal fade" id="editModalForo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Foro</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('foro.update') }} " method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="editForoId" id="editForoId">
    
                <div class="mb-3">
                    <label for="editForoNombre" class="block font-medium">Nombre</label>
                    <input type="text" name="editForoNombre" id="editForoNombre" class="w-full p-2 border rounded">
                </div>
    
                <div class="mb-3">
                    <label for="editForoSede" class="block font-medium">Sede</label>
                    <select name="editForoSede" id="editForoSede">
                        <option value="" disabled selected>Selecione una dependencia</option>
                        <option value="La Normal">La Normal</option>
                        <option value="Belenes">Belenes</option>
                        <option value="Belenes Aulas">Belenes Aulas</option>
                    </select>
                </div>
    
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModalForo()"
                        class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                    <button type="submit"
                        class="btn btn-primary">Guardar</button>
                </div>
            </form>
            
        </div>
      </div>
    </div>
  </div>

<script>
    function openEditModalForoEditar(id, nombre, sede) {
        let foroEditarModal = new bootstrap.Modal(document.getElementById('editModalForo'));
        foroEditarModal.show();
        document.getElementById("editForoId").value = id;
        document.getElementById("editForoNombre").value = nombre;
        document.getElementById("editForoSede").value = sede;
    }

    function closeEditModalForo() {
        document.getElementById("editModalForo").classList.add("hidden");
    }
</script>
