<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id'
        ]);

        Guest::create([
            'name' => $request->name,
            'event_id' => $request->event_id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Invité ajouté !');
    }
}