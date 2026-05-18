<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }} - {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Colonne Invités -->
            <div class="bg-white p-6 shadow rounded-lg">
    <h3 class="font-bold text-lg mb-4 text-green-600 italic">Liste des invités</h3>
    
    <form action="{{ route('guests.store') }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <input type="text" name="name" class="flex-1 border-gray-300 rounded-l-md text-sm" placeholder="Nom de l'invité...">
        <button type="submit" class="bg-green-500 text-white px-3 rounded-r-md text-sm">+</button>
    </form>

    <ul class="space-y-2">
        @foreach($event->guests as $guest)
            <li class="text-sm border-b pb-1 flex justify-between">
                <span>{{ $guest->name }}</span>
                <span class="text-xs bg-gray-100 px-2 rounded-full text-gray-500">{{ $guest->status }}</span>
            </li>
        @endforeach
    </ul>
</div>

<!-- Colonne Budget -->
<div class="bg-white p-6 shadow rounded-lg">
    <h3 class="font-bold text-lg mb-4 text-red-600 italic">Budget Prévisionnel</h3>
    
    <form action="{{ route('budgets.store') }}" method="POST" class="mb-4 space-y-2">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <input type="text" name="item_name" class="w-full border-gray-300 rounded-md text-sm" placeholder="Poste (ex: Traiteur)">
        <div class="flex">
            <input type="number" name="amount" step="0.01" class="flex-1 border-gray-300 rounded-l-md text-sm" placeholder="Prix estimé">
            <button type="submit" class="bg-red-500 text-white px-4 rounded-r-md text-sm">Ajouter</button>
        </div>
    </form>

    <div class="mt-4 border-t pt-2">
            <p class="text-xl font-bold text-gray-800">
            Total : {{ number_format($event->budgets->sum('amount'), 2) }} €
        </p>
    </div>
    
    <!-- Liste détaillée des postes de budget -->
    <div class="mt-4">
        <h4 class="text-sm font-semibold text-gray-700 mb-2">Postes</h4>
        <ul class="space-y-2">
            @forelse($event->budgets as $budget)
                <li class="flex justify-between text-sm border-b pb-1 items-center">
                    <div>
                        <span>{{ $budget->item_name }} @if($budget->category) <span class="text-xs text-gray-400">({{ $budget->category }})</span> @endif</span>
                        <div class="text-xs text-gray-500">{{ number_format($budget->amount, 2) }} €</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('budgets.edit', $budget) }}" class="text-sm text-blue-600 hover:underline">Modifier</a>
                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Supprimer ce poste de budget ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm text-red-600">Supprimer</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="text-sm text-gray-400">Aucun poste ajouté.</li>
            @endforelse
        </ul>
    </div>
</div>
    <!-- Colonne Checklist -->
<div class="bg-white p-6 shadow rounded-lg">
    <h3 class="font-bold text-lg mb-4 text-blue-600 italic">Checklist des tâches</h3>
    
    <!-- Formulaire d'ajout rapide -->
    <form action="{{ route('tasks.store') }}" method="POST" class="mb-4 flex">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <input type="text" name="label" class="flex-1 border-gray-300 rounded-l-md text-sm" placeholder="Nouvelle tâche...">
        <button type="submit" class="bg-blue-500 text-white px-3 rounded-r-md text-sm">+</button>
    </form>

    <ul class="space-y-2">
        @foreach($event->tasks as $task)
            <li class="flex items-center justify-between">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="flex items-center">
                        <input type="checkbox" {{ $task->is_completed ? 'checked' : '' }} class="mr-2">
                        <span class="{{ $task->is_completed ? 'line-through text-gray-400' : '' }} text-sm">
                            {{ $task->label }}
                        </span>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
<!-- Bouton pour finaliser/Enregistrer la gestion de l'événement -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <form action="{{ route('events.manage', $event) }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Enregistrer la gestion</button>
    </form>
</div>
</x-app-layout>
