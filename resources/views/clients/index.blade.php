@extends('layouts.app')

@section('title', 'Gestion des Clients')

@section('content')
<style>
    /* Effet de survol fluide et professionnel */
    tbody tr:hover {
        background-color: #f1f5f9 !important;
        transition: background-color 0.2s ease;
    }
    th, td { vertical-align: middle; }
    
    /* Animation d'entrée pour la carte */
    .card { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 24px;">Gestion des Clients</h1>
        <a href="{{ url('/clients/create') }}" style="background: #27ae60; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; transition: 0.2s;">+ Nouveau Client</a>
    </div>

    <form action="{{ url('/clients') }}" method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
    <input type="text" name="search" placeholder="Rechercher un client..." 
           value="{{ request('search') }}"
           style="padding: 10px; flex-grow: 1; border: 1px solid #ddd; border-radius: 8px;">
    
    <button type="submit" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer;">
        Rechercher
    </button>
    
    <a href="{{ url('/clients') }}" style="padding: 10px 20px; background: #64748b; color: white; text-decoration: none; border-radius: 8px;">
        Tout voir
    </a>
</form>

    <table style="width: 100%; border-collapse: collapse; text-align: left; table-layout: fixed;">
        <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 15px; width: 60px;">ID</th>
                <th style="padding: 15px; width: 20%;">Client</th>
                <th style="padding: 15px; width: 15%;">Téléphone</th>
                <th style="padding: 15px; width: 15%;">Adresse</th>
                <th style="padding: 15px; width: 25%;">Email</th> 
                <th style="padding: 15px; width: 180px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px; color: #666; overflow: hidden; text-overflow: ellipsis;">{{ $client->id }}</td>
                <td style="padding: 15px; font-weight: bold; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $client->nom }} {{ $client->prenom }}</td>
                <td style="padding: 15px; overflow: hidden; text-overflow: ellipsis;">{{ $client->telephone }}</td>
                <td style="padding: 15px; overflow: hidden; text-overflow: ellipsis;">{{ $client->adresse }}</td>
                <td style="padding: 15px; color: #777; overflow: hidden; text-overflow: ellipsis;">{{ $client->email }}</td>
                
                <td style="padding: 15px; text-align: center;">
                    <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                        <a href="{{ url('/clients/'.$client->id.'/edit') }}" 
                           style="background-color: #e0f2fe; color: #0284c7; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700;">
                           Modifier
                        </a>
                        <form action="{{ url('/clients/'.$client->id) }}" method="POST" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    style="background-color: #fee2e2; color: #dc2626; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; font-weight: 700;">
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