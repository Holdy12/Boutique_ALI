<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Boutique Ali</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f8fafc; margin: 0; color: #334155; }
        .sidebar { width: 250px; background: #1e293b; height: 100vh; position: fixed; color: white; padding: 20px; }
        .sidebar a { display: block; color: #94a3b8; padding: 15px; text-decoration: none; border-radius: 8px; transition: 0.3s; }
        .sidebar a:hover { background: #334155; color: white; }
        .main-content { margin-left: 290px; padding: 40px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; font-size: 24px; color: #1e293b; }
        .btn-add { background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; }
        /* Effet de clic physique */
button:active, a:active {
    transform: scale(0.96);
    transition: transform 0.1s ease;
}

/* Effet au survol des boutons */
button, .btn-add {
    transition: all 0.2s ease;
}
button:hover, .btn-add:hover {
    filter: brightness(1.1); /* Éclaircit légèrement le bouton */
    cursor: pointer;
}

.main-content { animation: fadeIn 0.6s ease-out forwards; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    tbody tr { transition: background-color 0.3s ease; }
    tbody tr:hover { background-color: #f1f5f9 !important; }

    button, a { transition: all 0.2s ease; }
    button:active, a:active { transform: scale(0.96); }
    /* Animation d'apparition */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.main-content {
    animation: fadeIn 0.6s ease-out forwards;
}   
   </style>
    
</head>
<body>
    <div class="sidebar">
    <h2 style="margin-bottom: 30px; padding: 0 15px;">Boutique Ali</h2>
    
    <!-- Lien Tableau de bord -->
    <a href="{{ url('/dashboard') }}" style="display: flex; align-items: center; gap: 12px; font-weight: bold; color: #fff;">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
        <span>Tableau de bord</span>
    </a>
    <!-- Lien Clients -->
    <a href="{{ url('/clients') }}" style="display: flex; align-items: center; gap: 12px;">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        <span>Clients</span>
    </a>

    <!-- Lien Produits -->
    <a href="{{ url('/produits') }}" style="display: flex; align-items: center; gap: 12px;">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
        <span>Produits</span>
    </a>

    <!-- Lien Commandes -->
    <a href="{{ url('/commandes') }}" style="display: flex; align-items: center; gap: 12px;">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <span>Commandes</span>
    </a>
</div>
    <div class="main-content">
        @if(session('success'))
    <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0; text-align: center; font-weight: 600;">
        {{ session('success') }}
    </div>
@endif
        @yield('content')
    </div>
</body>
</html>
