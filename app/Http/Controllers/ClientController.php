<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    // Méthode unique pour gérer l'affichage et la recherche
    public function index(Request $request)
    {
        $query = $request->input('search');

        $clients = Client::when($query, function ($q) use ($query) {
            return $q->where('nom', 'like', "%{$query}%")
                     ->orWhere('prenom', 'like', "%{$query}%");
        })->get();

        return view('clients.index', compact('clients'));
    }

    public function create() {
        return view('clients.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        
        // Sécurité : n'autoriser que les champs nécessaires
        Client::create($request->only(['nom', 'prenom', 'telephone', 'adresse', 'email']));
        return redirect('/clients')->with('success', 'Client ajouté !');
    }

    public function edit($id) {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        
        $client = Client::findOrFail($id);
        $client->update($request->only(['nom', 'prenom', 'telephone', 'adresse', 'email']));
        return redirect('/clients')->with('success', 'Client mis à jour !');
    }

    public function destroy($id) 
    {
        $client = Client::findOrFail($id);

        if ($client->commandes()->exists()) {
            return redirect()->back()->with('error', 'Impossible de supprimer ce client : il possède des commandes enregistrées.');
        }

        $client->delete();
        return redirect('/clients')->with('success', 'Client supprimé avec succès !');
    }
}