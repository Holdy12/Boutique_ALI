@extends('layouts.app')

@section('title', 'Ajouter un Client')

@section('content')
<style>
    .form-card {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
        animation: fadeIn 0.5s ease-out;
    }
    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 15px;
        transition: border-color 0.2s;
    }
    input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="form-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 22px;">Nouveau Client</h1>
        <a href="{{ url('/clients') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">← Retour</a>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/clients') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569;">Nom *</label>
                <input type="text" name="nom" required placeholder="Nom">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569;">Prénom *</label>
                <input type="text" name="prenom" required placeholder="Prénom">
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569;">Téléphone *</label>
            <input type="text" name="telephone" required placeholder="Ex: 655xxxxxx">
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569;">Adresse</label>
            <input type="text" name="adresse" placeholder="Adresse physique">
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #475569;">Email</label>
            <input type="email" name="email" placeholder="adresse@email.com">
        </div>

        <button type="submit" style="margin-top: 10px; background: #27ae60; color: white; padding: 14px; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; transition: background 0.2s;">
            ENREGISTRER LE CLIENT
        </button>
    </form>
</div>
@endsection