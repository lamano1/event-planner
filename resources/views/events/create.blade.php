<x-app-layout>
    <x-slot name="header">
        <h2 class="title-futuristic">⚡ Créer un Événement</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-500 bg-opacity-10 border border-red-500 border-opacity-50">
                    <h4 class="font-bold mb-2 text-red-400">⚠ Erreurs de validation</h4>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-300 text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('events.store') }}" method="POST" class="event-card">
                @csrf
                <div class="mb-6">
                    <label class="block text-purple-300 font-semibold mb-2">Titre de l'événement</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="input-futuristic @error('title') border-red-500 border-opacity-100 @enderror" placeholder="ex: Mariage de Julie" required>
                    @error('title')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-purple-300 font-semibold mb-2">Type d'événement</label>
                    <select name="type" class="input-futuristic @error('type') border-red-500 border-opacity-100 @enderror">
                        <option value="">-- Sélectionner un type --</option>
                        <option value="Anniversaire" {{ old('type') == 'Anniversaire' ? 'selected' : '' }}>🎂 Anniversaire</option>
                        <option value="Mariage" {{ old('type') == 'Mariage' ? 'selected' : '' }}>💍 Mariage</option>
                        <option value="Professionnel" {{ old('type') == 'Professionnel' ? 'selected' : '' }}>💼 Professionnel</option>
                        <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>✨ Autre</option>
                    </select>
                    @error('type')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-purple-300 font-semibold mb-2">📅 Date</label>
                        <input type="date" name="date" value="{{ old('date') }}" class="input-futuristic @error('date') border-red-500 border-opacity-100 @enderror" required>
                        @error('date')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-purple-300 font-semibold mb-2">📍 Lieu</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="input-futuristic @error('location') border-red-500 border-opacity-100 @enderror" placeholder="Ville, Salle...">
                        @error('location')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('events.index') }}" class="px-6 py-2 rounded-lg text-purple-300 border border-purple-500 border-opacity-50 hover:border-opacity-100 hover:text-purple-200 font-semibold">Annuler</a>
                    <button type="submit" class="btn-neon">🚀 Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>