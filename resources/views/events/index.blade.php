<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="title-futuristic">⭐ MES ÉVÉNEMENTS</h2>
            <a href="{{ route('events.create') }}" class="btn-cyan">+ CRÉER</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-500 bg-opacity-10 border border-green-500 border-opacity-50 glow-green">
                    ✓ {{ session('success') }}
                </div>
            @endif
            
            @if($events->isEmpty())
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">🚀</div>
                    <p class="text-purple-300 text-lg mb-6">Vous n'avez pas encore d'événements</p>
                    <a href="{{ route('events.create') }}" class="btn-neon inline-block">CRÉER VOTRE PREMIER ÉVÉNEMENT</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="event-card group hover:scale-105 hover:shadow-lg">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="event-card-title text-lg mb-1">{{ $event->title }}</h3>
                                    <span class="event-card-badge">
                                        @switch($event->type)
                                            @case('Anniversaire') 🎂 @break
                                            @case('Mariage') 💍 @break
                                            @case('Professionnel') 💼 @break
                                            @default ✨
                                        @endswitch
                                        {{ $event->type }}
                                    </span>
                                </div>
                                @if($event->managed_at)
                                    <span class="inline-block text-xs bg-green-500 bg-opacity-20 text-green-400 px-3 py-1 rounded-full border border-green-500 border-opacity-50">✓ Géré</span>
                                @endif
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <p class="text-purple-200 text-sm">
                                    📅 {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                </p>
                                @if($event->location)
                                    <p class="text-purple-200 text-sm">
                                        📍 {{ $event->location }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex gap-2 pt-4 border-t border-purple-500 border-opacity-20">
                                <a href="{{ route('events.show', $event) }}" class="flex-1 btn-cyan text-center text-xs py-2">
                                    Gérer
                                </a>
                                <a href="{{ route('events.edit', $event) }}" class="flex-1 px-3 py-2 rounded-lg text-purple-300 border border-purple-500 border-opacity-50 hover:border-opacity-100 hover:text-purple-200 font-semibold text-xs">
                                    Modifier
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="flex-1" onsubmit="return confirm('Supprimer cet événement ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 rounded-lg text-red-400 border border-red-500 border-opacity-50 hover:border-opacity-100 hover:text-red-300 font-semibold text-xs">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>