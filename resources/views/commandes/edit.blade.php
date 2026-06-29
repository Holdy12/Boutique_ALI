@extends('layouts.app')

@section('title', 'Modifier Commande #' . $commande->id)

@section('content')
<div style="max-width: 700px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 24px; color: #1e293b;">Modifier Commande #{{ $commande->id }}</h1>
        <a href="{{ url('/commandes') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">← Annuler</a>
    </div>

    <form action="{{ url('/commandes/'.$commande->id) }}" method="POST" id="commandeForm">
        @csrf
        @method('PUT')
        
        <!-- Sélection du Client -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">Client</label>
            <select name="client_id" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $commande->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }} {{ $client->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

       <!-- Remplace ta section "Liste des produits" par ceci -->
<div style="margin-bottom: 20px;">
    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569;">Sélectionner les produits</label>
    
    <div style="max-height: 300px; overflow-y: auto; border: 1px solid #cbd5e1; padding: 10px; border-radius: 6px;">
        @foreach($produits as $produit)
            @php
                // Vérifier si le produit est déjà dans la commande pour cocher la case
                $commandeProduit = $commande->produits->firstWhere('id', $produit->id);
            @endphp
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <input type="checkbox" name="produits[]" value="{{ $produit->id }}" 
                       {{ $commandeProduit ? 'checked' : '' }}>
                <span style="flex: 1;">{{ $produit->designation }}</span>
                <input type="number" name="quantites[{{ $produit->id }}]" 
                       value="{{ $commandeProduit ? $commandeProduit->pivot->quantite : 1 }}" 
                       min="1" style="width: 80px; padding: 5px;">
            </div>
        @endforeach
    </div>
</div>

        <button type="submit" style="width: 100%; background: #2563eb; color: white; padding: 15px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            ENREGISTRER LES MODIFICATIONS
        </button>
    </form>
</div>

<script>
function ajouterLigne() {
    const wrapper = document.getElementById('produits-wrapper');
    const newRow = document.createElement('div');
    newRow.className = 'produit-row';
    newRow.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
    newRow.innerHTML = `
        <select name="produits[]" style="flex: 2; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            @foreach($produits as $p)
                <option value="{{ $p->id }}">{{ $p->designation }}</option>
            @endforeach
        </select>
        <input type="number" name="quantites[]" value="1" min="1" style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
    `;
    wrapper.appendChild(newRow);
}
</script>
@endsection