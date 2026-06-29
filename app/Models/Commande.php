<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{


    // On retire 'produit_id', 'quantite' et 'prix_unitaire' car ils gérés par la table pivot
    protected $fillable = ['client_id', 'date_commande'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Nouvelle relation Many-to-Many
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}