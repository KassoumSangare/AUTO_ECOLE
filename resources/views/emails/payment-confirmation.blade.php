@component('mail::message')
# Confirmation de votre paiement

Bonjour {{ $user->name }},

Nous vous remercions pour votre paiement ! Cette email confirme que votre paiement a été traité avec succès.

## Détails de la commande

| Élément | Détail |
|--------|--------|
| **Numéro de commande** | {{ $order->id }} |
| **Montant** | {{ number_format($order->amount / 100, 0, ',', ' ') }} {{ $order->currency }} |
| **Date de paiement** | {{ $order->paid_at->format('d/m/Y à H:i') }} |
| **Statut** | ✅ Complété |

## Prochaines étapes

- ✅ Votre reçu est joint à cet email
- ✅ Vous avez maintenant accès à tous les contenus de formation
- ✅ Vous pouvez télécharger votre reçu à tout moment depuis votre tableau de bord

## Besoin d'aide ?

Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter :

- **Email** : support@autoecole.com
- **Téléphone** : +221 XX XXX XXXX
- **Chat en ligne** : disponible sur notre site

Merci de votre confiance !

@component('mail::subcopy')
Cet email contient également votre reçu en pièce jointe. Veuillez le conserver à titre de preuve de paiement.
@endcomponent
@endcomponent
