@extends('layouts.app')

@section('title', 'Modifier un Produit')

@if(session('error'))
    <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif
@section('content')
    <div class="page-header" style="margin-bottom: 20px;">
        <h1>Modifier le Produit : {{ $produit->designation }}</h1>
        <a href="{{ url('/produits') }}" class="btn btn-edit" style="background-color: #7f8c8d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Annuler</a>
    </div>

    <form action="{{ url('/produits/'.$produit->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 15px; max-width: 600px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Référence *</label>
            <input type="text" name="reference" value="{{ $produit->reference }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Désignation *</label>
            <input type="text" name="designation" value="{{ $produit->designation }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Prix Unitaire (FCFA) *</label>
            <input type="number" step="0.01" name="prix_unitaire" value="{{ $produit->prix_unitaire }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Quantité en Stock *</label>
            <input type="number" name="quantite_stock" value="{{ $produit->quantite_stock }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Description</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; box-sizing: border-box;">{{ $produit->description }}</textarea>
        </div>

        <div style="margin-top: 10px;">
            <input type="submit" value="🔄 ENREGISTRER LES MODIFICATIONS" style="background-color: #2980b9; color: white; padding: 12px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
        </div>
    </form>
@endsection
