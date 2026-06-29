<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistiques globales
        $totalClients = Client::count();
        $totalProduits = Produit::count();
        $totalCommandes = Commande::count();

        // 2. Ventes du jour (Montant et Nombre)
        $commandesDuJour = Commande::whereDate('date_commande', today())->with('produits')->get();
        
        $ventesJour = $commandesDuJour->sum(function($commande) {
            return $commande->produits->sum(function($p) {
                return $p->pivot->quantite * $p->prix_unitaire;
            });
        });
        
        $nbCommandesJour = $commandesDuJour->count();

        // 3. Alertes stock (Produits avec stock <= 5)
        $produitsEnRupture = Produit::where('quantite_stock', '<=', 5)->get();

        // 4. Top 5 produits les plus vendus
        $topProduits = Produit::withSum('commandes as total_vendu', 'commande_produit.quantite')
            ->orderByDesc('total_vendu')
            ->limit(5)
            ->get();

        // 5. Historique des ventes sur 7 jours
        $ventesSeptDerniersJours = Commande::where('date_commande', '>=', now()->subDays(7))
            ->with('produits')
            ->get()
            ->groupBy(function($commande) {
                return Carbon::parse($commande->date_commande)->format('d/m');
            })
            ->map(function ($group) {
                return $group->sum(function($commande) {
                    return $commande->produits->sum(function($p) {
                        return $p->pivot->quantite * $p->prix_unitaire;
                    });
                });
            });

        // 6. Derniers clients
        $derniersClients = Client::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalClients', 
            'totalProduits', 
            'totalCommandes', 
            'ventesJour', 
            'nbCommandesJour', 
            'produitsEnRupture', 
            'topProduits', 
            'derniersClients',
            'ventesSeptDerniersJours'
        ));
    }
}