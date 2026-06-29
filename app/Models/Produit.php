<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    // Autorise l'enregistrement de tous les champs requis par le sujet
    protected $fillable = ['reference', 'designation', 'prix_unitaire', 'quantite_stock', 'description'];

    // Relation Many-to-Many avec Commande
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}