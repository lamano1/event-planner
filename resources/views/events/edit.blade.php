<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier l'événement</h2>
            <a href="{{ route('events.show', $event) }}" class="text-sm text-gray-600">Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('events.update', $event) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Type</label>
                        <input type="text" name="type" value="{{ old('type', $event->type) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Lieu</label>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('events.show', $event) }}" class="mr-3 text-gray-600">Annuler</a>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
