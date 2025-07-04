# Housebidding

Projet Laravel 11 minimaliste de vente d'une maison.

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build # compilation locale de Tailwind
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
