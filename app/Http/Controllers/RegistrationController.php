<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Inscrire un utilisateur à un événement
     */
    public function store(Event $event)
    {
        // 1. Vérification de la capacité
        if ($event->capacity <= 0) {
            // Si c'est un test ou une requête API
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Désolé, cet événement est complet.'], 400);
            }
            // Si c'est un utilisateur sur navigateur
            return back()->with('error', 'Désolé, cet événement est complet.');
        }

        // 2. Vérification si déjà inscrit
        if ($event->users()->where('user_id', auth()->id())->exists()) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Vous êtes déjà inscrit.'], 400);
            }
            return back()->with('info', 'Vous êtes déjà inscrit à cet événement.');
        }

        // 3. Création de l'inscription
        Registration::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        // 4. Décrémentation de la capacité
        $event->decrement('capacity');

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Place réservée avec succès.'], 200);
        }

        return redirect()->route('my.registrations')
                         ->with('success', 'Félicitations ! Votre place est réservée.');
    }

    /**
     * Affiche les inscriptions de l'utilisateur connecté
     */
    public function myRegistrations()
    {
        $registrations = auth()->user()->registrations()->with('event.category')->latest()->get();
        return view('registrations.my', compact('registrations'));
    }

    /**
     * Annuler une inscription
     */
    public function destroy(Event $event)
    {
        $userId = auth()->id();

        $registration = Registration::where('user_id', $userId)
                                    ->where('event_id', $event->id)
                                    ->first();

        if ($registration) {
            $registration->delete();

            // Restaurer la capacité
            $event->increment('capacity');

            if (request()->expectsJson()) {
                return response()->json(['success' => 'Inscription annulée.'], 200);
            }

            return back()->with('success', 'Votre inscription a été annulée.');
        }

        if (request()->expectsJson()) {
            return response()->json(['error' => 'Inscription introuvable.'], 404);
        }

        return back()->with('error', 'Inscription introuvable.');
    }

    /**
     * Admin View: Affiche toutes les inscriptions
     */
    public function allRegistrations()
    {
        $registrations = Registration::with(['user', 'event.category'])->latest()->get();
        return view('admin.registrations', compact('registrations'));
    }
}