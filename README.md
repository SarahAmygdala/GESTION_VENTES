<div align="center">

# 🛒 Mi Varotra

### Application de Caisse & Gestion des Ventes (POS)

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)](https://postgresql.org)
[![Docker](https://img.shields.io/badge/Docker-Render.com-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://render.com)

**[🚀 Voir la Démo Live](https://mi-varotra.onrender.com)** · Connexion : bouton **"Accès Démo"**

</div>

---

## ✨ Présentation

**Mi Varotra** (« Ma Vente » en malgache) est une application web complète de **Point de Vente (POS)** conçue pour les commerces à Madagascar. Elle permet de gérer l'intégralité du cycle de vente : caisse, stock, clients, facturation et reporting.

---

## 🎯 Fonctionnalités

| Modules | Détails |
|---|---|
| 🖥️ **Caisse (POS)** | Catalogue produits filtrable, panier dynamique, remises, calcul de monnaie |
| 📊 **Dashboard** | KPIs en temps réel (CA, transactions, alertes), graphique 7 jours (Chart.js) |
| 🧾 **Facturation PDF** | Génération automatique après chaque vente (DomPDF) |
| 📦 **Gestion Produits** | CRUD complet, images, codes-barres, alertes stock faible |
| 👥 **Clients & Équipe** | Gestion des clients fidèles, rôles Admin / Caissier |
| 📈 **Historique Ventes** | Filtres avancés (date, client), export Excel |
| ⚙️ **Paramètres** | Nom de la boutique, devise, personnalisation |
| 📱 **100% Responsive** | Navigation mobile adaptée (bottom nav, tiroirs) |

---

## 🧰 Stack Technique

- **Back-end** : Laravel 12, PHP 8.3
- **Front-end** : Alpine.js, Tailwind CSS, Chart.js
- **Base de données** : PostgreSQL
- **PDF** : DomPDF (barryvdh/laravel-dompdf)
- **Excel** : Maatwebsite/Laravel-Excel
- **Déploiement** : Docker · Render.com
- **Authentification** : Laravel Breeze (sessions, CSRF, rôles)

---

## 🚀 Installation Locale

```bash
# 1. Cloner le projet
git clone https://github.com/SarahAmygdala/GESTION_VENTES.git
cd GESTION_VENTES

# 2. Installer les dépendances
composer install
npm install && npm run build

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
# DB_CONNECTION=pgsql (ou mysql/sqlite)
# puis :
php artisan migrate --seed

# 5. Lien de stockage & démarrage
php artisan storage:link
php artisan serve
```

Accédez à `http://localhost:8000`

---

## 🔑 Accès Démo

| Rôle | Email | Mot de passe |
|---|---|---|
| **Admin** | `admin@mivarotra.mg` | `password` |
| **Caissier** | `caissier@mivarotra.mg` | `password` |

> Ou cliquez sur **"Accès Démo"** sur la page de connexion.

---

## 📁 Structure Clé

```
├── app/
│   ├── Http/Controllers/   # DashboardController, PosController, ...
│   ├── Models/             # Product, Sale, Client, User, ...
│   └── Providers/          # AppServiceProvider (HTTPS forcé en prod)
├── database/
│   ├── migrations/         # 14 migrations
│   └── seeders/            # Données démo (admin, produits, catégories)
├── resources/views/        # Blade templates (layouts, pos, products, ...)
├── Dockerfile              # Image PHP 8.3-fpm + Nginx + Node.js
└── render.yaml             # Configuration déploiement Render.com
```

---

## 📄 Licence

Projet développé par **Sarah Amygdala** — 2026  
Usage éducatif et démonstration portfolio.
