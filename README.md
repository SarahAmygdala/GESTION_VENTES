# Mi Varotra - POS Moderne (Laravel)

## À propos
**Mi Varotra** est une application web moderne de gestion de point de vente (POS) conçue pour les commerces à Madagascar.

## Fonctionnalités
- **Dashboard dynamique** : Statistiques CA, ventes et alertes stock.
- **Caisse interactive (POS)** : Panier ultra-rapide avec Alpine.js.
- **Facturation PDF** : Génération de factures professionnelles en Ariary.
- **Gestion des stocks** : Alertes stock faible et gestion d'images.
- **Gestion d'équipe** : Rôles Admin et Caissier.

## Installation Locale
1. `composer install`
2. `npm install && npm run build`
3. `php artisan migrate --seed`
4. `php artisan storage:link`
5. `php artisan serve`

## Déploiement InfinityFree
1. Créer une base de données MySQL sur le panneau InfinityFree.
2. Copier tous les fichiers vers le dossier `htdocs` via FTP.
3. Modifier le fichier `.env` avec les identifiants MySQL fournis.
4. Assurez-vous que le fichier `.htaccess` est présent à la racine pour rediriger vers `/public`.
5. Si `php artisan storage:link` ne fonctionne pas en ligne, créez manuellement un lien symbolique ou utilisez un script PHP.

## Identifiants par défaut
- **Admin** : `admin@mivarotra.mg` / `password`
- **Caissier** : `caissier@mivarotra.mg` / `password`
