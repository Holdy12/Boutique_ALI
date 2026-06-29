@extends('layouts.app')

@section('title', 'Ajouter un Produit')

@section('content')
    <div class="page-header" style="margin-bottom: 20px;">
        <h1>Ajouter un Nouveau Produit</h1>
        <a href="{{ url('/produits') }}" class="btn btn-edit" style="background-color: #7f8c8d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/produits') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px; max-width: 600px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Référence *</label>
            <input type="text" name="reference" required placeholder="Ex: REF-001" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Désignation *</label>
            <input type="text" name="designation" required placeholder="Nom du produit" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Prix Unitaire (FCFA) *</label>
            <input type="number" step="0.01" name="prix_unitaire" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Quantité en Stock *</label>
            <input type="number" name="quantite_stock" required value="0" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Description</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; box-sizing: border-box;"></textarea>
        </div>

        <!-- Bouton forcé en Orange/Vert très visible -->
        <div style="margin-top: 10px;">
            <input type="submit" value="💾 ENREGISTRER LE PRODUIT" style="background-color: #e67e22; color: white; padding: 12px 25px; border: none; border-radius: 4px; font-weight: bold; font-size: 16px; cursor: pointer; display: inline-block;">
        </div>
    </form>
@endsection
