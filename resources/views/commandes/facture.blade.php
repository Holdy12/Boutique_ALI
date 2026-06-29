<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture N° {{ $commande->id }}</title>
    <style>
        body { font-family: 'Segoe UI', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.6; font-size: 14px; margin: 0; padding: 0; }
        .invoice-box { max-width: 800px; margin: 40px auto; padding: 40px; border: 1px solid #f1f5f9; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px; background: white; }
        
        .header { width: 100%; margin-bottom: 40px; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; }
        .company-name { font-size: 28px; font-weight: 800; color: #1e293b; text-transform: uppercase; margin-bottom: 5px; }
        .invoice-title { font-size: 32px; font-weight: 800; color: #3b82f6; text-align: right; }
        
        .client-card { width: 45%; border-left: 4px solid #3b82f6; padding-left: 20px; background: #f8fafc; padding: 15px; border-radius: 0 8px 8px 0; margin-bottom: 30px; }
        .client-title { font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 5px; }
        
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .invoice-table th { background-color: #1e293b; color: white; padding: 12px; text-align: left; font-size: 13px; }
        .invoice-table td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
        
        .total-box { float: right; width: 100%; max-width: 300px; background: #f8fafc; padding: 20px; border-radius: 8px; }
        .total-line { font-size: 18px; font-weight: 800; color: #1e293b; }
        
        .signature-section { margin-top: 100px; text-align: right; }
        .signature-box { display: inline-block; text-align: center; border-top: 1px solid #333; padding-top: 10px; min-width: 200px; }
        
        .footer { margin-top: 50px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    </style>
</head>
<body>

    <div class="invoice-box">
        <!-- En-tête -->
        <table class="header">
            <tr>
                <td>
                    <div class="company-name">Boutique Ali</div>
                    <div style="color: #64748b;">Vente de Marchandises & Articles<br>N'Djamena, Tchad</div>
                </td>
                <td style="vertical-align: top;">
                    <div class="invoice-title">FACTURE</div>
                    <div style="text-align: right; margin-top: 5px;">
                        <strong>N°:</strong> #FAC-{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}<br>
                        <strong>Date:</strong> {{ date('d/m/Y', strtotime($commande->date_commande)) }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Infos Client -->
        <div class="client-card">
            <div class="client-title">Facturé à :</div>
            <strong style="font-size: 18px; color: #1e293b;">{{ $commande->client->prenom ?? '' }} {{ $commande->client->nom ?? 'Client Inconnu' }}</strong>
            <div style="margin-top: 5px; color: #475569;">
                Tél: {{ $commande->client->telephone ?? 'N/A' }}<br>
                Adresse: {{ $commande->client->adresse ?? 'N/A' }}
            </div>
        </div>

        <!-- Tableau des produits -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Désignation du Produit</th>
                    <th style="text-align: center;">Qté</th>
                    <th style="text-align: right;">Prix Unitaire</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                @php $totalGeneral = 0; @endphp
                @foreach($commande->produits as $produit)
                @php 
                    $montantLigne = $produit->pivot->quantite * $produit->prix_unitaire;
                    $totalGeneral += $montantLigne;
                @endphp
                <tr>
                    <td>
                        <strong style="color: #1e293b;">{{ $produit->designation }}</strong><br>
                        @if(!empty($produit->reference))
                            <span style="font-size: 12px; color: #64748b;">Réf: {{ $produit->reference }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $produit->pivot->quantite }}</td>
                    <td style="text-align: right;">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td style="text-align: right; font-weight: 700;">{{ number_format($montantLigne, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
       <!-- Remplacer le bloc Total actuel par celui-ci -->
<div style="margin-top: 20px; text-align: right;">
    <div style="display: inline-block; width: 300px; background: #f8fafc; padding: 20px; border-radius: 8px;">
        <table style="width: 100%;">
            <tr>
                <td style="font-weight: 800; color: #1e293b;">Total Général:</td>
                <td style="text-align: right; color: #3b82f6; font-weight: 800; font-size: 18px;">
                    {{ number_format($totalGeneral, 0, ',', ' ') }} FCFA
                </td>
            </tr>
        </table>
    </div>
</div>

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                Signature et Cachet<br>
                <strong>Boutique Ali</strong>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            Boutique Ali — Merci pour votre confiance ! — Système de Gestion Commerciale
        </div>
    </div>

</body>
</html>