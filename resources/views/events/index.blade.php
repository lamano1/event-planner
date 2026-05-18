<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Événements') }}
            </h2>
            <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nouvel Événement
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if($events->isEmpty())
                    <p class="text-center text-gray-500">Vous n'avez pas encore d'événements. Commencez par en créer un !</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($events as $event)
                                <tr class="group hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $event->title }} @if($event->managed_at) <span class="ml-2 inline-block text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded">Géré</span> @endif</td>
                                    <td class="px-6 py-4">{{ $event->type }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-900 mr-3">Gérer</a>
                                        <a href="{{ route('events.edit', $event) }}" class="text-gray-500 mr-3 opacity-0 group-hover:opacity-100">Modifier</a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Supprimer cet événement ?')">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>