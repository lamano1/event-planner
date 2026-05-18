<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier un poste de budget</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('budgets.update', $budget) }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Poste</label>
                        <input type="text" name="item_name" value="{{ old('item_name', $budget->item_name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Montant</label>
                        <input type="number" name="amount" step="0.01" value="{{ old('amount', $budget->amount) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <input type="text" name="category" value="{{ old('category', $budget->category) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('events.show', $budget->event) }}" class="mr-3 text-gray-600">Annuler</a>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
