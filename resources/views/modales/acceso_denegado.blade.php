<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto text-center py-12">
                    <h1 class="text-3xl font-semibold text-red-600">Ruta no encontrada</h1>
                    <p class="mt-4 text-lg text-gray-700">No se ha encontrado la ruta solicitada.</p>
                    <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-3 text-white bg-blue-500 hover:bg-blue-700 rounded-lg">
                        Regresar al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
