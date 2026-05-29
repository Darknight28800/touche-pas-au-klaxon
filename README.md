# 🚗 Touche Pas Au Klaxon — Plateforme de Covoiturage  
Application web MVC en PHP permettant de rechercher, filtrer et gérer des trajets de covoiturage.  
Projet réalisé dans le cadre de la formation Développeur Web.

---

## 📌 1. Fonctionnalités principales

### 👤 Côté utilisateur
- Consultation des trajets disponibles  
- Recherche par **départ**, **arrivée**, **date**  
- Page détail d’un trajet  
- Affichage du conducteur, horaires, places disponibles  
- Mode sombre intégré  
- Interface moderne et responsive  

### 🛠️ Côté administrateur
- Tableau de bord avec statistiques  
- Gestion des trajets (CRUD complet)  
- Gestion des agences (CRUD complet)  
- Gestion des utilisateurs  
- Export Excel (simple + stylé)  
- Export PDF  
- Messages flash  
- Sécurisation par rôle (admin / user)

---

## 🧱 2. Architecture du projet (MVC)

TOUCHE-PAS-AU-KLAXON/
│
├── config/                 # Configuration générale
├── database/               # Scripts SQL (create + seed)
├── jeu-d-essais/           # Données de test
│
├── public/                 # Point d'entrée du site
│   ├── css/style.css
│   ├── index.php
│   └── .htaccess
│
├── src/
│   ├── Config/             # Connexion DB
│   ├── Controllers/        # Logique métier
│   ├── Core/               # Auth, classes internes
│   ├── Models/             # Requêtes SQL
│   ├── Router/altorouter/  # Router
│   └── Views/              # Templates PHP
│
├── vendor/                 # Dépendances Composer
│
├── visuels/                # Screenshots pour la soutenance
│
├── export-excel.php        # Export Excel
├── export-styled.php       # Export Excel stylé
├── excel-styled.xlsx
│
├── README.md
├── composer.json
└── TPK_PDF_Final.pdf

---

## 🗄️ 3. Base de données

### Tables principales :
- `users`  
- `agencies`  
- `trips`  

### Scripts fournis :
- `database/create.sql`  
- `database/seed.sql`  

### Jeu d’essais :
- `jeu-d-essais/agences.txt`  
- `jeu-d-essais/users.txt`

---

## 🚀 4. Installation du projet

### 1️⃣ Cloner le projet
```bash
git clone https://github.com/Darknight28800/touche-pas-au-klaxon.git
cd touche-pas-au-klaxon

2️⃣ Installer les dépendances
  composer install

3️⃣ Configurer la base de données

  Créer un fichier config/database.php :

      return [
          'host' => 'localhost',
          'dbname' => 'tpk',
          'user' => 'root',
          'password' => ''
      ];

4️⃣ Importer la base

database/create.sql
database/seed.sql

5️⃣ Lancer le serveur PHP

php -S localhost:8000 -t public

---


🎨 5. Design & UX
Thème moderne type SaaS

Mode sombre complet

Cards animées

Navigation claire

Responsive mobile

Style.css optimisé

---

🔐 6. Sécurité
Authentification utilisateur

Rôle admin / user

Protection des pages admin

Requêtes SQL préparées (PDO)

Validation des formulaires

Messages flash sécurisés

---

📤 7. Exports
📄 Export PDF
Liste des trajets

Mise en page propre

📊 Export Excel
Version simple

Version stylée (couleurs, bordures, auto-size)

---

🖼️ 8. Captures d’écran
(Les images sont dans le dossier /visuels)

Accueil utilisateur

Liste des trajets

Détail d’un trajet

Interface admin

Dashboard

Messages flash

Mode sombre

---

🧪 9. Tests réalisés
Vérification des routes

Vérification des filtres

Tests CRUD admin

Tests responsive

Tests dark mode

Tests exports PDF / Excel

Tests de sécurité (accès admin)

---

🏁 10. Conclusion
Le projet Touche Pas Au Klaxon répond à l’ensemble des exigences du brief :

Architecture MVC propre

Fonctionnalités complètes

Interface moderne

Admin sécurisé

Exports professionnels

Dark mode

Code clair et organisé

Projet finalisé et prêt pour la soutenance.

👤 Auteur
David ANTOINA  
Développeur Web — Formation CEF
2026