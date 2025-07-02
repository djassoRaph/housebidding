# Housebidding

Projet Laravel 11 minimaliste de vente aux enchères d'une maison.
L'interface utilise Bootstrap 5 via CDN (aucune compilation n'est nécessaire).

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## Déploiement sur o2switch

- Uploadez tous les fichiers sur le serveur
- Assurez-vous que PHP 8.2+ et MySQL sont disponibles
- Configurez les variables d'environnement dans `.env`
- Le dossier `public/` contient l'entrée du site ; une redirection est fournie via `.htaccess`

## Compte démo

- Email: `demo@example.com`
- Mot de passe: `password`

Le site est en français et ne propose pas de système de récupération de mot de passe.
