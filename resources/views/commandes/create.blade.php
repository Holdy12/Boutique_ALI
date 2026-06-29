@extends('layouts.app')

@section('title', 'Nouvelle Commande')

@section('content')
<style>
    .form-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto; }
    .product-row { display: flex; align-items: center; gap: 15px; padding: 12px; border-bottom: 1px solid #f1f5f9; }
    .product-row:hover { background: #f8fafc; }
    select, input { padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; }
</style>

<div class="form-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 22px;">Nouvelle Commande</h1>
        <a href="{{ url('/commandes') }}" style="color: #64748b; text-decoration: none;">← Retour</a>
    </div>

    {{-- Affichage des erreurs de stock ou validation --}}
    @if(session('error'))
        <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fecaca;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ url('/commandes') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 5px;">Client</label>
            <select name="client_id" required style="width: 100%;">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 5px;">Date de la commande</label>
            <input type="date" name="date_commande" value="{{ date('Y-m-d') }}" required style="width: 100%;">
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 5px;">Produits (Cochez et précisez la quantité)</label>
            <div style="border: 1px solid #e2e8f0; border-radius: 6px; max-height: 300px; overflow-y: auto; padding: 5px;">
                @foreach($produits as $produit)
                    <div class="product-row">
                        <input type="checkbox" name="produits[]" value="{{ $produit->id }}">
                        <span style="flex-grow: 1; font-size: 14px;">
                            {{ $produit->designation }} 
                            <small style="color: #64748b;">(Stock: {{ $produit->quantite_stock }})</small>
                        </span>
                        <input type="number" name="quantites[{{ $produit->id }}]" placeholder="Qté" min="1" max="{{ $produit->quantite_stock }}" style="width: 80px;">
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" style="background: #27ae60; color: white; padding: 14px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px;">
            ENREGISTRER LA COMMANDE
        </button>
    </form>
</div>
@endsection