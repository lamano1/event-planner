<x-app-layout>
    <x-slot name="header">
        <h2 class="title-futuristic">
            ✨ {{ $event->title }} — {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <!-- Colonne Invités -->
                <div class="event-card">
                    <div class="section-header">
                        <span class="section-title text-purple-400">INVITÉS</span>
                    </div>
                    
                    <form action="{{ route('guests.store') }}" method="POST" class="mb-4 flex gap-2">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="text" name="name" class="input-futuristic flex-1 text-xs" placeholder="Nom de l'invité..." required>
                        <button type="submit" class="btn-green px-4 py-2 text-xs">+</button>
                    </form>

                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($event->guests as $guest)
                            <div class="flex justify-between items-center p-2 rounded bg-slate-800 bg-opacity-50 border border-purple-500 border-opacity-20">
                                <span class="text-purple-200 text-sm">{{ $guest->name }}</span>
                                <span class="text-xs bg-purple-500 bg-opacity-20 px-2 py-1 rounded-full text-purple-300">{{ $guest->status }}</span>
                            </div>
                        @empty
                            <p class="text-purple-400 text-sm text-center py-4">Aucun invité</p>
                        @endforelse
                    </div>
                </div>

                <!-- Colonne Budget -->
                <div class="event-card">
                    <div class="section-header">
                        <span class="section-title text-red-400">BUDGET</span>
                    </div>
                    
                    <form action="{{ route('budgets.store') }}" method="POST" class="mb-4 space-y-2">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="text" name="item_name" class="input-futuristic w-full text-xs" placeholder="Poste (ex: Traiteur)" required>
                        <div class="flex gap-2">
                            <input type="number" name="amount" step="0.01" class="input-futuristic flex-1 text-xs" placeholder="Prix estimé" required>
                            <button type="submit" class="btn-red px-4 py-2 text-xs" style="background: linear-gradient(45deg, #ff006e, #ff3366); border: 1px solid rgba(255, 0, 110, 0.5);">Ajouter</button>
                        </div>
                    </form>

                    <div class="bg-slate-800 bg-opacity-50 border border-red-500 border-opacity-20 rounded-lg p-3 mb-4">
                        <p class="text-xl font-bold glow-pink">
                            {{ number_format($event->budgets->sum('amount'), 2) }} fcfa
                        </p>
                    </div>
                    
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @forelse($event->budgets as $budget)
                            <div class="p-2 rounded bg-slate-800 bg-opacity-50 border border-purple-500 border-opacity-20">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-purple-200 text-sm">{{ $budget->item_name }}</p>
                                        <p class="text-red-400 text-xs font-bold">{{ number_format($budget->amount, 2) }} fcfa</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ route('budgets.edit', $budget) }}" class="text-cyan-400 hover:text-cyan-300 text-xs">✎</a>
                                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 text-xs">✕</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-purple-400 text-sm text-center py-4">Aucun poste</p>
                        @endforelse
                    </div>
                </div>

                <!-- Colonne Checklist -->
                <div class="event-card">
                    <div class="section-header">
                        <span class="section-title text-cyan-400">CHECKLIST</span>
                    </div>
                    
                    <form action="{{ route('tasks.store') }}" method="POST" class="mb-4 flex gap-2">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="text" name="label" class="input-futuristic flex-1 text-xs" placeholder="Nouvelle tâche..." required>
                        <button type="submit" class="btn-cyan px-4 py-2 text-xs">+</button>
                    </form>

                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($event->tasks as $task)
                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full text-left p-2 rounded bg-slate-800 bg-opacity-50 border border-purple-500 border-opacity-20 hover:border-purple-500 hover:border-opacity-50 flex items-center gap-2 group">
                                    <input type="checkbox" {{ $task->is_completed ? 'checked' : '' }} class="w-4 h-4 cursor-pointer" onclick="this.closest('form').submit()">
                                    <span class="{{ $task->is_completed ? 'line-through text-purple-500' : 'text-purple-200' }} text-sm flex-1">
                                        {{ $task->label }}
                                    </span>
                                </button>
                            </form>
                        @empty
                            <p class="text-purple-400 text-sm text-center py-4">Aucune tâche</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Bouton pour finaliser -->
            <div class="flex justify-center gap-4">
                <a href="{{ route('events.edit', $event) }}" class="px-6 py-3 rounded-lg text-purple-300 border border-purple-500 border-opacity-50 hover:border-opacity-100 hover:text-purple-200 font-semibold">
                    ✎ Modifier l'événement
                </a>
                <form action="{{ route('events.manage', $event) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-neon px-6 py-3">
                        🎉 {{ $event->managed_at ? 'Déjà géré' : 'Finaliser' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>