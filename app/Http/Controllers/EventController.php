<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Affiche la liste des événements de l'utilisateur connecté.
     */
    public function index()
    {
        // On récupère uniquement les événements de l'utilisateur actuel
        $events = Event::where('user_id', Auth::id())->orderBy('date', 'asc')->get();
        
        return view('events.index', compact('events'));
    }

    /**
     * Affiche le formulaire de création d'un événement.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Enregistre un nouvel événement dans la base PostgreSQL.
     */
    public function store(Request $request)
    {
        // 1. Validation des données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'nullable|string|max:255',
        ]);

        // 2. Création de l'événement lié à l'utilisateur
        $event = new Event();
        $event->title = $validated['title'];
        $event->type = $validated['type'];
        $event->date = $validated['date'];
        $event->location = $validated['location'];
        $event->user_id = Auth::id(); // On lie l'événement à l'ID de la personne connectée
        $event->save();

        // 3. Redirection vers la page de détail de l'événement créé
        return redirect()->route('events.show', $event)->with('success', 'Événement créé avec succès ! Vous pouvez maintenant le gérer.');
    }

    /**
     * Affiche les détails d'un événement (avec ses tâches, invités, etc.).
     */
    public function show(Event $event)
    {
        // Vérification de sécurité : l'événement appartient-il bien à l'utilisateur ?
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        // On charge les relations (tasks, guests, budget) pour les afficher sur la page
        $event->load(['tasks', 'guests', 'budgets']);
        
        return view('events.show', compact('event'));
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id()) { abort(403); }
        
        return view('events.edit', compact('event'));
    }

    /**
     * Met à jour l'événement dans la base de données.
     */
    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) { abort(403); }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        $event->update($validated);

        // Si un événement a déjà été marqué comme géré, le modifier invalide la gestion
        if ($event->managed_at) {
            $event->managed_at = null;
            $event->save();
        }

        return redirect()->route('events.index')->with('success', 'Événement mis à jour ! Veuillez valider la gestion si nécessaire.');
    }

    /**
     * Supprime l'événement.
     */
    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) { abort(403); }
        
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Événement supprimé.');
    }

    /**
     * Mark event as managed (finaliser la gestion de l'événement).
     */
    public function manage(Event $event)
    {
        if ($event->user_id !== Auth::id()) { abort(403); }

        $event->managed_at = now();
        $event->save();

        return redirect()->route('events.index')->with('success', "L'événement \"{$event->title}\" a été géré.");
    }
}
