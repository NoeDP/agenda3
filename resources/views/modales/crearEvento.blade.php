<!-- Modal Creacion-->
@include('importaciones.importaciones')

<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear evento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="formulario" method="POST" id="createEventoModal">
                    @csrf

                    <label for="create_title">Titulo</label>
                    <input type="text" class="form-control" id="create_title" name="create_title" required>
                    <span id="titleError" class="text-danger"></span>

                    <label>fecha de inicio:</label>
                    <input type="date" id="create_fechaInicio" name="inicio" class="form-control" required>

                    <span id="errorFecha"></span>

                    <label>fecha de cierre:</label>
                    <input type="date" id="create_fechaFin" name="fin" class="form-control"
                        aria-required="false">

                    <strong>Horario</strong>
                    <div>
                        <label>Hora Inicio:</label>
                        <input type="time" id="create_horaInicio" name="inicio" min="08:00" max="17:00"
                            class="form-control" required>

                        <span id="errorFecha"></span>

                        <label>Hora final:</label>
                        <input type="time" id="create_horaFin" name="fin" min="09:00" max="18:00"
                            class="form-control" required>
                    </div>



                    <div class="mb-3">
                        <label>Organizador:</label>
                        <select name="create_organizadores" id="create_organizadores" required>
                            <option value="" disabled selected>Seleccione un organizador</option>
                            @foreach ($organizadores as $organizador)
                                <option value="{{ $organizador->id }}">{{ $organizador->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Dependencia:</label>
                        <select name="create_dependencia" id="create_dependencia" required>
                            <option value="" disabled selected>Seleccione una dependencia</option>
                            @foreach ($dependencias as $dependencia)
                                <option value="{{ $dependencia->sede }}">{{ $dependencia->sede }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>foro:</label>
                        <select name="create_sede" id="create_sede" required>
                            <option value="" disabled selected>Seleccione un foro</option>
                            @foreach ($foros as $foro)
                                <option value="{{ $foro->id }}">{{ $foro->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="create_notasGen">Notas generales</label>
                    <input type="text" class="form-control" id="create_notasGen" name="create_notasGen">

                    <label for="create_notasCta">Notas CTA</label>
                    <input type="text" class="form-control" id="create_notasCta" name="create_notasCta">

                    <label for="create_tipoEvento">Tipo de evento</label>
                    <input type="text" class="form-control" id="create_tipoEvento" name="create_tipoEvento" required>

                    @auth
                        <p><strong>RESGISTRADOR:</strong> <span id="evento_registrador">{{ Auth::user()->name }}</span></p>
                        <span type="hidden" id="evento_registradorId">{{ Auth::user()->id }}</span></p>
                    @endauth
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="guardarEvento" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dependenciaSelect = document.getElementById("create_dependencia");
            let foroSelect = document.getElementById("create_sede");

            // Bloquear el select de foro al inicio
            foroSelect.disabled = true;

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
<!--fin de modal creacion-->


<script>
    function CrearEvento() {
        let eventoModal = new bootstrap.Modal(document.getElementById('eventoModal'));
        eventoModal.show();  
        
        }
        
        $('#guardarEvento').click(function(e) {
            let form =$('#createEventoModal').serialize()
            console.log(form)
            //asignacion de datos
            e.preventDefault();
            let errores = [];


            //var inicio = $('#create_fechaInicio').val() + " " + $('#create_horaInicio').val()
            //var fin = ($('#create_fechaFin').val() ? $('#create_fechaFin').val() + " " + $('#create_horaFin').val() : $('#create_fechaInicio').val() + " " + $('#create_horaFin').val())

            let create_data = {
                '_token': $('input[name=_token]').val(),
                foros_id: $('#create_sede').val(),
                title: $('#create_title').val(),
                start_date: $('#create_fechaInicio').val(),
                start_hour:$('#create_horaInicio').val(),
                allDay: false,
                end_date: $('#create_fechaFin').val(),
                end_hour: $('#create_horaFin').val(),
                organizadors_id: $('#create_organizadores').val(),
                notas_generales: $('#create_notasGen').val(),
                notas_cta: $('#create_notasCta').val(),
                //user: document.getElementById("evento_registradorId").innerText,
                tipo_evento: $('#create_tipoEvento').val(),
            }
            //console.log($("#createEventoModal").serialize())


            if (!create_data.tipo_evento) errores.push("Seleccione el tipo de evento.");
            if (!create_data.foros_id) errores.push("Seleccione un foro.");
            if (!create_data.organizadors_id) errores.push("Seleccione un organizador.");
            if (!create_data.title || create_data.title.trim() === '') errores.push("El título es obligatorio.");
            if (create_data.start_date === undefined) errores.push("Debe seleccionar una fecha de inicio.");
            if ($('#create_horaInicio') === undefined) errores.push("Debe seleccionar una hora de inicio.");
            if ($('#create_horaFin') === undefined) errores.push("Debe seleccionar una hora de fin.");
            if (!create_data.end_date) errores.push("Debe seleccionar una fecha de fin.");
            if (create_data.start_date > create_data.end_date) errores.push(
                "error al registrar la fecha , verifica que la fecha de inicio no sea menor al cierre."
                );
            if (create_data.start_hour > create_data.end_hour) errores.push(
                "error al registrar la fecha , verifica que la hora de inicio no sea menor al cierre."
                );

            let horaInicio = new Date($('#create_horaInicio'));
            let horaFinal = new Date($('#create_horaFin'));
            let fecha = new Date($('#create_fechaFin')).getFullYear();
            console.log(fecha)
            if (horaInicio >= horaFinal) errores.push(
                "La hora de inicio no puede ser igual o mayor que la de fin.");

            //if (!create_data.organizador_id) errores.push("Seleccione un organizador.");
            if (!create_data.tipo_evento) errores.push(
                "Seleccione el tipo de evento.");


            // Mostrar errores si existen
            if (errores.length > 0) {
                let mensajeError = errores.join("\n");
                alert("Corrige los siguientes errores:\n" + mensajeError);
                return;
            }

            $.ajax({
                url: "{{ route('welcome.store') }}",
                method: 'POST',
                dataType: 'json',
                data: create_data,
                success: function(response) {
                    //eventoModal.hide();
                    console.log(response);

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

        });
        
</script>
