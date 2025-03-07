<div class="modal fade" id="crearModalOrganizador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">crear organizador</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('organizador.store') }} " method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="createOrganizadorId" id="editOrganizadorId">

                    <div class="mb-3">
                        <label for="OrganizadorNombre" class="block font-medium">Nombre</label>
                        <input type="text" name="OrganizadorNombre" id="OrganizadorNombre"
                            class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-3">
                        <label for="OrganizadorTelefono" class="block font-medium">Telefono</label>
                        <input type="text" name="OrganizadorTelefono" maxlength="10" id="OrganizadorTelefono"
                            class="w-full p-2 border rounded"
                            onKeypress="if(!(event.charCode >= 48 && event.charCode <= 57)) event.preventDefault()"
                            required>
                    </div>

                    <div class="flex justify-end sp ace-x-2">
                        <button type="button" onclick="closeCrearModalOrganizador()"
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
    function opencrearModalOrganizadorEditar() {
        let organizadorModal = new bootstrap.Modal(document.getElementById('crearModalOrganizador'));
        organizadorModal.show();
    }

    function closeCrearModalOrganizador() {
        document.getElementById("").classList.add("hidden");
    }
</script>
