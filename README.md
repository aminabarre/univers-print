# 🌍 Universe Print

**Universe Print** est une plateforme web de gestion d’impressions en ligne développée en **PHP**, avec une base de données **MySQL**.  
Elle permet aux utilisateurs de créer un compte, de se connecter, de parcourir les produits d’impression disponibles et à l’administrateur de gérer ces produits (ajout, suppression, etc.).

---

## 🚀 Fonctionnalités principales

### 👥 Utilisateurs
- Inscription avec prénom, email et mot de passe.
- Connexion sécurisée avec session.
- Déconnexion automatique.
- Visualisation des produits disponibles.
- Consultation du prix, du type et de la description des produits.

### 🔐 Administrateur
- Accès réservé grâce au rôle `admin`.
- Tableau de bord pour gérer les produits :
  - Ajouter un nouveau produit.
  - Supprimer un produit existant.
  - Voir tous les produits enregistrés.
- Gestion future possible :
  - Modification de produit.
  - Téléversement et affichage d’images produits.

---

## 🧱 Technologies utilisées

| Type | Outil |
|------|--------|
| Langage backend | PHP |
| Base de données | MySQL |
| Frontend | HTML5, CSS3, Bootstrap |
| Serveur local | XAMPP / Apache |
| Gestion des sessions | PHP Sessions |
| Outils de développement | VS Code / Cursor |

---

## 📂 Structure du projet

universe-print/
│
├── assets/
│ ├── css/
│ │ └── style.css
│ ├── images/
│ │ └── (images des produits)
│
├── includes/
│ ├── db.php → Connexion à la base de données
│ ├── header.php → En-tête HTML + barre de navigation
│ ├── footer.php → Pied de page commun
│
├── index.php → Page d’accueil
├── register.php → Inscription utilisateur
├── connexion.php → Connexion utilisateur
├── logout.php → Déconnexion
├── events.php → Page d’affichage des produits ou événements
├── admin.php → Page d’administration (gestion produits)
├── admi.php → (optionnel) Gestion des réservations
└── README.md → Documentation du projet

---

## 🗄️ Structure de la base de données

### Table `users`
| Colonne | Type | Description |
|----------|------|-------------|
| id | INT (PK) | Identifiant unique |
| prenom | VARCHAR(100) | Prénom de l’utilisateur |
| email | VARCHAR(150) | Adresse email |
| mot_de_passe | VARCHAR(255) | Mot de passe haché |
| role | ENUM('client','admin') | Rôle de l’utilisateur |

### Table `products`
| Colonne | Type | Description |
|----------|------|-------------|
| id | INT (PK) | Identifiant unique |
| nom | VARCHAR(100) | Nom du produit |
| type | VARCHAR(100) | Type d’inscription ou produit |
| description | TEXT | Détails du produit |
| prix | DECIMAL(10,2) | Prix du produit |
| image | BLOB / VARCHAR | Image du produit |
| date_ajout | DATETIME | Date d’ajout automatique |

---
👩🏽‍💻 Auteur

Amina Barre
📍 Dakar, Sénégal
📧 barreamina56@gmail.com

💼 LinkedIn
 (ajouter ton lien plus tard)
💻 Développeuse Web & Mobile
