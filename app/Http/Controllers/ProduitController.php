<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
  public function index(Request $request)
{
    // On récupère le terme de recherche
    $search = $request->input('search');

    // On récupère les produits avec un filtre optionnel
    $produits = Produit::when($search, function ($query) use ($search) {
        return $query->where('designation', 'like', "%{$search}%");
    })->get();

    return view('produits.index', compact('produits'));
}

    public function create() {
        return view('produits.create');
    }

    public function store(Request $request) {
        $request->validate([
            'reference' => 'required|string|unique:produits,reference|max:255',
            'designation' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);
        Produit::create($request->all());
        return redirect('/produits')->with('success', 'Produit ajouté !');
    }

    // Afficher le formulaire d'édition
    public function edit($id) {
        $produit = Produit::findOrFail($id);
        return view('produits.edit', compact('produit'));
    }

    // Traiter la mise à jour
    public function update(Request $request, $id) {
        $request->validate([
            'reference' => 'required|string|max:255|unique:produits,reference,'.$id,
            'designation' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);
        $produit = Produit::findOrFail($id);
        $produit->update($request->all());
        return redirect('/produits')->with('success', 'Produit mis à jour !');
    }

    public function destroy($id) 
{
    $produit = Produit::findOrFail($id);
    
    // Vérifier si le produit est lié à au moins une commande
    if ($produit->commandes()->exists()) {
        return redirect()->back()->with('error', 'Impossible de supprimer ce produit : il est lié à des commandes.');
    }

    $produit->delete();
    return redirect('/produits')->with('success', 'Produit supprimé !');
}
}
