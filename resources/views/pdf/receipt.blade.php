<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reçu {{ $payment->receipt_number }}</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #1F2937;
            background: #fff;
        }

        /* ── Palette (hex uniquement — DomPDF) ─────────────
           Rouge Terrazzo  : #AF2636 / foncé #8A1E2B
           Or Sable        : #C5A059
           Vert Sauge      : #2D6A4F
           Texte anthracite: #1F2937
           Gris doux       : #6B7280
        ──────────────────────────────────────────────────── */

        /* ── HEADER ──────────────────────────────────────── */
        .header-band {
            background: #8A1E2B;
            color: #fff;
            padding: 28px 40px 22px;
            position: relative;
        }

        .header-accent {
            position: absolute;
            top: 0;
            right: 0;
            width: 160px;
            height: 100%;
            background: #C5A059;
            opacity: 0.13;
        }

        .logo-row {
            display: table;
            width: 100%;
        }

        .logo-left {
            display: table-cell;
            vertical-align: middle;
            width: 55%;
        }

        .logo-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .logo-circle {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: #C5A059;
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            font-size: 20px;
            font-weight: 900;
            color: #8A1E2B;
            vertical-align: middle;
            margin-right: 12px;
        }

        .logo-text {
            display: inline-block;
            vertical-align: middle;
        }

        .logo-name {
            font-size: 19px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .logo-name span {
            color: #C5A059;
        }

        .logo-tagline {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.55);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .receipt-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 4px;
        }

        .receipt-number {
            font-size: 17px;
            font-weight: 900;
            color: #C5A059;
            letter-spacing: 1px;
        }

        /* ── BANDE STATUT ────────────────────────────────── */
        .status-band {
            background: #C5A059;
            padding: 9px 40px;
            display: table;
            width: 100%;
        }

        .status-left {
            display: table-cell;
            vertical-align: middle;
            font-size: 11px;
            color: #4A3200;
            font-weight: 700;
        }

        .status-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .badge-paid {
            background: #8A1E2B;
            color: #fff;
            font-size: 9px;
            font-weight: 900;
            padding: 4px 14px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* ── CORPS ───────────────────────────────────────── */
        .body-content {
            padding: 32px 40px;
        }

        /* Deux colonnes */
        .info-table {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-col:last-child {
            padding-left: 20px;
        }

        .info-block-title {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9CA3AF;
            font-weight: 700;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1.5px solid #E5E7EB;
        }

        .info-row {
            margin-bottom: 9px;
        }

        .info-label {
            font-size: 9.5px;
            color: #6B7280;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 12px;
            font-weight: 700;
            color: #1F2937;
        }

        .info-value-sm {
            font-size: 10px;
            font-weight: 600;
            color: #6B7280;
        }

        /* Séparateur section */
        .section-title {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9CA3AF;
            font-weight: 700;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1.5px solid #E5E7EB;
        }

        /* Tableau détail */
        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        table.detail thead tr {
            background: #8A1E2B;
            color: #fff;
        }

        table.detail thead th {
            padding: 10px 14px;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            text-align: left;
        }

        table.detail thead th:last-child {
            text-align: right;
        }

        table.detail tbody tr {
            border-bottom: 1px solid #E5E7EB;
        }

        table.detail tbody tr:last-child {
            border-bottom: none;
        }

        table.detail tbody td {
            padding: 12px 14px;
            font-size: 11.5px;
            color: #1F2937;
            vertical-align: top;
        }

        table.detail tbody td:last-child {
            text-align: right;
        }

        /* Ligne totaux */
        .total-box {
            background: #F9F9F7;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            padding: 14px 20px;
            margin-top: 18px;
            display: table;
            width: 100%;
        }

        .total-left {
            display: table-cell;
            vertical-align: middle;
        }

        .total-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .total-label {
            font-size: 10px;
            color: #6B7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-sublabel {
            font-size: 9px;
            color: #9CA3AF;
            margin-top: 3px;
        }

        .total-amount {
            font-size: 26px;
            font-weight: 900;
            color: #1F2937;
            letter-spacing: -0.5px;
        }

        .total-currency {
            font-size: 13px;
            color: #C5A059;
            font-weight: 700;
            margin-left: 4px;
        }

        /* Note informative */
        .note-box {
            background: #FEFCE8;
            border-left: 3px solid #C5A059;
            border-radius: 0 8px 8px 0;
            padding: 11px 16px;
            margin-top: 20px;
            font-size: 10.5px;
            color: #78350F;
            line-height: 1.65;
        }

        /* Bloc pédagogique */
        .access-box {
            background: #F0F7F4;
            border: 1px solid #A7C4B5;
            border-radius: 8px;
            padding: 14px 18px;
            margin-top: 18px;
        }

        .access-title {
            font-size: 10px;
            font-weight: 900;
            color: #2D6A4F;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .access-item {
            font-size: 10.5px;
            color: #1B4332;
            margin-bottom: 5px;
            padding-left: 12px;
        }

        .access-item:before {
            content: '✓ ';
            color: #2D6A4F;
            font-weight: 900;
        }

        /* FOOTER */
        .footer {
            background: #F5F5F3;
            border-top: 2px solid #E5E7EB;
            padding: 16px 40px;
            margin-top: 28px;
            display: table;
            width: 100%;
        }

        .footer-left {
            display: table-cell;
            vertical-align: middle;
            font-size: 9.5px;
            color: #9CA3AF;
            line-height: 1.7;
        }

        .footer-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            font-size: 9.5px;
            color: #9CA3AF;
        }

        .footer-right strong {
            color: #C5A059;
            font-weight: 900;
        }

        .footer-brand {
            font-size: 11px;
            font-weight: 900;
            color: #AF2636;
            letter-spacing: 0.5px;
        }

        .footer-brand span {
            color: #2D6A4F;
        }

        /* Filigrane */
        .watermark {
            position: fixed;
            top: 38%;
            left: 50%;
            transform: translateX(-50%) rotate(-30deg);
            font-size: 86px;
            font-weight: 900;
            color: rgba(175, 38, 54, 0.055);
            text-transform: uppercase;
            letter-spacing: 10px;
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>

<body>

    {{-- Filigrane --}}
    <div class="watermark">PAYÉ</div>

    {{-- ═══════════ HEADER ═══════════ --}}
    <div class="header-band">
        <div class="header-accent"></div>
        <div class="logo-row">
            <div class="logo-left">
                <span class="logo-circle">LC</span>
                <span class="logo-text">
                    <div class="logo-name">Le <span>Chemin</span></div>
                    <div class="logo-tagline">Auto-École — Abidjan, Côte d'Ivoire</div>
                </span>
            </div>
            <div class="logo-right">
                <div class="receipt-label">Reçu de paiement</div>
                <div class="receipt-number">{{ $payment->receipt_number }}</div>
            </div>
        </div>
    </div>

    {{-- ═══════════ BANDE STATUT ═══════════ --}}
    <div class="status-band">
        <div class="status-left">
            Émis le {{ $payment->paid_at ? $payment->paid_at->isoFormat('D MMMM YYYY [à] HH:mm') : $payment->created_at->isoFormat('D MMMM YYYY [à] HH:mm') }}
        </div>
        <div class="status-right">
            <span class="badge-paid">✓ Paiement confirmé</span>
        </div>
    </div>

    {{-- ═══════════ CORPS ═══════════ --}}
    <div class="body-content">

        {{-- Deux colonnes : Élève + Émetteur --}}
        <div class="info-table">

            {{-- Colonne élève --}}
            <div class="info-col">
                <div class="info-block-title">Informations de l'élève</div>

                <div class="info-row">
                    <div class="info-label">Nom complet</div>
                    <div class="info-value">{{ strtoupper($payment->user->nom) }} {{ $payment->user->prenom }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">{{ $payment->user->telephone }}</div>
                </div>

                @if($payment->user->email)
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $payment->user->email }}</div>
                </div>
                @endif

                <div class="info-row">
                    <div class="info-label">Référence Wave</div>
                    <div class="info-value-sm">{{ $payment->reference_wave ?? '—' }}</div>
                </div>
            </div>

            {{-- Colonne auto-école --}}
            <div class="info-col">
                <div class="info-block-title">Émetteur</div>

                <div class="info-row">
                    <div class="info-label">Établissement</div>
                    <div class="info-value">Auto-École Le Chemin</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Localisation</div>
                    <div class="info-value">Plateau Dokui, Abobo — Abidjan</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">+225 27 24 31 88 38</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Numéro de reçu</div>
                    <div class="info-value">{{ $payment->receipt_number }}</div>
                </div>
            </div>

        </div>

        {{-- Tableau détail prestation --}}
        <div class="section-title">Détail de la prestation</div>
        <table class="detail">
            <thead>
                <tr>
                    <th style="width:46%;">Désignation</th>
                    <th>Réf. transaction</th>
                    <th>Date</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Formation au permis de conduire</strong><br>
                        <span style="font-size:9.5px;color:#6B7280;">
                            Accès plateforme en ligne — Code de la route &amp; Conduite
                        </span>
                    </td>
                    <td style="font-size:10px;color:#6B7280;">
                        {{ $payment->reference_wave ?? '—' }}
                    </td>
                    <td style="font-size:10.5px;">
                        {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y') : '—' }}
                    </td>
                    <td>
                        <strong>{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Total --}}
        <div class="total-box">
            <div class="total-left">
                <div class="total-label">Montant total payé</div>
                <div class="total-sublabel">Paiement sécurisé via Wave CI</div>
            </div>
            <div class="total-right">
                <span class="total-amount">{{ number_format($payment->amount, 0, ',', ' ') }}</span>
                <span class="total-currency">{{ $payment->currency }}</span>
            </div>
        </div>

        {{-- Accès formation --}}
        <div class="access-box">
            <div class="access-title">Ce paiement vous donne accès à</div>
            <div class="access-item">Médiathèque vidéo — Cours code &amp; conduite</div>
            <div class="access-item">Quiz QCM interactifs avec correction immédiate</div>
            <div class="access-item">Coffre-fort numérique — Dépôt de documents</div>
            <div class="access-item">Suivi de progression personnalisé</div>
        </div>

        {{-- Note --}}
        <div class="note-box">
            <strong>Note :</strong> Ce document est généré automatiquement et constitue une preuve de paiement valide.
            Conservez-le pour toute réclamation. Pour toute question, contactez-nous sur WhatsApp au
            <strong>+225 27 24 31 88 38</strong> ou à l'adresse Plateau Dokui, Abobo, Abidjan.
        </div>

    </div>

    {{-- ═══════════ FOOTER ═══════════ --}}
    <div class="footer">
        <div class="footer-left">
            <span class="footer-brand">Le <span>Chemin</span></span> — Auto-École agréée, Abidjan, Côte d'Ivoire<br>
            Document généré le {{ now()->isoFormat('D MMMM YYYY [à] HH:mm') }} &nbsp;•&nbsp; Document officiel non modifiable
        </div>
        <div class="footer-right">
            <strong>{{ $payment->receipt_number }}</strong><br>
            <span style="font-size:8.5px;color:#ADB5BD;">Réf. Wave : {{ $payment->reference_wave ?? 'N/A' }}</span>
        </div>
    </div>

</body>

</html>