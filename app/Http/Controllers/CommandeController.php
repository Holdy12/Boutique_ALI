<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeController extends Controller
{
    
   public function index(Request $request)
{
    // On récupère le terme de recherche
    $search = $request->input('search');

    // On prépare la requête
    $commandes = \App\Models\Commande::with(['client', 'produits'])
        ->when($search, function ($query) use ($search) {
            // Filtrer par nom du client ou nom du produit (via les relations)
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%");
            })->orWhereHas('produits', function ($q) use ($search) {
                $q->where('designation', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->get();

    return view('commandes.index', compact('commandes'));
}
    public function create() {
        $clients = \App\Models\Client::all();
        $produits = \App\Models\Produit::all();
        return view('commandes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
{

// 1. Validation des champs de base
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'produits' => 'required|array|min:1', // On attend un tableau de produits
        'date_commande' => 'required|date',
    ]);

    // 2. Création de la commande
    $commande = \App\Models\Commande::create([
        'client_id' => $request->client_id,
        'date_commande' => $request->date_commande,
    ]);

    // 3. Traitement des produits
    foreach ($request->produits as $produitId) {
        $quantiteDemandee = $request->quantites[$produitId] ?? 0;

        if ($quantiteDemandee > 0) {
            $produit = \App\Models\Produit::findOrFail($produitId);

            // Vérification du stock
            if ($quantiteDemandee > $produit->quantite_stock) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Stock insuffisant pour : {$produit->designation} (Dispo: {$produit->quantite_stock})");
            }

            // Enregistrement dans la table pivot
            $commande->produits()->attach($produitId, ['quantite' => $quantiteDemandee]);

            // Mise à jour du stock
            $produit->quantite_stock -= $quantiteDemandee;
            $produit->save();
        }
    }

    return redirect('/commandes')->with('success', 'Commande enregistrée avec succès !');
}

    public function edit($id) {
        $commande = \App\Models\Commande::findOrFail($id);
        $clients = \App\Models\Client::all();
        $produits = \App\Models\Produit::all();
        return view('commandes.edit', compact('commande', 'clients', 'produits'));
    }

     public function update(Request $request, $id)

{

// 1. Validation adaptée aux tableaux (si tu utilises le formulaire à cases à cocher)

$request->validate([

'client_id' => 'required|exists:clients,id',

'produits' => 'required|array', // On attend un tableau d'IDs

'quantites' => 'required|array', // On attend un tableau de quantités

]);


$commande = \App\Models\Commande::findOrFail($id);


// 2. Restitution du stock : on remet le stock des anciens produits avant la mise à jour

foreach ($commande->produits as $produit) {

$produit->quantite_stock += $produit->pivot->quantite;

$produit->save();

}


// 3. Mise à jour du client

$commande->update(['client_id' => $request->client_id]);


// 4. Synchronisation des nouveaux produits et nouvelle décrémentation du stock

$syncData = [];

foreach ($request->produits as $index => $produitId) {

$qte = $request->quantites[$produitId] ?? 1; // Récupère la qté pour cet ID

$produit = \App\Models\Produit::findOrFail($produitId);

// Vérification stock pour chaque produit

if ($produit->quantite_stock < $qte) {

return redirect()->back()->with('error', "Stock insuffisant pour {$produit->designation}");
}
$syncData[$produitId] = ['quantite' => $qte];

// Décrémentation
$produit->quantite_stock -= $qte;
$produit->save();
}

// Mise à jour de la table pivot
$commande->produits()->sync($syncData);

return redirect('/commandes')->with('success', 'Commande mise à jour avec succès !');
}


    public function downloadPDF($id) 
{
    // On charge la relation 'produits' (au pluriel)
    $commande = \App\Models\Commande::with(['client', 'produits'])->findOrFail($id);
    
    $pdf = Pdf::loadView('commandes.facture', ['commande' => $commande]);
    
    return $pdf->stream('facture_boutique_ali_'.$commande->id.'.pdf');
}

    public function destroy($id) {
        $commande = \App\Models\Commande::findOrFail($id);
        
        $produit = \App\Models\Produit::find($commande->produit_id);
        if ($produit) {
            $produit->quantite_stock += $commande->quantite;
            $produit->save();
        }

        $commande->delete();
        return redirect('/commandes')->with('success', 'Commande annulée et stock restitué !');
    }

    
}
