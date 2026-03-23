<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression documents — Auto-École Le Chemin</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        h1 { font-size: 16px; color: #0B2545; border-bottom: 2px solid #D4A843; padding-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th { background: #0B2545; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 6px 8px; border-bottom: 1px solid #E9ECEF; }
        tr:nth-child(even) td { background: #F8F9FD; }
        .badge { padding: 2px 8px; border-radius: 50px; font-size: 10px; font-weight: 700; }
        .en_attente { background: #FFF8E8; color: #856404; }
        .valide     { background: #E8FFE8; color: #198754; }
        .rejete     { background: #FFE8E8; color: #DC3545; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:12px;">
        <button onclick="window.print()" style="background:#0B2545;color:#fff;border:none;padding:8px 16px;border-radius:8px;cursor:pointer;font-weight:700;">
            🖨️ Imprimer
        </button>
    </div>
    <h1>Documents élèves — Auto-École Le Chemin</h1>
    <p style="color:#6C757D;font-size:11px;">Généré le {{ now()->format('d/m/Y à H:i') }} · {{ $documents->count() }} document(s)</p>
    <table>
        <thead>
            <tr>
                <th>Élève</th><th>Téléphone</th><th>Type</th><th>Fichier</th><th>Déposé le</th><th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $doc)
            <tr>
                <td><strong>{{ $doc->user->nom_complet ?? '—' }}</strong></td>
                <td>{{ $doc->user->telephone ?? '—' }}</td>
                <td>{{ $doc->label_type }}</td>
                <td>{{ $doc->original_name }}</td>
                <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                <td><span class="badge {{ $doc->status }}">{{ ucfirst($doc->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>