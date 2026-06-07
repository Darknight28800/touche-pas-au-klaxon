# 🚗 Touche Pas Au Klaxon — Application Web Fullstack

Touche Pas Au Klaxon est une application web complète de gestion de trajets (type covoiturage interne).  
Elle permet aux utilisateurs de consulter les trajets disponibles, réserver, gérer leurs trajets, et propose un espace d’administration complet pour gérer les agences, les utilisateurs et les trajets.

Le projet est construit en **PHP MVC**, avec un **frontend moderne**, un **design responsive**, un **thème clair/sombre**, et des **exports CSV / Excel / PDF**.

---

# 📚 Sommaire

- [Fonctionnalités](#-fonctionnalités)
- [Technologies](#-technologies)
- [Structure du projet](#-structure-du-projet)
- [Installation](#-installation)
- [Base de données](#-base-de-données)
- [Routes principales](#-routes-principales)
- [Espace Administrateur](#-espace-administrateur)
- [Exports CSV / Excel / PDF](#-exports-csv--excel--pdf)
- [Architecture SCSS](#-architecture-scss)
- [Sécurité](#-sécurité)
- [Captures d’écran](#-captures-décran)
- [Livrables](#-livrables)
- [Conclusion](#-conclusion)

---

# 🚀 Fonctionnalités

## 👥 Utilisateurs
- Inscription / Connexion
- Gestion de profil
- Voir ses trajets réservés
- Annuler un trajet
- Interface responsive

## 🚌 Trajets
- Liste des trajets disponibles
- Filtres : agence départ, arrivée, date
- Pagination
- Page détail d’un trajet
- Réservation
- Disponibilité dynamique

## 🏢 Agences
- Liste complète
- CRUD complet (admin)

## 🔐 Administration
- Dashboard statistiques
- Gestion utilisateurs (rôles, suppression)
- Gestion agences
- Gestion trajets
- Exports CSV / Excel / PDF
- Interface dédiée admin

---

# 🛠 Technologies

### Backend
- PHP 8+
- Architecture MVC
- AltoRouter
- PDO (MySQL)
- Dompdf (PDF)
- PhpSpreadsheet (Excel)
- Composer

### Frontend
- HTML5 / SCSS
- Bootstrap 5 (custom theme)
- Thème clair / sombre
- Icônes Bootstrap Icons

### Base de données
- MySQL / MariaDB

---

# 📂 Structure du projet

```
/src
  /Controllers
    AdminController.php
    AuthController.php
    TripController.php
    ...
  /Models
    UserModel.php
    TripModel.php
    AgencyModel.php
  /Views
    /_partials
      header.php
      footer.php
      header_admin.php
      footer_admin.php
      navbar_admin.php
    /admin
      dashboard.php
      trips.php
      trips_edit.php
      agencies.php
      users.php
    /auth
    /public
      home.php
      trips.php

/public
  index.php
  /assets
    /css
    /js
    /img

/config
  database.php

composer.json

```

---

# ⚙ Installation

## 1️⃣ Cloner le projet

```
git clone <url-du-repo>
cd touche-pas-au-klaxon

```

## 2️⃣ Installer les dépendances PHP

```
composer install

```

## 3️⃣ Configurer l’environnement

Créer un fichier `.env` :

```
DB_HOST=localhost
DB_NAME=tpak
DB_USER=root
DB_PASSWORD=

```

## 4️⃣ Importer la base de données

Importer le fichier SQL fourni :

```
/database/tpak.sql

```

## 5️⃣ Lancer le serveur PHP

```
php -S localhost:8000 -t public

```

---

# 🗄 Base de données

Tables principales :

- `users`
- `agencies`
- `trips`
- `reservations`

Relations :

- 1 agence → plusieurs trajets
- 1 utilisateur → plusieurs trajets (conducteur)
- 1 utilisateur → plusieurs réservations

---

# 🌐 Routes principales

## Public
|     Route     |     Description     |
|---------------|---------------------|
| `/`           |   Page d’accueil    |
| `/trips`      | Liste des trajets   |
| `/trip/{id}`  | Détail d’un trajet  |
| `/login`      |     Connexion       |
| `/register`   |    Inscription      |

## Admin
|       Route       |       Description       |
|-------------------|-------------------------|
| `/admin`          |       Dashboard         |
| `/admin/trips`    |     Gestion trajets     |
| `/admin/agencies` |     Gestion agences     |
| `/admin/users`    |   Gestion utilisateurs  |

---

# 🛡 Espace Administrateur

Fonctionnalités :

- Dashboard statistiques
- CRUD utilisateurs
- CRUD agences
- CRUD trajets
- Exports CSV / Excel / PDF
- Sécurisé par rôle `admin`

---

# 📤 Exports CSV / Excel / PDF

## CSV
- Généré via `fputcsv()`
- Encodage UTF‑8 BOM compatible Excel

## Excel
- Généré via PhpSpreadsheet
- Colonnes auto‑dimensionnées
- Format `.xlsx`

## PDF
- Généré via Dompdf
- Format A4 paysage
- Table responsive

---

# 🎨 Architecture SCSS

```
/scss
  /base
  /components
  /layout
  /themes
  variables.scss
  mixins.scss
  main.scss

```

- Thème clair / sombre
- Variables CSS mappées sur Bootstrap
- Design moderne et cohérent

---

# 🔒 Sécurité

- Sessions sécurisées
- Vérification rôle admin
- Validation des formulaires
- Protection contre :
- injections SQL (PDO préparé)
- XSS (htmlspecialchars)
- accès non autorisés

---

# 📸 Captures d’écran

*(À insérer selon ton PDF CEF)*

- Home  
- Liste trajets  
- Page trajet  
- Dashboard admin  
- CRUD trajets  
- Exports  

---

# 📦 Livrables

- Code source complet
- Base de données
- README.md
- Captures d’écran
- PDF explicatif 

---

# 🏁 Conclusion

Touche Pas Au Klaxon est une application web complète, robuste et professionnelle, respectant l’ensemble du brief :

- Architecture MVC propre  
- Interface moderne  
- Admin complet  
- Exports professionnels  
- Sécurité renforcée  
- Code maintenable et structuré  