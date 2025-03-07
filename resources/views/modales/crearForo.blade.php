
  <!-- Modal -->
  <div class="modal fade" id="crearModalForo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">crear foro</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('foro.store') }} " method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="createForoId" id="createForoId">
    
                <div class="mb-3">
                    <label for="foroNombre" class="block font-medium">Nombre</label>
                    <input type="text" name="foroNombre" id="foroNombre" class="w-full p-2 border rounded" required>
                </div>
    
                <div class="mb-3">
                    <label for="foroSede" class="block font-medium">Sede</label>
                    <select name="foroSede" id="foroSede" required>
                        <option value="" disabled selected>Selecione una dependencia</option>
                        <option value="La Normal">La Normal</option>
                        <option value="Belenes">Belenes</option>
                        <option value="Belenes Aulas">Belenes Aulas</option>
                    </select>
                </div>
    
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closecrearModalOForo()"
                    class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                    <button type="submit"
                        class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>
<!-- Script para capturar informacion de crearModalForo para foro -->
<script>
    function opencrearModalForo() {
        document.getElementById("crearModalForo").classList.remove("hidden");
        let foroModal = new bootstrap.Modal(document.getElementById('crearModalForo'));
        foroModal.show();
    }

    
</script>
