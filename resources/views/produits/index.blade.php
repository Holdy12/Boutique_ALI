@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0;">Gestion des Produits</h1>
        <a href="{{ url('/produits/create') }}" style="background: #f39c12; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">+ Nouveau Produit</a>
    </div>

    <form action="{{ url('/produits') }}" method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
    <input type="text" name="search" placeholder="Rechercher un produit..." 
           value="{{ request('search') }}"
           style="padding: 10px; flex-grow: 1; border: 1px solid #ddd; border-radius: 8px;">
    
    <button type="submit" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 8px; cursor: pointer;">
        Rechercher
    </button>
    
    <a href="{{ url('/produits') }}" style="padding: 10px 20px; background: #64748b; color: white; text-decoration: none; border-radius: 8px;">
        Tout voir
    </a>
</form>

    <!-- Tableau avec largeur fixe et colonnes réparties -->
    <table style="width: 100%; border-collapse: collapse; text-align: left; table-layout: fixed;">
        <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 15px; width: 50px;">ID</th>
                <th style="padding: 15px; width: 120px;">Référence</th>
                <th style="padding: 15px;">Désignation</th>
                <th style="padding: 15px; width: 150px;">Prix</th>
                <th style="padding: 15px; width: 80px;">Stock</th>
                <th style="padding: 15px;">Description</th>
                <th style="padding: 15px; width: 180px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px; color: #666;">{{ $produit->id }}</td>
                <td style="padding: 15px; font-weight: bold;">{{ $produit->reference }}</td>
                <td style="padding: 15px;">{{ $produit->designation }}</td>
                <td style="padding: 15px; font-weight: bold; color: #27ae60;">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                <td style="padding: 15px; text-align: center;">
                    <span style="background: #eef2f7; padding: 5px 10px; border-radius: 12px; font-weight: bold;">{{ $produit->quantite_stock }}</span>
                </td>
                <td style="padding: 15px; color: #777; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $produit->description }}</td>
                <td style="padding: 15px; text-align: center;">
                    <a href="{{ url('/produits/'.$produit->id.'/edit') }}" style="color: #3498db; text-decoration: none; font-weight: bold; margin-right: 10px;">Modifier</a>
                    <form action="{{ url('/produits/'.$produit->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" style="border:none; background:none; color: #e74c3c; cursor:pointer; font-weight: bold;">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
