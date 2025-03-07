<x-app-layout>
    <x-slot name="header">
        <div class="display:flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de control') }}
            </h2>

        </div>
    </x-slot>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                let errorMessages = `<ul>`;
                @foreach (session('error')->all() as $error)
                    errorMessages += `<li class="text-sm">• {{ $error }}</li>`;
                @endforeach
                errorMessages += `</ul>`;

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessages,
                });
            @endif
        });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


                <div id="searchResults"></div>
                <h2 class="text-xl font-bold mb-4"></h2>

                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <!-- Menú de pestañas -->
                    <ul class="text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg flex dark:divide-gray-600 dark:text-gray-400"
                        id="tabs">
                        <li class="w-full">
                            <button data-tab="eventos"
                                class="tab-button active inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                Eventos
                            </button>
                        </li>
                        <li class="w-full">
                            <button data-tab="organizadores"
                                class="tab-button inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                Organizadores
                            </button>
                        </li>
                        <li class="w-full">
                            <button data-tab="foros"
                                class="tab-button inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                Foros
                            </button>
                        </li>
                        <li class="w-full">
                            <button data-tab="usuarios"
                                class="tab-button inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                Usuarios
                            </button>
                        </li>
                    </ul>

                    <div class="border-t border-gray-200 dark:border-gray-600">
                        <!--Eventos-->
                        <div id="eventos" class="tab-content  p-4 bg-white rounded-lg dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">Eventos</h2>
                                <input type="text" id="searchInputEvento" class="border rounded p-2 w-full"
                                    placeholder="Buscar...">
                                <button id='crear_evento'
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                                    onclick="CrearEvento()">Crear</button>
                            </div>
                            <ul id="eventos-lista" class="text-gray-500 dark:text-gray-400">
                                @foreach ($eventos as $evento)
                                    @foreach ($evento->horario as $horario)
                                        <li class="cardEvento block mb-2  p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                                            data-title="{{ strtolower($evento->title) }}"
                                            data-start-date="{{ strtolower($evento->start_date) }}"
                                            data-end-date="{{ strtolower($evento->end_date) }}"
                                            data-sede="{{ strtolower($evento->foro->sede) }}"
                                            data-foro="{{ strtolower($evento->foro->nombre) }}"
                                            data-organizador="{{ strtolower($evento->organizador->nombre) }}"
                                            data-tipo-evento="{{ strtolower($evento->tipo_evento) }}">
                                            <div class="flex justify-between items-center">
                                                <div class="flex justify-between">
                                                    <strong>ID: </strong><span>{{ $evento->id }}</span>
                                                    <div class="flex items-stretch">

                                                        <div class="flex flex-col">
                                                            <div>
                                                                <strong>Titulo
                                                                    :</strong><span>{{ $evento->title }}</span>
                                                            </div>
                                                            <div>
                                                                <strong>Tipo de evento
                                                                    :</strong><span>{{ $evento->tipo_evento }}</span>
                                                            </div>
                                                            <div>
                                                                <strong>Organizador
                                                                    :</strong><span>{{ $evento->organizador->nombre }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-col">

                                                            <div>
                                                                <strong>Fecha de inicio :
                                                                </strong><span>{{ $horario->start_date }}</span>
                                                            </div>
                                                            <div>
                                                                <strong>fecha de cierre :
                                                                </strong><span>{{ $horario->end_date }}</span>
                                                            </div>


                                                        </div>
                                                        <div class="flex flex-col">
                                                            <div>
                                                                <strong>Sede :
                                                                </strong><span>{{ $evento->foro->sede }}</span>
                                                            </div>
                                                            <div>
                                                                <strong>Foro :
                                                                </strong><span>{{ $evento->foro->nombre }}</span>
                                                            </div>

                                                        </div>
                                                        <div class="flex flex-col">

                                                            <div>
                                                                <strong>Notas CTA :
                                                                </strong><span>{{ $evento->notas_cta }}</span>
                                                            </div>
                                                            <div>
                                                                <strong>Notas
                                                                    generales:</strong><span>{{ $evento->notas_generales }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="space-x-2 flex justify-between items-center">
                                                    <button id="editarEvento"
                                                        onclick="EditarEvento({{ $evento->id }}, 
                                                        `{{ addslashes($evento->organizador->id) }}`,
                                                        `{{ addslashes($evento->foro->id) }}`,
                                                        `{{ addslashes($evento->foro->sede) }}`,
                                                        `{{ addslashes($evento->title) }}`,
                                                        `{{ addslashes($horario->start_date) }}`,
                                                        `{{ addslashes($horario->end_date) }}`,
                                                        `{{ addslashes($horario->start_hour) }}`,
                                                        `{{ addslashes($horario->end_hour) }}`,
                                                        
                                                        `{{ addslashes($evento->tipo_evento) }}`,
                                                        `{{ addslashes($evento->notas_generales) }}`,
                                                        `{{ addslashes($evento->notas_cta) }}`)"
                                                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </button>
                                                    <form id="deleteForm-evento-{{ $evento->id }}"
                                                        action="{{ route('welcome.destroy', $evento->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDeleteEvento({{ $evento->id }})"
                                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </li>
                                    @endforeach
                                @endforeach

                            </ul>
                            <div id="paginacionEventos" class="flex justify-center mt-4 space-x-2"></div>
                            <p id="mensajeSinResultados" class="text-red-500 text-center hidden">No hay resultados.</p>
                            <p id="contadorEventos" class="mb-2 text-gray-700"></p>
                        </div>


                        <!-- Organizadores -->
                        <div id="organizadores" class="tab-content hidden p-4 bg-white rounded-lg dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">Organizadores</h2>
                                <input type="text" id="searchInputOrganizador" class="border rounded p-2 w-full"
                                    placeholder="Buscar...">
                                <button id='crear_organizador' onclick="opencrearModalOrganizadorEditar()"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Crear</button>
                            </div>
                            <ul id="organizadores-lista" class="text-gray-500 dark:text-gray-400">

                                @foreach ($organizadores as $organizador)
                                    <li class="cardOrganizador block mb-2  p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 "
                                        data-organizador-nombre="{{ strtolower($organizador->nombre) }}"
                                        data-organizador-telefono="{{ strtolower($organizador->telefono) }}">
                                        <div class="flex justify-between items-center">
                                            <strong>ID: </strong><span>{{ $organizador->id }}</span>
                                            <strong>Nombre: </strong><span>{{ $organizador->nombre }}</span>
                                            <strong>telefono: </strong><span>{{ $organizador->telefono }}</span>
                                            <div class="space-x-2 flex justify-between items-center">
                                                <button
                                                    onclick="openEditModalOrganizadorEditar({{ $organizador->id }}, `{{ addslashes($organizador->nombre) }}`, `{{ addslashes($organizador->telefono) }}`)"
                                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </button>
                                                <form id="deleteForm-organizador-{{ $organizador->id }}"
                                                    action="{{ route('organizador.destroy', $organizador->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDeleteOrganizador({{ $organizador->id }})"
                                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                            <div id="paginacionOrganizador" class="flex justify-center mt-4 space-x-2"></div>
                            <p id="mensajeSinResultadosOrganizador" class="text-red-500 text-center hidden">No hay
                                resultados.</p>
                            <p id="contadorOrganizadores" class="mb-2 text-gray-700"></p>
                        </div>
                        <!-- foros -->

                        <div id="foros" class="tab-content hidden p-4 bg-white rounded-lg dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">Foros</h2>
                                <input type="text" id="searchInputForo" class="border rounded p-2 w-full"
                                    placeholder="Buscar...">
                                <button id='crear_foro' onclick="opencrearModalForo()"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Crear</button>
                            </div>
                            <div id="search-results"></div>
                            <ul id="foros-lista" class="text-gray-500 dark:text-gray-400">
                                @foreach ($foros as $foro)
                                    <li class="cardForo block mb-2 p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                                        data-foro-nombre="{{ strtolower($foro->nombre) }}"
                                        data-foro-sede="{{ strtolower($foro->sede) }}">
                                        <div class="flex justify-between items-center">
                                            <strong>ID: </strong><span>{{ $foro->id }}</span>
                                            <strong>Nombre: </strong><span>{{ $foro->nombre }}</span>
                                            <strong>Sede: </strong><span>{{ $foro->sede }}</span>

                                            <div class="space-x-2 flex justify-between items-center">
                                                <button
                                                    onclick="openEditModalForoEditar({{ $foro->id }}, '{{ $foro->nombre }}', '{{ $foro->sede }}')"
                                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </button>
                                                <form id="deleteForm-foro-{{ $foro->id }}"
                                                    action="{{ route('foro.destroy', $foro->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDeleteForo({{ $foro->id }})"
                                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                            <p id="contadorForos" class="text-gray-500">Total foros: 0</p>
                            <p id="mensajeSinResultadosForo" class="text-red-500 text-center hidden">No hay
                                resultados.</p>
                            <div id="paginacionForo" class="flex justify-center space-x-2 mt-4"></div>
                        </div>


                        <!-- usuarios -->
                        <div id="usuarios" class="tab-content hidden p-4 bg-white rounded-lg dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">Usuarios</h2>
                                <input type="text" id="searchInputUser" class="border rounded p-2 w-full"
                                    placeholder="Buscar...">
                                <button id='crear_usuario' onclick="openCrearModalUsuario()"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Crear</button>
                            </div>
                            <ul id="usuarios-lista" class="text-gray-500 dark:text-gray-400">

                                @foreach ($users as $user)
                                    <li class="cardUser block mb-2 p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                                        data-user-id="{{ strtolower($user->id) }}"
                                        data-user-nombre="{{ strtolower($user->name) }}"
                                        data-user-codigo="{{ strtolower($user->codigo) }}"
                                        data-user-email="{{ strtolower($user->email) }}"
                                        data-user-telefono="{{ strtolower($user->telefono) }}">
                                        <div class="flex justify-between items-center">
                                            <strong>ID: </strong><span>{{ $user->id }}</span>
                                            <strong>Nombre: </strong><span>{{ $user->name }}</span>
                                            <strong>codigo: </strong><span>{{ $user->codigo }}</span>
                                            <strong>Email: </strong><span>{{ $user->email }}</span>
                                            <strong>Telefono: </strong><span>{{ $user->telefono }}</span>

                                            <div class="space-x-2 flex justify-between items-center">
                                                <button onclick="openEditarModalUsuario({{($user->id) }},
                                                        `{{ addslashes($user->name) }}`,
                                                        `{{ addslashes($user->codigo) }}`,
                                                        `{{ addslashes($user->telefono) }}`,
                                                        `{{ addslashes($user->email) }}`)"
                                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </button>
                                                <form id="deleteForm-usuario{{ $user->id }}"
                                                    action="{{ route('usuario.destroy', $user->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDeleteUsuario({{ $user->id }})"
                                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </li>
                                @endforeach

                            </ul>
                            <p id="contadorUsuarios" class="text-gray-500">Total foros: 0</p>
                            <p id="mensajeSinResultadosUsuario" class="text-red-500 text-center hidden">No hay
                                resultados.
                            </p>
                            <div id="paginacionUsuario" class="flex justify-center space-x-2 mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
       
    <!-- Modales foro-->
    @include('modales.editarForo')
    @include('modales.crearForo')

    <!--Modales organizadores-->
    @include('modales.editarOrganizador')
    @include('modales.crearOrganizador')

    <!-- modales para eventos-->
    @include('modales.crearEvento')
    @include('modales.editarEvento')

    <!-- modales para usuarios-->
    @include('modales.crearUsuario')
    @include('modales.editarUsuario')
</div>
</div>

    <!-- Script para cambiar las pestañas sin ocultar el menú -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remover clase activa de todos los botones y ocultar contenido
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Activar la pestaña seleccionada
                    const target = document.getElementById(this.getAttribute('data-tab'));
                    target.classList.remove('hidden');
                    this.classList.add('active');
                });
            });
        });
    </script><!-- Script para cambiar las pestañas sin ocultar el menú -->
    <!--Paginacion y busqueda eventos-->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itemsPerPage = 5; // Eventos por página
            let currentPage = 1; // Página actual
            const eventosLista = document.getElementById("eventos-lista");
            const paginacion = document.getElementById("paginacionEventos");
            const searchInput = document.getElementById("searchInputEvento");
            const contadorEventos = document.getElementById("contadorEventos");
            let eventos = Array.from(eventosLista.getElementsByClassName("cardEvento"));

            function actualizarContador(eventosFiltrados) {
                contadorEventos.textContent = `Total eventos: ${eventosFiltrados.length}`;
            }

            function mostrarPagina(page, eventosFiltrados) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                eventos.forEach(evento => evento.style.display = 'none');
                eventosFiltrados.slice(start, end).forEach(evento => evento.style.display = 'block');

                actualizarContador(eventosFiltrados);
            }

            function crearBotonesPaginacion(eventosFiltrados) {
                paginacion.innerHTML = "";
                const totalPages = Math.ceil(eventosFiltrados.length / itemsPerPage);

                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement("button");
                    button.innerText = i;
                    button.classList.add("px-3", "py-1", "rounded", "border", "border-gray-300",
                        "hover:bg-gray-200", "mx-1");
                    if (i === currentPage) {
                        button.classList.add("bg-blue-500", "text-white");
                    }
                    button.addEventListener("click", function() {
                        currentPage = i;
                        mostrarPagina(currentPage, eventosFiltrados);
                        crearBotonesPaginacion(eventosFiltrados);
                    });
                    paginacion.appendChild(button);
                }
            }

            function buscarEventos() {
                const searchQuery = searchInput.value.toLowerCase();

                let eventosFiltrados = eventos.filter(evento => {
                    const buscarTitle = evento.getAttribute('data-title');
                    const buscarStartDate = evento.getAttribute('data-start-date');
                    const buscarEndDate = evento.getAttribute('data-end-date');
                    const buscarSede = evento.getAttribute('data-sede');
                    const buscarForo = evento.getAttribute('data-foro');
                    const buscarOrganizador = evento.getAttribute('data-organizador');
                    const buscarTipoEvento = evento.getAttribute('data-tipo-evento');

                    return buscarTitle.includes(searchQuery) || buscarStartDate.includes(searchQuery) ||
                        buscarEndDate.includes(searchQuery) ||
                        buscarTipoEvento.includes(searchQuery) || buscarSede.includes(searchQuery) ||
                        buscarForo.includes(searchQuery) ||
                        buscarOrganizador.includes(searchQuery);
                });

                // Si no hay resultados, mostrar todo para evitar dejar solo una página
                if (eventosFiltrados.length === 0) {
                    mensajeSinResultados.classList.remove("hidden");
                    eventosLista.classList.add("hidden"); // Ocultar eventos
                    paginacion.innerHTML = ""; // Ocultar paginación
                    actualizarContador([]); // Mostrar contador en 0
                    return;
                } else {
                    mensajeSinResultados.classList.add("hidden");
                    eventosLista.classList.remove("hidden");
                }

                // Reiniciar la paginación y actualizarla
                currentPage = 1;
                mostrarPagina(currentPage, eventosFiltrados);
                crearBotonesPaginacion(eventosFiltrados);
            }

            // Inicializar con todos los eventos
            mostrarPagina(currentPage, eventos);
            crearBotonesPaginacion(eventos);
            actualizarContador(eventos);

            // Evento de búsqueda
            searchInput.addEventListener('input', buscarEventos);
        });
    </script>
    <!--Paginacion y busqueda organizadores-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itemsPerPage = 5;
            let currentPage = 1;
            const organizadoresLista = document.getElementById("organizadores-lista");
            const paginacionOrganizador = document.getElementById("paginacionOrganizador");
            const searchInput = document.getElementById("searchInputOrganizador");
            const contadorOrganizadores = document.getElementById("contadorOrganizadores");
            const mensajeSinResultados = document.getElementById("mensajeSinResultadosOrganizador");
            let organizadores = Array.from(organizadoresLista.getElementsByClassName("cardOrganizador"));

            function actualizarContador(organizadoresFiltrados) {
                contadorOrganizadores.textContent = `Total organizadores: ${organizadoresFiltrados.length}`;
            }

            function mostrarPagina(page, organizadoresFiltrados) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                organizadores.forEach(org => org.style.display = 'none');
                organizadoresFiltrados.slice(start, end).forEach(org => org.style.display = 'block');

                actualizarContador(organizadoresFiltrados);
            }

            function crearBotonesPaginacion(organizadoresFiltrados) {
                paginacionOrganizador.innerHTML = "";
                const totalPages = Math.ceil(organizadoresFiltrados.length / itemsPerPage);

                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement("button");
                    button.innerText = i;
                    button.classList.add("px-3", "py-1", "rounded", "border", "border-gray-300",
                        "hover:bg-gray-200", "mx-1");
                    if (i === currentPage) {
                        button.classList.add("bg-blue-500", "text-white");
                    }
                    button.addEventListener("click", function() {
                        currentPage = i;
                        mostrarPagina(currentPage, organizadoresFiltrados);
                        crearBotonesPaginacion(organizadoresFiltrados);
                    });
                    paginacionOrganizador.appendChild(button);
                }
            }

            function buscarOrganizadores() {
                const searchQuery = searchInput.value.toLowerCase();

                let organizadoresFiltrados = organizadores.filter(org => {
                    const nombre = org.getAttribute('data-organizador-nombre');
                    const telefono = org.getAttribute('data-organizador-telefono');

                    return nombre.includes(searchQuery) || telefono.includes(searchQuery);
                });

                // Mostrar mensaje si no hay resultados
                if (organizadoresFiltrados.length === 0) {
                    mensajeSinResultados.classList.remove("hidden");
                    organizadoresLista.classList.add("hidden");
                    paginacionOrganizador.innerHTML = "";
                    actualizarContador([]);
                    return;
                } else {
                    mensajeSinResultados.classList.add("hidden");
                    organizadoresLista.classList.remove("hidden");
                }

                currentPage = 1;
                mostrarPagina(currentPage, organizadoresFiltrados);
                crearBotonesPaginacion(organizadoresFiltrados);
            }

            // Inicializar con todos los organizadores
            mostrarPagina(currentPage, organizadores);
            crearBotonesPaginacion(organizadores);
            actualizarContador(organizadores);

            // Evento de búsqueda
            searchInput.addEventListener('input', buscarOrganizadores);
        });
    </script>
    <!--Paginacion y busqueda foros-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itemsPerPage = 5;
            let currentPage = 1;
            const forosLista = document.getElementById("foros-lista");
            const paginacionForo = document.getElementById("paginacionForo");
            const searchInput = document.getElementById("searchInputForo");
            const contadorForos = document.getElementById("contadorForos");
            const mensajeSinResultados = document.getElementById("mensajeSinResultadosForo");
            let foros = Array.from(forosLista.getElementsByClassName("cardForo"));

            function actualizarContador(forosFiltrados) {
                contadorForos.textContent = `Total foros: ${forosFiltrados.length}`;
            }

            function mostrarPagina(page, forosFiltrados) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                foros.forEach(foro => foro.style.display = 'none');
                forosFiltrados.slice(start, end).forEach(foro => foro.style.display = 'block');

                actualizarContador(forosFiltrados);
            }

            function crearBotonesPaginacion(forosFiltrados) {
                paginacionForo.innerHTML = "";
                const totalPages = Math.ceil(forosFiltrados.length / itemsPerPage);

                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement("button");
                    button.innerText = i;
                    button.classList.add("px-3", "py-1", "rounded", "border", "border-gray-300",
                        "hover:bg-gray-200", "mx-1");
                    if (i === currentPage) {
                        button.classList.add("bg-blue-500", "text-white");
                    }
                    button.addEventListener("click", function() {
                        currentPage = i;
                        mostrarPagina(currentPage, forosFiltrados);
                        crearBotonesPaginacion(forosFiltrados);
                    });
                    paginacionForo.appendChild(button);
                }
            }

            function buscarForos() {
                const searchQuery = searchInput.value.toLowerCase();

                let forosFiltrados = foros.filter(foro => {
                    const nombre = foro.getAttribute('data-foro-nombre');
                    const sede = foro.getAttribute('data-foro-sede');

                    return nombre.includes(searchQuery) || sede.includes(searchQuery);
                });

                // Mostrar mensaje si no hay resultados
                if (forosFiltrados.length === 0) {
                    mensajeSinResultados.classList.remove("hidden");
                    forosLista.classList.add("hidden");
                    paginacionForo.innerHTML = "";
                    actualizarContador([]);
                    return;
                } else {
                    mensajeSinResultados.classList.add("hidden");
                    forosLista.classList.remove("hidden");
                }

                currentPage = 1;
                mostrarPagina(currentPage, forosFiltrados);
                crearBotonesPaginacion(forosFiltrados);
            }

            // Inicializar con todos los foros
            mostrarPagina(currentPage, foros);
            crearBotonesPaginacion(foros);
            actualizarContador(foros);

            // Evento de búsqueda
            searchInput.addEventListener('input', buscarForos);
        });
    </script>
    <!--Paginacion y busqueda usuarios-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itemsPerPage = 5;
            let currentPage = 1;
            const usuariosLista = document.getElementById("usuarios-lista");
            const paginacionUsuario = document.getElementById("paginacionUsuario");
            const searchInput = document.getElementById("searchInputUser");
            const contadorUsuarios = document.getElementById("contadorUsuarios");
            const mensajeSinResultados = document.getElementById("mensajeSinResultadosUsuario");
            let usuarios = Array.from(usuariosLista.getElementsByClassName("cardUser"));

            function actualizarContador(usuariosFiltrados) {
                contadorUsuarios.textContent = `Total usuarios: ${usuariosFiltrados.length}`;
            }

            function mostrarPagina(page, usuariosFiltrados) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                usuarios.forEach(user => user.style.display = 'none');
                usuariosFiltrados.slice(start, end).forEach(user => user.style.display = 'block');

                actualizarContador(usuariosFiltrados);
            }

            function crearBotonesPaginacion(usuariosFiltrados) {
                paginacionUsuario.innerHTML = "";
                const totalPages = Math.ceil(usuariosFiltrados.length / itemsPerPage);

                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement("button");
                    button.innerText = i;
                    button.classList.add("px-3", "py-1", "rounded", "border", "border-gray-300",
                        "hover:bg-gray-200", "mx-1");
                    if (i === currentPage) {
                        button.classList.add("bg-blue-500", "text-white");
                    }
                    button.addEventListener("click", function() {
                        currentPage = i;
                        mostrarPagina(currentPage, usuariosFiltrados);
                        crearBotonesPaginacion(usuariosFiltrados);
                    });
                    paginacionUsuario.appendChild(button);
                }
            }

            function buscarUsuarios() {
                const searchQuery = searchInput.value.toLowerCase();

                let usuariosFiltrados = usuarios.filter(user => {
                    const nombre = user.getAttribute('data-user-nombre') || "";
                    const codigo = user.getAttribute('data-user-codigo') || "";
                    const email = user.getAttribute('data-user-email') || "";
                    const telefono = user.getAttribute('data-user-telefono') || "";

                    return nombre.includes(searchQuery) || codigo.includes(searchQuery) || email.includes(
                        searchQuery) || telefono.includes(searchQuery);
                });

                // Mostrar mensaje si no hay resultados
                if (usuariosFiltrados.length === 0) {
                    mensajeSinResultados.classList.remove("hidden");
                    usuariosLista.classList.add("hidden");
                    paginacionUsuario.innerHTML = "";
                    actualizarContador([]);
                    return;
                } else {
                    mensajeSinResultados.classList.add("hidden");
                    usuariosLista.classList.remove("hidden");
                }

                currentPage = 1;
                mostrarPagina(currentPage, usuariosFiltrados);
                crearBotonesPaginacion(usuariosFiltrados);
            }

            // Inicializar con todos los usuarios
            mostrarPagina(currentPage, usuarios);
            crearBotonesPaginacion(usuarios);
            actualizarContador(usuarios);

            // Evento de búsqueda
            searchInput.addEventListener('input', buscarUsuarios);
        });
    </script>

    <!--confirmaciones de eliminacion-->
    <script>
        function confirmDeleteOrganizador(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-organizador-' + id).submit();
                }
            });
        }

        function confirmDeleteEvento(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-evento-' + id).submit();
                }
            });
        }

        function confirmDeleteForo(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-foro-' + id).submit();
                }
            });
        }

        function confirmDeleteUsuario(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-usuario-' + id).submit();
                }
            });
        }
    </script>

</x-app-layout>
