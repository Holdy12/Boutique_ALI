# Boutique_ALI
Projet Laravel---Gestion de Boutique


# 🛒 Boutique Ali - Système de Gestion

Système de gestion commerciale développé pour la **Boutique Ali**. Ce projet intègre la gestion des clients, le suivi des stocks et le traitement des commandes avec une intégrité transactionnelle rigoureuse.

## 🏗 Architecture Technique
- **Framework** : Laravel 10/11
- **Base de données** : MySQL
- **Relation** : Many-to-Many entre `Commande` et `Produit` via une table pivot `commande_produit`.
- **Intégrité** : Utilisation de `DB::transaction` pour garantir la cohérence des stocks en cas d'erreur.

## ⚙️ Logique Métier (Gestion des Stocks)
Le système gère les stocks dynamiquement :
1. **Création** : Décrémentation automatique du stock lors de l'enregistrement de la commande.
2. **Mise à jour** : 
   - Restitution automatique du stock des anciens produits.
   - Validation de la disponibilité des nouveaux produits.
   - Synchronisation (`sync`) de la relation et décrémentation des nouveaux stocks.
3. **Suppression** : Restitution automatique du stock au produit correspondant lors de l'annulation d'une commande.


## 🛠 Sécurité & Prévention
- **Validation** : Tous les formulaires utilisent les `Form Requests` ou `validate()` pour empêcher les données corrompues.
- **Protection SQL** : Utilisation des transactions pour éviter les doublons ou erreurs de stock en cas de crash serveur ou de requête interrompue.
- **Contraintes** : Interdiction de supprimer des clients ou produits faisant l'objet de transactions en cours.


## 📂 Arborescence du Projet
```text
GES_BOUTIQUE/
├── app/
│   ├── Http/Controllers/        # Logique métier
│   │   ├── ClientController.php
│   │   ├── CommandeController.php
│   │   └── ProduitController.php
│   └── Models/                  # Entités et relations
│       ├── Client.php
│       ├── Commande.php
│       └── Produit.php
├── database/
│   └── database.sqlite          # Base de données locale
├── resources/
│   └── views/                   # Interfaces utilisateur
│       ├── clients/             # create, edit, index
│       ├── commandes/           # create, edit, facture, index
│       ├── layouts/             # Gabarits
│       ├── produits/            # create, edit, index
│       ├── dashboard.blade.php
│       └── welcome.blade.php
└── routes/
    ├── console.php
    └── web.php                  # Définition des routesn des routes

## 📝 Guide du Développeur

### Routeur & Contrôleurs
- `CommandeController` : Gère le cycle de vie des ventes (Index, Store, Update, Destroy, PDF).
- `ProduitController` : Gestion du catalogue et prévention de suppression si produit en stock.
- `ClientController` : Gestion des tiers et interdiction de suppression si commandes existantes.

### Exemple de logique de mise à jour (Update)
```php
DB::transaction(function () use ($request, $commande) {
    // 1. Restituer stock actuel
    foreach ($commande->produits as $produit) {
        $produit->increment('quantite_stock', $produit->pivot->quantite);
    }

    // 2. Traiter nouveaux produits et valider stock
    // 3. Décrémenter et synchroniser via sync()
    $commande->produits()->sync($syncData);
});

## 👤 Crédits
**Développé par NADOUM WARANGUE Maurer**  
Étudiant en Licence II - Génie Informatique  
CEFOD Business School (CBS)
