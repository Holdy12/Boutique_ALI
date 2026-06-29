@extends('layouts.app')

@section('title', 'Gestion des Commandes')

@section('content')
<style>
    tbody tr:hover { background-color: #f1f5f9 !important; transition: 0.2s; }
    .btn-pdf { background-color: #fef3c7; color: #d97706; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; }
    .btn-edit { background-color: #e0f2fe; color: #0284c7; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; }
    .btn-delete { background-color: #fee2e2; color: #dc2626; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; font-weight: 700; }
</style>

<div class="card" style="animation: fadeIn 0.5s ease-out;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 24px;">Gestion des Commandes</h1>
        <a href="{{ url('/commandes/create') }}" style="background: #27ae60; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">+ Nouvelle Commande</a>
    </div>

    <form action="{{ url('/commandes') }}" method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
    <input type="text" name="search" placeholder="Rechercher une commande (client/produit)..." 
           value="{{ request('search') }}"
           style="padding: 10px; flex-grow: 1; border: 1px solid #ddd; border-radius: 8px;">
    
    <button type="submit" style="padding: 10px 20px; background: #f59e0b; color: white; border: none; border-radius: 8px; cursor: pointer;">
        Rechercher
    </button>
    
    <a href="{{ url('/commandes') }}" style="padding: 10px 20px; background: #64748b; color: white; text-decoration: none; border-radius: 8px;">
        Tout voir
    </a>
</form>

    <table style="width: 100%; border-collapse: collapse; text-align: left; table-layout: fixed;">
        <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 15px; width: 60px;">ID</th>
                <th style="padding: 15px; width: 20%;">Client</th>
                <th style="padding: 15px; width: 20%;">Produit</th>
                <th style="padding: 15px; width: 80px; text-align: center;">Qté</th>
                <th style="padding: 15px; width: 15%;">Total</th>
                <th style="padding: 15px; width: 220px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px; color: #666;">{{ $commande->id }}</td>
                <td style="padding: 15px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $commande->client->nom ?? 'N/A' }} {{ $commande->client->prenom ?? '' }}
                </td>
                
                {{-- Affichage des produits (Liste) --}}
                <td style="padding: 15px;">
                    @foreach($commande->produits as $produit)
                        <div style="margin-bottom: 4px;">{{ $produit->designation }}</div>
                    @endforeach
                </td>

                {{-- Affichage des quantités --}}
                <td style="padding: 15px; text-align: center;">
                    @foreach($commande->produits as $produit)
                        <div style="margin-bottom: 4px;">{{ $produit->pivot->quantite }}</div>
                    @endforeach
                </td>

                {{-- Calcul du total --}}
                <td style="padding: 15px; font-weight: 700; color: #1e293b;">
                    {{ number_format($commande->produits->sum(function($p) { return $p->pivot->quantite * $p->prix_unitaire; }), 0, ',', ' ') }} FCFA
                </td>
                
                <td style="padding: 15px; text-align: center;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <a href="{{ url('/commandes/'.$commande->id.'/pdf') }}" class="btn-pdf">PDF</a>
                        <a href="{{ url('/commandes/'.$commande->id.'/edit') }}" class="btn-edit">Modifier</a>
                        <form action="{{ url('/commandes/'.$commande->id) }}" method="POST" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" 
                                    onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection