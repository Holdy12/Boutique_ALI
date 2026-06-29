@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div style="animation: fadeIn 0.5s ease-out;">
    <h1 style="margin-bottom: 30px;">Tableau de Bord - Boutique Ali</h1>

    <!-- 1. KPIs Financiers et Opérationnels -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
        <div class="card" style="padding: 20px; border-left: 5px solid #3b82f6;">
            <h3 style="color: #64748b; margin: 0;">Ventes du jour</h3>
            <p style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 5px 0 0 0;">
                {{ number_format($ventesJour, 0, ',', ' ') }} <span style="font-size: 16px;">FCFA</span>
            </p>
        </div>
        <div class="card" style="padding: 20px; border-left: 5px solid #f59e0b;">
            <h3 style="color: #64748b; margin: 0;">Commandes du jour</h3>
            <p style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 5px 0 0 0;">{{ $nbCommandesJour }}</p>
        </div>
    </div>
    
    <!-- 2. Raccourcis de navigation -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <a href="{{ url('/clients') }}" style="text-decoration: none;">
            <div class="card" style="padding: 20px; text-align: center;"><h3>Clients</h3><p style="font-size: 24px; font-weight: bold; color: #3b82f6;">{{ $totalClients }}</p></div>
        </a>
        <a href="{{ url('/produits') }}" style="text-decoration: none;">
            <div class="card" style="padding: 20px; text-align: center;"><h3>Produits</h3><p style="font-size: 24px; font-weight: bold; color: #10b981;">{{ $totalProduits }}</p></div>
        </a>
        <a href="{{ url('/commandes') }}" style="text-decoration: none;">
            <div class="card" style="padding: 20px; text-align: center;"><h3>Commandes</h3><p style="font-size: 24px; font-weight: bold; color: #f59e0b;">{{ $totalCommandes }}</p></div>
        </a>
    </div>

<div class="card" style="padding: 20px;">
    <h3>📅 Historique des 7 derniers jours</h3>
    <table style="width: 100%; border-collapse: collapse;">
        @foreach($ventesSeptDerniersJours as $date => $total)
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 10px;">{{ $date }}</td>
            <td style="padding: 10px; text-align: right; font-weight: bold;">
                {{ number_format($total, 0, ',', ' ') }} FCFA
            </td>
        </tr>
        @endforeach
    </table>
</div>
    <!-- 3. Alertes et Liste Clients -->
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
        
        <!-- Alerte Stock -->
        <div class="card" style="padding: 20px;">
            <h3 style="color: #ef4444; margin-top: 0;">⚠️ Stock Faible</h3>
            @forelse($produitsEnRupture as $p)
                <div style="padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between;">
                    <span>{{ $p->designation }}</span>
                    <strong>{{ $p->quantite_stock }}</strong>
                </div>
            @empty
                <p>Aucun stock critique.</p>
            @endforelse
        </div>

        <!-- Derniers Clients -->
        <div class="card" style="padding: 20px;">
            <h3 style="margin-top: 0;">Derniers clients</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="text-align: left; color: #64748b;">
                    <th>Nom</th><th>Prénom</th><th>Adresse</th>
                </tr>
                @foreach($derniersClients as $client)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px 0;">{{ $client->nom }}</td>
                    <td>{{ $client->prenom }}</td>
                    <td>{{ $client->adresse }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection