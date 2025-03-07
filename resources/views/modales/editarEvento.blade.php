<!-- Modal de Editar del Evento -->
<div class="modal fade" id="eventoEditarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <form id="formEditarEvento">

                    <p><strong>ID:</strong> <span id="editarEvento_id"></span></p>

                    <div class="mb-3">
                        <label for="edit_evento_titulo" class="form-label">titulo</label>
                        <input type="text" class="form-control" id="edit_evento_titulo">
                    </div>

                    <div class="mb-3">
                        <label for="edit_tipoEvento" class="form-label">Tipo de Evento</label>
                        <input type="text" class="form-control" id="edit_tipoEvento">
                    </div>

                    <div class="mb-3">
                        <label for="edit_evento_fecha_inicio" class="form-label">Fecha inicio </label>
                        <input type="date" class="form-control" id="edit_evento_fecha_inicio">
                    </div>
                    <div class="mb-3">
                        <label for="edit_evento_fecha_cierre" class="form-label">Fecha cierre </label>
                        <input type="date" class="form-control" id="edit_evento_fecha_cierre">
                    </div>

                    <strong>Horario</strong>
                    <div>
                        <label>Hora Inicio:</label>
                        <input type="time" id="edit_horaInicio" name="inicio" min="08:00" max="17:00"
                            class="form-control" required>

                        <span id="errorFecha"></span>

                        <label>Hora final:</label>
                        <input type="time" id="edit_horaFin" name="fin" min="09:00" max="18:00"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Organizador:</label>
                        <select name="edit_organizadores_id" id="edit_organizadores_id">
                            <option value="" disabled selected>Seleccione un organizador</option>
                            @foreach ($organizadores as $organizador)
                                <option value="{{ $organizador->id }}">{{ $organizador->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Dependencia:</label>
                        <select name="edit_dependencia" id="edit_dependencia">
                            <option value="" disabled selected>Seleccione un foro</option>
                            @foreach ($dependencias as $dependencia)
                                <option value="{{ $dependencia->sede }}">{{ $dependencia->sede }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Foro:</label>
                        <select name="edit_cede_modalE" id="edit_cede_modalE">
                            <option value="" disabled selected>Seleccione un foro</option>
                            @foreach ($foros as $foro)
                                <option value="{{ $foro->id }}" data-dependencia="{{ $foro->nombre }}">
                                    {{ $foro->nombre }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div class="mb-3">
                        <label for="edit_notasGen" class="form-label">Notas Generales</label>
                        <textarea class="form-control" id="edit_notasGen"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_notasCta" class="form-label">Notas CTA</label>
                        <textarea class="form-control" id="edit_notasCta"></textarea>
                    </div>
                    @auth
                        <p><strong>RESGISTRADOR:</strong> <span id="edit_evento_registrador">{{ Auth::user()->name }}</span>
                        </p>
                    @endauth

                    <button type="button" id="actualizarEvento" class="btn btn-primary">actualizar</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dependenciaSelect = document.getElementById("edit_dependencia");
            let foroSelect = document.getElementById("edit_cede_modalE");

            // Bloquear el select de foro al inicio
            foroSelect.disabled = false;

            dependenciaSelect.addEventListener("change", function() {
                let sede = this.value; // Obtener el valor de la sede seleccionada

                if (sede) {
                    foroSelect.disabled = false; // Desbloquear el select de foro

                    // Hacer petición AJAX para obtener los foros de la dependencia seleccionada
                    fetch(`/foros-dependencia/${sede}`)
                        .then(response => response.json())
                        .then(data => {
                            // Limpiar las opciones del select
                            foroSelect.innerHTML =
                                '<option value="" disabled selected>Seleccione un foro</option>';

                            // Agregar las nuevas opciones al select
                            data.forEach(foro => {
                                let option = document.createElement("option");
                                option.value = foro.id;
                                option.textContent = foro.nombre;
                                foroSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error("Error cargando los foros:", error));
                } else {
                    // Si no hay dependencia seleccionada, bloquear el select de foro
                    foroSelect.innerHTML = '<option value="" disabled selected>Seleccione un foro</option>';
                    foroSelect.disabled = true;
                }
            });
        });
    </script>
</div>
<!-- fin de modal editar-->
<script>
    /*function EditarEvento(evento_id) {
        let modalEditar = new bootstrap.Modal(document.getElementById('eventoEditarModal'));
        modalEditar.show();
    console.log(evento_id)
    }*/

    // Hacer la petición AJAX para obtener el rango de fechas del grupo
    function EditarEvento(id,
        organizador,
        foro,
        sede,
        title,
        start_date,
        end_date,
        start_hour,
        end_hour,
        tipo_evento,
        notas_generales,
        notas_cta,
    ) {

        console.log(id, title,
            start_date,
            end_date,
            start_hour,
            end_hour,
            tipo_evento,
            foro,

            notas_generales,
            notas_cta,
            organizador)
        // Llenamos los campos del modal con los datos obtenidos
        document.getElementById("editarEvento_id").innerText = id;
        document.getElementById("edit_evento_titulo").value = title;
        document.getElementById("edit_organizadores_id").value = organizador;
        document.getElementById("edit_cede_modalE").value = foro;
        document.getElementById("edit_dependencia").value = sede;
        document.getElementById("edit_evento_fecha_inicio").value = start_date;
        document.getElementById("edit_horaInicio").value = start_hour;
        document.getElementById("edit_evento_fecha_cierre").value = end_date
        document.getElementById("edit_horaFin").value = end_hour;

        document.getElementById("edit_tipoEvento").value = tipo_evento;
        document.getElementById("edit_notasCta").value = notas_cta;
        document.getElementById("edit_notasGen").value = notas_generales;
        //document.getElementById("evento_registrador").innerText = user;
        let modalEditar = new bootstrap.Modal(document.getElementById('eventoEditarModal'));
        modalEditar.show();
    }

    $('#actualizarEvento').off('click').on('click', function(e) {
        let errores = [];
        let id = document.getElementById("editarEvento_id").innerText
        let updatedEvent = {
            '_token': $('input[name=_token]').val(),
             //id : document.getElementById("editarEvento_id").value,
            foros_id: document.getElementById("edit_cede_modalE").value,
            organizadors_id: document.getElementById("edit_organizadores_id").value,
            allDay: false,
            title: document.getElementById("edit_evento_titulo").value,
            start_date: $('#edit_evento_fecha_inicio').val(),
            start_hour: $('#edit_horaInicio').val(),
            end_date: $('#edit_evento_fecha_cierre').val(),
            end_hour: $('#edit_horaFin').val(),

            tipo_evento: document.getElementById("edit_tipoEvento").value,
            notas_generales: document.getElementById("edit_notasCta").value,
            notas_cta: document.getElementById("edit_notasGen").value,
            sede: document.getElementById("edit_cede_modalE").value,

            registrador: document.getElementById("evento_registrador").innerText,
        };
        console.log(id)
        e.preventDefault();
        if (!updatedEvent.foros_id) errores.push("Seleccione una foro.");
        if (!updatedEvent.title || updatedEvent.title.trim() === '') errores.push("El título es obligatorio.");
        if (!updatedEvent.start_date) errores.push("Debe seleccionar una fecha de inicio.");
        if (!updatedEvent.end_date) errores.push("Debe seleccionar una fecha de fin.");
        if (updatedEvent.start_date > updatedEvent.end_date) errores.push(
            "La fecha u hora de inicio no puede ser mayor que la de fin.");
        if (!updatedEvent.organizadors_id) errores.push("Seleccione un organizador.");
        if (!updatedEvent.tipo_evento) errores.push("Seleccione el tipo de evento.");

        // Mostrar errores si existen
        if (errores.length > 0) {
            let mensajeError = errores.join("\n");
            alert("Corrige los siguientes errores:\n" +
                mensajeError);
            return;
        }
        if (errores.length > 0) {
            alert("⚠️ Corrige los siguientes errores antes de actualizar:\n\n" +
                errores.join("\n"));
            return;
        }



        $.ajax({
            url: "{{ route('calendario.update', '') }}" + '/' +id, // Asegúrate de pasar el ID del evento
            method: 'PATCH',
            dataType: 'json',
            data: updatedEvent,
            success: function(response) {
                console.log(response.message);
                setTimeout(() => {
                    document.location.reload();
                }, 200);
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.error
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'Ocurrió un problema al intentar guardar el evento.'
                    });
                }
                console.log(xhr.responseJSON);
            }
        });

    })
</script>
