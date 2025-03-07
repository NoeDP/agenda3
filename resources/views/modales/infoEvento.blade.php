<!-- Modal info-->
<div class="modal fade" id="eventoInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="evento_id"></span></p>
                <p><strong>Titulo:</strong> <span id="evento_titulo"></span></p>

                <p><strong>Fecha de inicio:</strong> <span id="evento_fechaInicio"></span></p>
                <p><strong>Fecha de cierre:</strong> <span id="evento_fechaFin"></span></p>

                <p><strong>Tipo de evento:</strong> <span id="infoTipoEvento"></span></p>
                <p><strong>Organizador:</strong> <span id="infoOrganizadorNombre"></span></p>

                <p><strong>Telefono:</strong> <span id="infoOrganizadorTelefono"></span></p>
                <p><strong>Dependencia:</strong> <span id="infoDependencia"></span></p>

                <p><strong>Foro:</strong> <span id="infoForo"></span></p>
                <p><strong>Notas CTA:</strong> <span id="infoNotasCta"></span></p>

                <p><strong>Notas generales:</strong> <span id="infoNotasGen"></span></p>
                <p><strong>Registrador:</strong> <span id="infoRegistrador"></span></p>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-secondary" id="btnEditarEvento" >Editar Evento</button>
                <button type="button" id="borrarEvento" class="btn btn-primary" onclick="borrarEvento()">Borrar</button>
            </div>
        </div>
    </div>
</div>
<!--fin de modal info-->