<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'amount' => 'required|numeric',
            'event_id' => 'required|exists:events,id'
        ]);

        Budget::create([
            'item_name' => $request->item_name,
            'amount' => $request->amount,
            'event_id' => $request->event_id,
            'actual_amount' => 0,
            'is_paid' => false
        ]);

        return back()->with('success', 'Dépense ajoutée au budget !');
    }

    public function edit(Budget $budget)
    {
        // ensure the authenticated user owns the event
        if ($budget->event->user_id !== Auth::id()) { abort(403); }

        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->event->user_id !== Auth::id()) { abort(403); }

        $request->validate([
            'item_name' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'nullable|string'
        ]);

        $budget->update([
            'item_name' => $request->item_name,
            'amount' => $request->amount,
            'category' => $request->category,
        ]);

        return redirect()->route('events.show', $budget->event)->with('success', 'Poste de budget mis à jour.');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->event->user_id !== Auth::id()) { abort(403); }

        $event = $budget->event;
        $budget->delete();

        return redirect()->route('events.show', $event)->with('success', 'Poste de budget supprimé.');
    }
}