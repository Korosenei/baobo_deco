# BAOBO DECO Theme
## Guide d'installation et de configuration

---

### 📁 Structure des fichiers

```
baobo-deco-child/
├── style.css                  (styles globaux — déjà là)
├── css/
│   ├── page-accueil.css
│   ├── page-a-propos.css
│   ├── page-services.css
│   ├── page-galerie.css
│   ├── page-boutique.css
│   ├── page-contact.css
│   └── page-devis.css
├── js/
│   └── baobo-main.js
├── functions.php
├── header.php
├── footer.php
├── page-accueil.php
└── page-a-propos.php


baobo-deco-theme/
├── style.css          ← Identité du thème + toute la charte graphique
├── functions.php      ← Enqueue assets, WooCommerce FCFA, désactivation header/footer Astra
├── header.php         ← Bandeau promo dynamique + navigation sticky + menu mobile
├── footer.php         ← Footer 4 colonnes + WhatsApp flottant + back-to-top
├── index.php          ← Template par défaut (obligatoire WordPress)
├── images/
│   └── logo.png       ← Ton logo intégré
└── js/
    └── baobo-main.js  ← Scroll effect, hamburger, recherche, back-to-top, WA tooltip
```

---

### 🚀 Installation

1. **Uploader le dossier** `baobo-deco-child/` dans `/wp-content/themes/`
2. **Activer** le thème depuis `Apparence → Thèmes`
3. Vérifier que le thème parent **Astra** est bien installé

---

### ⚙️ Configuration initiale

#### Étape 1 — Paramètres du site
Aller dans **BAOBO DECO** (menu gauche admin) et remplir :
- Numéro WhatsApp
- Téléphones, email, adresse
- Texte du bandeau promo
- Statistiques (projets, clients, années, satisfaction)
- Titre et texte du CTA rouge

#### Étape 2 — Logo
- `Apparence → Personnaliser → Identité du site` → uploader le logo
- **OU** simplement copier `logo.png` dans le dossier du thème enfant

#### Étape 3 — Menus WordPress
- `Apparence → Menus` → Créer un menu "Menu Principal"
- Assigner l'emplacement **Menu Principal**
- Ajouter les pages : Accueil, À Propos, Services, Galerie, Boutique, Blog, Contact

#### Étape 4 — Slides Hero
- Menu **BAOBO DECO → Slides Hero** → Ajouter un slide
- Remplir : Titre, image à la une (ou URL Unsplash), sous-titre, bouton CTA
- Modifier l'ordre via **Attributs de page → Ordre**

#### Étape 5 — Services
- Menu **BAOBO DECO → Services** → Ajouter les services
- Dans la colonne droite : choisir l'icône FontAwesome et cocher "Afficher en vedette"

#### Étape 6 — Témoignages
- Menu **BAOBO DECO → Témoignages** → Ajouter les témoignages
- Titre = Nom du client | Contenu = le témoignage
- Dans la meta box : Localité + Note (1 à 5 étoiles)

#### Étape 7 — WooCommerce (Boutique)
- Installer WooCommerce
- Aller dans `Produits` → Marquer les produits en vedette avec l'étoile ⭐
- Ces produits apparaîtront automatiquement dans la section "Produits Vedettes"

---

### 🎨 Personnalisation couleurs

Modifier les variables dans `style.css` (début du fichier) :

```css
:root {
    --bd-rouge:       #C0392B;   /* Rouge principal */
    --bd-or:          #C9A96E;   /* Doré/Or */
    --bd-dark:        #1A1008;   /* Fond sombre */
    --bd-creme:       #FAF7F2;   /* Fond crème */
}
```

---

### 📱 Responsive

| Breakpoint | Comportement |
|-----------|-------------|
| > 1100px  | Layout complet 3/4 colonnes |
| ≤ 1100px  | 2 colonnes, nav masquée |
| ≤ 768px   | Hamburger menu mobile |
| ≤ 540px   | 1 colonne, layout simplifié |

---

### 🔧 Icônes FontAwesome disponibles pour les services

| Classe          | Rendu       |
|----------------|-------------|
| `fa-couch`     | Canapé      |
| `fa-paint-brush` | Peinture  |
| `fa-ruler-combined` | Aménagement |
| `fa-comments`  | Conseil     |
| `fa-window-maximize` | Rideaux |
| `fa-truck`     | Livraison   |
| `fa-tools`     | Installation |
| `fa-lightbulb` | Luminaires  |
| `fa-gem`       | Qualité     |
| `fa-home`      | Maison      |
| `fa-building`  | Bureau      |

---

### 📧 Formulaire de contact

Le formulaire envoie les messages par email à l'adresse administrateur WordPress via `wp_mail()`.

Pour changer l'email destinataire :
`Réglages → Général → Adresse e-mail`

---

### 🛒 Intégration WooCommerce

Si WooCommerce est installé :
- Le panier dans le header se met à jour automatiquement
- Les produits vedettes (étoile ⭐ dans WooCommerce) s'affichent section 3
- Le bouton "Ajouter" utilise l'AJAX WooCommerce natif

---

### 💡 Shortcodes disponibles

```
[baobo_whatsapp text="Nous contacter" msg="Bonjour, je voudrais..."]
[baobo_devis_btn text="Demander un devis" url="/devis/"]
```

---

*Développé par Dev Excellence — BAOBO DECO v1.0.0*
