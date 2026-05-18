<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer un événement</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('events.store') }}" method="POST" class="bg-white p-6 shadow sm:rounded-lg">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Titre de l'événement</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="ex: Mariage de Julie" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Type</label>
                    <select name="type" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Anniversaire">Anniversaire</option>
                        <option value="Mariage">Mariage</option>
                        <option value="Professionnel">Professionnel</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700">Date</label>
                        <input type="date" name="date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Lieu</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ville, Salle...">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>