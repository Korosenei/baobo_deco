<?php
/**
 * Template Name: Page Accueil BAOBO DECO
 * page-accueil.php — Template page d'accueil complet
 */

get_header();

global $wpdb;

$hero_slides = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_hero WHERE actif=1 ORDER BY ordre ASC");
$stats       = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_stats ORDER BY ordre ASC");
$services    = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_services WHERE actif=1 ORDER BY ordre ASC");
$produits    = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_produits WHERE actif=1 ORDER BY ordre ASC LIMIT 8");
$temoignages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_temoignages WHERE actif=1 ORDER BY ordre ASC");
$atouts      = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_atouts ORDER BY ordre ASC");

function bd_get($key, $default='') {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$wa_num = bd_get('whatsapp_num', '22607592997');
$wa_msg = bd_get('whatsapp_msg', 'Bonjour BAOBO DECO');
$wa_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode($wa_msg);

$promo_items = [
    bd_get('promo_texte', 'Livraison gratuite à Ouagadougou pour toute commande supérieure à 50 000 FCFA'),
    '✦ Conseil déco personnalisé offert avec toute commande',
    '✦ Installation et pose incluses dans tout Ouagadougou',
    '✦ Paiement à la livraison disponible',
    '✦ Showroom ouvert Lun–Sam de 8h à 18h — Tampouy',
];
?>

<style>
:root {
  --rouge:       #B8282A;
  --rouge-fonce: #8B1A1C;
  --rouge-clair: #D94040;
  --or:          #C9A96E;
  --or-clair:    #E8C98A;
  --noir:        #0D0D0D;
  --noir-doux:   #1A1A1A;
  --gris-fonce:  #2D2D2D;
  --gris:        #6B6B6B;
  --gris-clair:  #E8E3DC;
  --creme:       #F5F0E8;
  --blanc:       #FAFAF8;
  --blanc-pur:   #FFFFFF;
  --ft-display:  'Playfair Display', Georgia, serif;
  --ft-body:     'Jost', sans-serif;
  --ft-accent:   'Cormorant Garamond', serif;
  --shadow-sm:   0 2px 12px rgba(0,0,0,.08);
  --shadow-md:   0 8px 32px rgba(0,0,0,.12);
  --shadow-lg:   0 20px 60px rgba(0,0,0,.18);
  --shadow-rouge:0 8px 32px rgba(184,40,42,.30);
  --tr:          all .35s cubic-bezier(.4,0,.2,1);
  --r:           4px;
  --r-lg:        12px;
}

/* ═══════════════════════════════════
   PROMO BANNER
═══════════════════════════════════ */
.bd-promo-banner {
  display: flex;
  align-items: center;
  height: 52px;
  background: linear-gradient(90deg, var(--rouge-fonce), var(--rouge), #D44);
  overflow: hidden;
}
.bd-promo-badge {
  background: var(--or);
  color: var(--noir);
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  padding: 0 20px;
  height: 100%;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
  white-space: nowrap;
}
.bd-promo-scroll {
  flex: 1;
  overflow: hidden;
  -webkit-mask: linear-gradient(90deg, transparent, #fff 10%, #fff 90%, transparent);
  mask: linear-gradient(90deg, transparent, #fff 10%, #fff 90%, transparent);
}
.bd-promo-scroll-inner {
  display: flex;
  animation: bdScrollL 30s linear infinite;
  white-space: nowrap;
}
.bd-promo-item {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 0 30px;
  font-size: .82rem;
  color: rgba(255,255,255,.92);
  flex-shrink: 0;
}
.bd-promo-item i { color: var(--or-clair); font-size: .75rem; }
.bd-promo-cta {
  flex-shrink: 0;
  padding: 0 22px;
  font-size: .78rem;
  font-weight: 600;
  color: var(--or-clair);
  text-transform: uppercase;
  letter-spacing: .08em;
  display: flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  white-space: nowrap;
  transition: color .25s;
}
.bd-promo-cta:hover { color: #fff; }
@keyframes bdScrollL { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

/* ═══════════════════════════════════
   HERO SLIDER — CORRECTIONS
═══════════════════════════════════ */
.bd-hero {
  position: relative;
  height: 92vh;
  min-height: 600px;
  overflow: hidden;
}
.bd-hero-slide {
  position: absolute;
  inset: 0;
  opacity: 0;
  transition: opacity 1s ease, transform 1.2s ease;
  transform: scale(1.06);
  z-index: 1;
}
.bd-hero-slide.active {
  opacity: 1;
  transform: scale(1);
  z-index: 2;
}
.bd-hero-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
}
.bd-hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, rgba(10,8,6,.78) 0%, rgba(10,8,6,.45) 50%, rgba(10,8,6,.15) 100%);
}

/* CONTENU HERO — remonté vers le centre-haut */
.bd-hero-content {
  position: relative;
  z-index: 5;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;        /* centré verticalement */
  padding-top: 0;                 /* pas de décalage supplémentaire */
  max-width: 640px;
}

/* LABEL — moins d'espace en bas */
.bd-hero-label {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(201,169,110,.15);
  border: 1px solid rgba(201,169,110,.35);
  color: var(--or-clair);
  font-family: var(--ft-accent);
  font-style: italic;
  font-size: .85rem;
  padding: 5px 14px;
  border-radius: 40px;
  margin-bottom: 16px;           /* réduit de 24px → 16px */
  width: fit-content;
  opacity: 0;
  transform: translateY(20px);
  transition: all .7s .2s;
}
.bd-hero-slide.active .bd-hero-label { opacity: 1; transform: translateY(0); }

/* TITRE */
.bd-hero-title {
  font-family: var(--ft-display);
  font-size: clamp(2.2rem, 5vw, 3.6rem); /* légèrement réduit */
  font-weight: 800;
  color: #fff;
  line-height: 1.08;
  margin-bottom: 16px;           /* réduit de 24px → 16px */
  opacity: 0;
  transform: translateY(30px);
  transition: all .7s .4s;
}
.bd-hero-slide.active .bd-hero-title { opacity: 1; transform: translateY(0); }
.bd-hero-title em { font-style: italic; color: var(--or-clair); }

/* DESCRIPTION */
.bd-hero-desc {
  color: rgba(255,255,255,.78);
  font-size: 1rem;               /* légèrement réduit */
  line-height: 1.7;
  margin-bottom: 28px;           /* réduit de 38px → 28px */
  max-width: 500px;
  opacity: 0;
  transform: translateY(20px);
  transition: all .7s .6s;
}
.bd-hero-slide.active .bd-hero-desc { opacity: 1; transform: translateY(0); }

/* BOUTONS — taille réduite */
.bd-hero-btns {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  opacity: 0;
  transform: translateY(20px);
  transition: all .7s .75s;
}
.bd-hero-slide.active .bd-hero-btns { opacity: 1; transform: translateY(0); }

/* Bouton hero primaire — plus petit */
.bd-hero-btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 11px 24px;            /* réduit */
  font-family: var(--ft-body);
  font-size: .82rem;             /* réduit */
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  border-radius: var(--r);
  background: var(--rouge);
  color: #fff;
  border: none;
  text-decoration: none;
  transition: var(--tr);
  box-shadow: 0 4px 20px rgba(184,40,42,.4);
  cursor: pointer;
}
.bd-hero-btn-primary:hover {
  background: var(--rouge-fonce);
  color: #fff;
  transform: translateY(-2px);
}

/* Bouton hero outline — plus petit */
.bd-hero-btn-outline {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 24px;            /* réduit, border 1px */
  font-family: var(--ft-body);
  font-size: .82rem;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  border-radius: var(--r);
  background: transparent;
  color: #fff;
  border: 1.5px solid rgba(255,255,255,.55);
  text-decoration: none;
  transition: var(--tr);
  cursor: pointer;
}
.bd-hero-btn-outline:hover {
  background: rgba(255,255,255,.12);
  border-color: #fff;
  color: #fff;
  transform: translateY(-2px);
}

/* ── NAVIGATION HERO — cercle parfait, hors du texte ── */
.bd-hero-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 7;
  width: 100%;
  display: flex;
  justify-content: space-between;
  padding: 0 16px;               /* rapproché des bords */
  pointer-events: none;
}

.bd-hero-nav-btn {
  pointer-events: all;
  /* CERCLE PARFAIT */
  width: 44px;
  height: 44px;
  min-width: 44px;
  min-height: 44px;
  border-radius: 50% !important; /* force le cercle */
  aspect-ratio: 1 / 1;
  box-sizing: border-box;

  background: rgba(255,255,255,.15);
  border: 1.5px solid rgba(255,255,255,.4) !important;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .85rem;
  cursor: pointer;
  transition: var(--tr);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  padding: 0;
  line-height: 1;
  /* empêche l'étirement */
  flex-shrink: 0;
}
.bd-hero-nav-btn:hover {
  background: var(--rouge) !important;
  border-color: var(--rouge) !important;
  transform: scale(1.08);
}
.bd-hero-nav-btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

/* DOTS */
.bd-hero-dots {
  position: absolute;
  bottom: 110px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 7;
  display: flex;
  gap: 8px;
}
.bd-hero-dot {
  width: 8px; height: 8px;
  border-radius: 4px;
  background: rgba(255,255,255,.4);
  cursor: pointer;
  transition: all .35s;
  border: none; padding: 0;
}
.bd-hero-dot.active { width: 28px; background: var(--rouge); }

/* STATS BAR */
.bd-stats-bar {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  z-index: 6;
  background: rgba(255,255,255,.97);
  backdrop-filter: blur(12px);
  border-top: 3px solid var(--rouge);
}
.bd-stats-bar-inner {
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 40px;
}
.bd-stat-item {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  padding: 20px 16px;
  border-right: 1px solid rgba(0,0,0,.07);
  transition: var(--tr);
}
.bd-stat-item:last-child { border-right: none; }
.bd-stat-item:hover { background: var(--creme); }
.bd-stat-icon {
  width: 44px; height: 44px;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1.1rem; flex-shrink: 0;
}
.bd-stat-value {
  font-family: var(--ft-display);
  font-size: 1.6rem; font-weight: 700; color: var(--rouge); line-height: 1;
}
.bd-stat-label {
  font-size: .75rem; color: var(--gris);
  text-transform: uppercase; letter-spacing: .06em; font-weight: 500; margin-top: 4px;
}

/* ═══════════════════════════════════
   SERVICES
═══════════════════════════════════ */
.bd-services-section {
  padding: 100px 0;
  background: var(--blanc);
  position: relative; overflow: hidden;
}
.bd-services-section::before {
  content: 'SERVICES';
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%,-50%);
  font-family: var(--ft-display); font-size: 14vw; font-weight: 900;
  color: rgba(0,0,0,.024); white-space: nowrap; pointer-events: none;
}
.bd-services-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
.bd-service-card {
  background: var(--blanc-pur);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg);
  padding: 40px 32px;
  transition: var(--tr);
  position: relative; overflow: hidden;
}
.bd-service-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 4px; height: 0;
  background: linear-gradient(180deg, var(--rouge), var(--or));
  transition: height .45s cubic-bezier(.4,0,.2,1);
}
.bd-service-card:hover::before { height: 100%; }
.bd-service-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: transparent; }
.bd-service-icon-wrap {
  width: 64px; height: 64px;
  background: linear-gradient(135deg, rgba(184,40,42,.08), rgba(184,40,42,.04));
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 24px; transition: var(--tr);
}
.bd-service-card:hover .bd-service-icon-wrap { background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce)); }
.bd-service-icon { font-size: 1.5rem; color: var(--rouge); transition: color .3s; }
.bd-service-card:hover .bd-service-icon { color: #fff; }
.bd-service-title { font-family: var(--ft-display); font-size: 1.15rem; font-weight: 600; color: var(--noir); margin-bottom: 12px; }
.bd-service-desc { font-size: .88rem; color: var(--gris); line-height: 1.7; }
.bd-service-link {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 20px; font-size: .8rem; font-weight: 600; color: var(--rouge);
  letter-spacing: .06em; text-transform: uppercase;
  opacity: 0; transition: all .3s; text-decoration: none;
}
.bd-service-card:hover .bd-service-link { opacity: 1; }

/* ═══════════════════════════════════
   PRODUITS
═══════════════════════════════════ */
.bd-products-section { padding: 100px 0; background: var(--creme); }
.bd-products-tabs {
  display: flex; align-items: center; justify-content: center;
  gap: 6px; margin-bottom: 50px; flex-wrap: wrap;
}
.bd-product-tab {
  padding: 9px 22px; border-radius: 40px; font-size: .82rem; font-weight: 500;
  color: var(--gris); border: 1.5px solid var(--gris-clair);
  background: transparent; cursor: pointer; transition: var(--tr); letter-spacing: .03em;
}
.bd-product-tab.active, .bd-product-tab:hover { background: var(--rouge); color: #fff; border-color: var(--rouge); }
.bd-products-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; }
.bd-product-card {
  background: var(--blanc-pur); border-radius: var(--r-lg);
  overflow: hidden; box-shadow: var(--shadow-sm); transition: var(--tr); cursor: pointer;
}
.bd-product-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
.bd-product-img-wrap { position: relative; overflow: hidden; aspect-ratio: 4/3; background: var(--gris-clair); }
.bd-product-img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.bd-product-card:hover .bd-product-img { transform: scale(1.08); }
.bd-product-badge {
  position: absolute; top: 14px; left: 14px;
  padding: 5px 12px; border-radius: 4px;
  font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; z-index: 2;
}
.bd-badge-promo { background: var(--rouge); color: #fff; }
.bd-badge-nouveau { background: #2D7D46; color: #fff; }
.bd-badge-vedette { background: var(--or); color: var(--noir); }
.bd-product-actions {
  position: absolute; top: 14px; right: 14px;
  display: flex; flex-direction: column; gap: 8px;
  opacity: 0; transform: translateX(10px); transition: all .3s; z-index: 3;
}
.bd-product-card:hover .bd-product-actions { opacity: 1; transform: translateX(0); }
.bd-product-action-btn {
  width: 36px; height: 36px;
  background: rgba(255,255,255,.95); border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: var(--gris-fonce); font-size: .85rem; cursor: pointer;
  transition: var(--tr); border: none; box-shadow: var(--shadow-sm);
}
.bd-product-action-btn:hover { background: var(--rouge); color: #fff; }
.bd-product-info { padding: 20px 20px 0; }
.bd-product-category { font-size: .73rem; color: var(--rouge); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; margin-bottom: 6px; }
.bd-product-name { font-family: var(--ft-display); font-size: 1rem; font-weight: 600; color: var(--noir); margin-bottom: 8px; line-height: 1.3; }
.bd-product-pricing { display: flex; align-items: center; gap: 10px; }
.bd-product-price { font-family: var(--ft-display); font-size: 1.1rem; font-weight: 700; color: var(--rouge); }
.bd-product-price-old { font-size: .82rem; color: var(--gris); text-decoration: line-through; }
.bd-product-footer { padding: 12px 20px 18px; display: flex; align-items: center; justify-content: space-between; }
.bd-stars { display: flex; gap: 2px; color: var(--or); font-size: .8rem; }
.bd-btn-add-cart {
  display: flex; align-items: center; gap: 6px;
  padding: 8px 14px; background: var(--rouge); color: #fff;
  border-radius: var(--r); font-size: .75rem; font-weight: 600;
  letter-spacing: .04em; text-transform: uppercase;
  border: none; cursor: pointer; transition: var(--tr);
}
.bd-btn-add-cart:hover { background: var(--rouge-fonce); }

/* ═══════════════════════════════════
   CTA SECTION
═══════════════════════════════════ */
.bd-cta-section { position: relative; padding: 100px 0; overflow: hidden; }
.bd-cta-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1800&q=80');
  background-size: cover; background-position: center; background-attachment: fixed;
}
.bd-cta-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(139,26,28,.93) 0%, rgba(25,20,17,.88) 60%, rgba(139,26,28,.75) 100%);
}
.bd-cta-content { position: relative; z-index: 2; text-align: center; max-width: 700px; margin: 0 auto; }
.bd-cta-label { font-family: var(--ft-accent); font-style: italic; color: var(--or-clair); font-size: 1rem; letter-spacing: .08em; margin-bottom: 20px; }
.bd-cta-title { font-family: var(--ft-display); font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 20px; }
.bd-cta-subtitle { color: rgba(255,255,255,.78); font-size: .95rem; line-height: 1.75; margin-bottom: 40px; }
.bd-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
.bd-cta-features { display: flex; align-items: center; justify-content: center; gap: 32px; margin-top: 50px; flex-wrap: wrap; }
.bd-cta-feature { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,.85); font-size: .88rem; }
.bd-cta-feature i { color: var(--or); font-size: 1.1rem; }

/* ═══════════════════════════════════
   TÉMOIGNAGES
═══════════════════════════════════ */
.bd-reviews-section { padding: 100px 0; background: var(--blanc); overflow: hidden; }
.bd-reviews-track-wrap {
  overflow: hidden; margin: 0 -20px; padding: 20px;
  -webkit-mask: linear-gradient(90deg, transparent, #fff 8%, #fff 92%, transparent);
  mask: linear-gradient(90deg, transparent, #fff 8%, #fff 92%, transparent);
}
.bd-reviews-track {
  display: flex; gap: 24px;
  animation: bdReviewsScroll 40s linear infinite;
  width: max-content;
}
.bd-reviews-track:hover { animation-play-state: paused; }
@keyframes bdReviewsScroll { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
.bd-review-card {
  width: 360px; flex-shrink: 0;
  background: var(--blanc-pur); border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg); padding: 32px; transition: var(--tr);
}
.bd-review-card:hover { border-color: var(--rouge); box-shadow: var(--shadow-rouge); transform: translateY(-4px); }
.bd-review-stars { display: flex; gap: 3px; color: var(--or); font-size: .9rem; margin-bottom: 18px; }
.bd-review-text { font-family: var(--ft-accent); font-size: 1rem; font-style: italic; color: var(--gris-fonce); line-height: 1.7; margin-bottom: 24px; }
.bd-review-text::before { content: '\201C'; font-size: 2.5rem; color: var(--rouge); line-height: 0; vertical-align: -.5rem; margin-right: 4px; font-style: normal; }
.bd-review-author { display: flex; align-items: center; gap: 14px; padding-top: 18px; border-top: 1px solid var(--gris-clair); }
.bd-review-avatar { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--ft-display); font-size: .95rem; font-weight: 700; color: #fff; flex-shrink: 0; }
.bd-review-name { font-weight: 600; color: var(--noir); font-size: .9rem; }
.bd-review-role { font-size: .78rem; color: var(--gris); }

/* ═══════════════════════════════════
   POURQUOI BAOBO DECO
═══════════════════════════════════ */
.bd-about-section { padding: 100px 0; background: var(--creme); }
.bd-about-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.bd-about-img-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.bd-about-img-item { border-radius: var(--r-lg); overflow: hidden; position: relative; }
.bd-about-img-item:first-child { grid-row: span 2; }
.bd-about-img-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s; }
.bd-about-img-item:hover img { transform: scale(1.06); }
.bd-about-img-badge { position: absolute; bottom: 16px; left: 16px; background: var(--rouge); color: #fff; padding: 10px 16px; border-radius: 8px; font-size: .78rem; font-weight: 600; }
.bd-about-features { display: flex; flex-direction: column; gap: 22px; margin: 36px 0; }
.bd-about-feature { display: flex; align-items: flex-start; gap: 18px; }
.bd-about-feature-icon { width: 48px; height: 48px; flex-shrink: 0; background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce)); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; }
.bd-about-feature-title { font-family: var(--ft-display); font-size: 1rem; font-weight: 600; color: var(--noir); margin-bottom: 4px; }
.bd-about-feature-desc { font-size: .85rem; color: var(--gris); line-height: 1.65; }
.bd-about-stats-row { display: flex; gap: 32px; margin-top: 40px; padding-top: 32px; border-top: 1px solid rgba(0,0,0,.08); }
.bd-about-stat { display: flex; flex-direction: column; }
.bd-about-stat-value { font-family: var(--ft-display); font-size: 2.2rem; font-weight: 800; color: var(--rouge); line-height: 1; }
.bd-about-stat-label { font-size: .78rem; color: var(--gris); text-transform: uppercase; letter-spacing: .06em; margin-top: 6px; }

/* ═══════════════════════════════════
   CONTACT — SECTION COMPLÈTE
═══════════════════════════════════ */
.bd-contact-section { padding: 80px 0; background: var(--noir-doux); }
.bd-contact-grid {
  display: grid;
  grid-template-columns: 1fr 1.2fr;  /* formulaire légèrement plus large */
  gap: 80px;
  align-items: start;
}
.bd-contact-label { font-family: var(--ft-accent); font-style: italic; color: var(--or-clair); font-size: .9rem; margin-bottom: 14px; display: block; }
.bd-contact-title { font-family: var(--ft-display); font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 700; color: #fff; line-height: 1.2; margin-bottom: 16px; }
.bd-contact-subtitle { color: rgba(255,255,255,.6); font-size: .9rem; line-height: 1.7; margin-bottom: 32px; }
.bd-contact-details { display: flex; flex-direction: column; gap: 16px; }
.bd-contact-item { display: flex; align-items: center; gap: 14px; color: rgba(255,255,255,.8); font-size: .9rem; }
.bd-contact-item-icon {
  width: 38px; height: 38px;
  background: rgba(184,40,42,.3);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: var(--rouge-clair); font-size: .9rem; flex-shrink: 0;
}
.bd-contact-item a { color: rgba(255,255,255,.8); text-decoration: none; }
.bd-contact-item a:hover { color: var(--or-clair); }
.bd-socials { display: flex; gap: 10px; margin-top: 28px; }
.bd-social-btn {
  width: 40px; height: 40px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; transition: var(--tr);
  border: 1px solid rgba(255,255,255,.15); color: rgba(255,255,255,.6); text-decoration: none;
}
.bd-social-btn:hover { background: var(--rouge); border-color: var(--rouge); color: #fff; transform: translateY(-3px); }

/* ── FORMULAIRE CONTACT ── */
.bd-form-wrapper {
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.08);
  border-radius: var(--r-lg);
  padding: 36px;
}
.bd-form-title {
  font-family: var(--ft-display);
  font-size: 1.4rem;
  font-weight: 600;
  color: #fff;
  margin-bottom: 28px;
}
.bd-form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.bd-form-full { grid-column: 1 / -1; }
.bd-form-group { display: flex; flex-direction: column; gap: 6px; }
.bd-form-label {
  font-size: .72rem;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: rgba(255,255,255,.5);
}
.bd-form-input,
.bd-form-textarea,
.bd-form-select {
  width: 100%;
  padding: 12px 16px;
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.12);
  border-radius: var(--r);
  color: #fff;
  font-family: var(--ft-body);
  font-size: .88rem;
  font-weight: 400;
  transition: var(--tr);
  outline: none;
  appearance: none;
  -webkit-appearance: none;
}
.bd-form-input::placeholder,
.bd-form-textarea::placeholder { color: rgba(255,255,255,.3); }
.bd-form-input:focus,
.bd-form-textarea:focus,
.bd-form-select:focus {
  border-color: rgba(184,40,42,.7);
  background: rgba(255,255,255,.09);
  box-shadow: 0 0 0 3px rgba(184,40,42,.15);
}
.bd-form-select { cursor: pointer; }
.bd-form-select option { background: #1A1A1A; color: #fff; }
.bd-form-textarea { resize: vertical; min-height: 110px; }

/* ── BOUTONS PARTAGÉS ── */
.bd-btn-primary2 {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 13px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); transition: var(--tr); cursor: pointer;
  background: var(--rouge); color: #fff; border: none; text-decoration: none;
  box-shadow: var(--shadow-rouge);
}
.bd-btn-primary2:hover { background: var(--rouge-fonce); color: #fff; transform: translateY(-2px); }
.bd-btn-outline2 {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); transition: var(--tr); cursor: pointer;
  background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,.55);
  text-decoration: none;
}
.bd-btn-outline2:hover { background: rgba(255,255,255,.12); border-color: #fff; color: #fff; transform: translateY(-2px); }
.bd-btn-or2 {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); transition: var(--tr); cursor: pointer;
  background: transparent; color: var(--or); border: 1.5px solid var(--or);
  text-decoration: none;
}
.bd-btn-or2:hover { background: var(--or); color: var(--noir); transform: translateY(-2px); }
.bd-btn-border2 {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); transition: var(--tr); cursor: pointer;
  background: transparent; color: var(--rouge); border: 1.5px solid var(--rouge);
  text-decoration: none;
}
.bd-btn-border2:hover { background: var(--rouge); color: #fff; transform: translateY(-2px); }

/* ── NEWSLETTER ── */
.bd-newsletter-form h3 { font-family: var(--ft-display); font-size: 1.3rem; color: #fff; margin-bottom: 8px; }
.bd-newsletter-form > p { color: rgba(255,255,255,.55); font-size: .85rem; margin-bottom: 24px; }
.bd-input-group { display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; }
.bd-input-field {
  width: 100%; padding: 13px 16px;
  background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12);
  border-radius: var(--r); color: #fff; font-family: var(--ft-body);
  font-size: .88rem; outline: none; transition: var(--tr);
}
.bd-input-field::placeholder { color: rgba(255,255,255,.35); }
.bd-input-field:focus { border-color: rgba(184,40,42,.6); background: rgba(255,255,255,.1); }

/* ── LABELS SECTION ── */
.bd-section-label2 {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: var(--ft-accent); font-size: .9rem; font-style: italic;
  color: var(--rouge); letter-spacing: .05em; margin-bottom: 16px;
}
.bd-section-label2::before, .bd-section-label2::after {
  content: ''; width: 30px; height: 1px; background: var(--rouge); display: block;
}
.bd-section-title2 { font-family: var(--ft-display); font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; line-height: 1.15; color: var(--noir); }
.bd-section-title2 .bd-accent { color: var(--rouge); }
.bd-section-sub2 { font-size: .95rem; color: var(--gris); max-width: 600px; margin: 16px auto 0; line-height: 1.7; }
.bd-section-head2 { text-align: center; margin-bottom: 60px; }
.bd-divider2 { width: 50px; height: 3px; background: linear-gradient(90deg, var(--rouge), var(--or)); margin: 20px auto 0; border-radius: 2px; }

/* ── CONTAINER ── */
.bd-container2 { max-width: 1280px; margin: 0 auto; padding: 0 40px; }

/* ── REVEAL ── */
.bd-reveal2 { opacity: 0; transform: translateY(40px); transition: opacity .7s cubic-bezier(.4,0,.2,1), transform .7s cubic-bezier(.4,0,.2,1); }
.bd-reveal2.bd-visible2 { opacity: 1; transform: translateY(0); }
.bd-delay-1 { transition-delay: .1s; }
.bd-delay-2 { transition-delay: .2s; }
.bd-delay-3 { transition-delay: .3s; }

/* ═══════════════════════════════════
   RESPONSIVE
═══════════════════════════════════ */
@media (max-width: 1200px) { .bd-products-grid { grid-template-columns: repeat(3,1fr); } }
@media (max-width: 1024px) {
  .bd-services-grid { grid-template-columns: repeat(2,1fr); }
  .bd-about-inner { grid-template-columns: 1fr; gap: 48px; }
  .bd-contact-grid { grid-template-columns: 1fr; gap: 48px; }
  .bd-form-grid { grid-template-columns: 1fr; }
  .bd-form-full { grid-column: 1; }
}
@media (max-width: 768px) {
  .bd-container2 { padding: 0 20px; }
  .bd-services-grid { grid-template-columns: 1fr; }
  .bd-products-grid { grid-template-columns: repeat(2,1fr); }
  .bd-about-img-grid { grid-template-columns: 1fr; }
  .bd-about-img-item:first-child { grid-row: span 1; }
  .bd-form-wrapper { padding: 24px; }
}
@media (max-width: 480px) {
  .bd-products-grid { grid-template-columns: 1fr; }
  .bd-hero-btns { flex-direction: column; }
}
</style>

<!-- ══════════════════════════════════════════
     HERO SLIDER
══════════════════════════════════════════ -->
<section class="bd-hero" aria-label="Section principale">
  <div id="bdHeroSlides">
    <?php foreach ($hero_slides as $i => $slide) : ?>
    <div class="bd-hero-slide <?php echo $i === 0 ? 'active' : ''; ?>">
      <div class="bd-hero-bg" style="background-image:url('<?php echo esc_attr($slide->image_bg); ?>')"></div>
      <div class="bd-hero-overlay"></div>
      <div class="bd-container2" style="height:100%;display:flex;flex-direction:column;justify-content:center;">
        <div class="bd-hero-content">
          <div class="bd-hero-label">
            <i class="fas fa-star"></i>
            <?php echo esc_html($slide->badge); ?>
          </div>
          <h1 class="bd-hero-title">
            <?php echo esc_html($slide->titre); ?><br>
            <em><?php echo esc_html($slide->titre_accent); ?></em>
          </h1>
          <p class="bd-hero-desc"><?php echo esc_html($slide->description); ?></p>
          <div class="bd-hero-btns">
            <a href="<?php echo esc_url(home_url($slide->btn1_lien)); ?>" class="bd-hero-btn-primary">
              <i class="fas fa-store"></i> <?php echo esc_html($slide->btn1_texte); ?>
            </a>
            <a href="<?php echo esc_url(home_url($slide->btn2_lien)); ?>" class="bd-hero-btn-outline">
              <i class="fas fa-file-alt"></i> <?php echo esc_html($slide->btn2_texte); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <?php if (empty($hero_slides)) : ?>
    <div class="bd-hero-slide active">
      <div class="bd-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1800&q=85')"></div>
      <div class="bd-hero-overlay"></div>
      <div class="bd-container2" style="height:100%;display:flex;flex-direction:column;justify-content:center;">
        <div class="bd-hero-content">
          <div class="bd-hero-label"><i class="fas fa-star"></i> Décoration &amp; Aménagement Premium · Ouagadougou</div>
          <h1 class="bd-hero-title">Transformez votre espace avec<br><em>BAOBO DECO</em></h1>
          <p class="bd-hero-desc">Meubles haut de gamme, décoration intérieure et aménagement sur mesure à Ouagadougou. Livraison et pose incluses.</p>
          <div class="bd-hero-btns">
            <a href="<?php echo esc_url(home_url('/boutique')); ?>" class="bd-hero-btn-primary"><i class="fas fa-store"></i> Voir la Boutique</a>
            <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-hero-btn-outline"><i class="fas fa-file-alt"></i> Demander un Devis</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Navigation — boutons en dehors de la zone de texte -->
  <div class="bd-hero-nav">
    <button class="bd-hero-nav-btn" id="bdHeroPrev" aria-label="Précédent">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button class="bd-hero-nav-btn" id="bdHeroNext" aria-label="Suivant">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
  <div class="bd-hero-dots" id="bdHeroDots" role="tablist"></div>

  <!-- Stats Bar -->
  <div class="bd-stats-bar">
    <div class="bd-stats-bar-inner">
      <?php foreach ($stats as $stat) : ?>
      <div class="bd-stat-item">
        <div class="bd-stat-icon"><i class="<?php echo esc_attr($stat->icone_fa); ?>"></i></div>
        <div>
          <div class="bd-stat-value" data-counter="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $stat->valeur)); ?>">
            <?php echo esc_html($stat->valeur . $stat->suffixe); ?>
          </div>
          <div class="bd-stat-label"><?php echo esc_html($stat->label); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     PROMO BANNER
══════════════════════════════════════════ -->
<div class="bd-promo-banner">
  <div class="bd-promo-badge"><i class="fas fa-bolt"></i> Offres</div>
  <div class="bd-promo-scroll">
    <div class="bd-promo-scroll-inner">
      <?php
      $html = '';
      foreach ($promo_items as $item) {
        $html .= '<span class="bd-promo-item"><i class="fas fa-circle" style="font-size:.4rem;"></i>' . esc_html($item) . '</span>';
      }
      echo $html . $html;
      ?>
    </div>
  </div>
  <a href="<?php echo esc_url(home_url('/boutique')); ?>" class="bd-promo-cta">
    Voir tout <i class="fas fa-arrow-right"></i>
  </a>
</div>

<!-- ══════════════════════════════════════════
     NOS SERVICES
══════════════════════════════════════════ -->
<section class="bd-services-section" id="services">
  <div class="bd-container2">
    <div class="bd-section-head2 bd-reveal2">
      <p class="bd-section-label2">Ce que nous faisons</p>
      <h2 class="bd-section-title2">Nos <span class="bd-accent">Services</span></h2>
      <div class="bd-divider2"></div>
      <p class="bd-section-sub2">De la décoration d'intérieur à l'installation complète, nous prenons en charge chaque aspect de votre projet.</p>
    </div>
    <div class="bd-services-grid">
      <?php foreach ($services as $i => $service) : ?>
      <div class="bd-service-card bd-reveal2 bd-delay-<?php echo ($i%3)+1; ?>">
        <div class="bd-service-icon-wrap">
          <i class="<?php echo esc_attr($service->icone_fa); ?> bd-service-icon"></i>
        </div>
        <h3 class="bd-service-title"><?php echo esc_html($service->titre); ?></h3>
        <p class="bd-service-desc"><?php echo esc_html($service->description); ?></p>
        <a href="<?php echo esc_url(home_url($service->lien)); ?>" class="bd-service-link">
          En savoir plus <i class="fas fa-arrow-right"></i>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:50px;" class="bd-reveal2">
      <a href="<?php echo esc_url(home_url('/services')); ?>" class="bd-btn-border2">
        Voir tous nos services <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     PRODUITS VEDETTES
══════════════════════════════════════════ -->
<section class="bd-products-section" id="produits">
  <div class="bd-container2">
    <div class="bd-section-head2 bd-reveal2">
      <p class="bd-section-label2">Notre sélection</p>
      <h2 class="bd-section-title2">Produits <span class="bd-accent">Vedettes</span></h2>
      <div class="bd-divider2"></div>
      <p class="bd-section-sub2">Découvrez notre sélection de meubles et objets déco les plus appréciés.</p>
    </div>
    <div class="bd-products-tabs" role="tablist">
      <button class="bd-product-tab active" data-filter="tous">Tous</button>
      <button class="bd-product-tab" data-filter="salon">Salon</button>
      <button class="bd-product-tab" data-filter="chambre">Chambre</button>
      <button class="bd-product-tab" data-filter="deco">Décoration</button>
      <button class="bd-product-tab" data-filter="promo">Promotions</button>
    </div>
    <div class="bd-products-grid" id="bdProductsGrid">
      <?php foreach ($produits as $i => $produit) :
        $cat_labels  = ['salon'=>'Salon','chambre'=>'Chambre','deco'=>'Décoration','bureau'=>'Bureau','hotel'=>'Hôtel'];
        $cat_label   = $cat_labels[$produit->categorie] ?? ucfirst($produit->categorie);
        $badge_class = $produit->badge === 'promo' ? 'bd-badge-promo' : ($produit->badge === 'nouveau' ? 'bd-badge-nouveau' : 'bd-badge-vedette');
        $badge_label = $produit->badge === 'promo' ? 'Promo' : ($produit->badge === 'nouveau' ? 'Nouveau' : 'Vedette');
        $stars       = str_repeat('<i class="fas fa-star"></i>', min(5, (int)$produit->note));
      ?>
      <div class="bd-product-card bd-reveal2 bd-delay-<?php echo ($i%4)+1; ?>"
           data-cat="<?php echo esc_attr($produit->categorie); ?>"
           data-badge="<?php echo esc_attr($produit->badge); ?>">
        <div class="bd-product-img-wrap">
          <?php if ($produit->badge) : ?>
          <span class="bd-product-badge <?php echo $badge_class; ?>"><?php echo $badge_label; ?></span>
          <?php endif; ?>
          <img class="bd-product-img" src="<?php echo esc_url($produit->image_url); ?>" alt="<?php echo esc_attr($produit->nom); ?>" loading="lazy">
          <div class="bd-product-actions">
            <button class="bd-product-action-btn" aria-label="Favoris"><i class="far fa-heart"></i></button>
            <button class="bd-product-action-btn" aria-label="Aperçu"><i class="fas fa-eye"></i></button>
          </div>
        </div>
        <div class="bd-product-info">
          <p class="bd-product-category"><?php echo esc_html($cat_label); ?></p>
          <h3 class="bd-product-name"><?php echo esc_html($produit->nom); ?></h3>
          <div class="bd-product-pricing">
            <span class="bd-product-price"><?php echo esc_html($produit->prix); ?> FCFA</span>
            <?php if ($produit->prix_ancien) : ?>
            <span class="bd-product-price-old"><?php echo esc_html($produit->prix_ancien); ?> FCFA</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="bd-product-footer">
          <div class="bd-stars"><?php echo $stars; ?></div>
          <button class="bd-btn-add-cart"><i class="fas fa-cart-plus"></i> Ajouter</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:50px;" class="bd-reveal2">
      <a href="<?php echo esc_url(home_url('/boutique')); ?>" class="bd-btn-primary2">
        <i class="fas fa-store"></i> Voir toute la boutique
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     CTA DEVIS
══════════════════════════════════════════ -->
<section class="bd-cta-section">
  <div class="bd-cta-bg"></div>
  <div class="bd-cta-overlay"></div>
  <div class="bd-container2">
    <div class="bd-cta-content bd-reveal2">
      <p class="bd-cta-label">Votre intérieur mérite le meilleur</p>
      <h2 class="bd-cta-title"><?php echo esc_html(bd_get('cta_titre', 'Demandez votre devis gratuit')); ?></h2>
      <p class="bd-cta-subtitle"><?php echo esc_html(bd_get('cta_sous_titre', 'Nos experts vous répondent sous 24h avec une proposition personnalisée et sans engagement.')); ?></p>
      <div class="bd-cta-btns">
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-btn-primary2">
          <i class="fas fa-file-invoice"></i> Demander un Devis
        </a>
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-btn-or2">
          <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
      </div>
      <div class="bd-cta-features">
        <div class="bd-cta-feature"><i class="fas fa-check-circle"></i> Consultation gratuite</div>
        <div class="bd-cta-feature"><i class="fas fa-check-circle"></i> Réponse sous 24h</div>
        <div class="bd-cta-feature"><i class="fas fa-check-circle"></i> Sans engagement</div>
        <div class="bd-cta-feature"><i class="fas fa-check-circle"></i> Livraison incluse</div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     AVIS CLIENTS
══════════════════════════════════════════ -->
<section class="bd-reviews-section">
  <div class="bd-container2">
    <div class="bd-section-head2 bd-reveal2">
      <p class="bd-section-label2">Ils nous font confiance</p>
      <h2 class="bd-section-title2">Avis de nos <span class="bd-accent">Clients</span></h2>
      <div class="bd-divider2"></div>
    </div>
  </div>
  <div class="bd-reviews-track-wrap">
    <div class="bd-reviews-track" id="bdReviewsTrack">
      <?php
      $cards_html = '';
      foreach ($temoignages as $t) {
        $s = str_repeat('<i class="fas fa-star"></i>', min(5, (int)$t->note));
        $cards_html .= '<div class="bd-review-card">';
        $cards_html .= '<div class="bd-review-stars">' . $s . '</div>';
        $cards_html .= '<p class="bd-review-text">' . esc_html($t->texte) . '</p>';
        $cards_html .= '<div class="bd-review-author">';
        $cards_html .= '<div class="bd-review-avatar" style="background:' . esc_attr($t->couleur) . '">' . esc_html($t->initiales) . '</div>';
        $cards_html .= '<div><p class="bd-review-name">' . esc_html($t->nom) . '</p><p class="bd-review-role">' . esc_html($t->role) . '</p></div>';
        $cards_html .= '</div></div>';
      }
      echo $cards_html . $cards_html;
      ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     POURQUOI BAOBO DECO
══════════════════════════════════════════ -->
<section class="bd-about-section">
  <div class="bd-container2">
    <div class="bd-about-inner">
      <div class="bd-about-img-grid bd-reveal2">
        <div class="bd-about-img-item" style="height:480px;">
          <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=600&q=80" alt="Réalisation BAOBO DECO" loading="lazy">
          <div class="bd-about-img-badge"><i class="fas fa-award"></i> Qualité Premium</div>
        </div>
        <div class="bd-about-img-item" style="height:230px;">
          <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600&q=80" alt="Intérieur BAOBO DECO" loading="lazy">
        </div>
        <div class="bd-about-img-item" style="height:230px;">
          <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80" alt="Meubles BAOBO DECO" loading="lazy">
        </div>
      </div>
      <div class="bd-reveal2 bd-delay-2">
        <p class="bd-section-label2">Pourquoi nous choisir</p>
        <h2 class="bd-section-title2" style="text-align:left;">L'Excellence <span class="bd-accent">BAOBO DECO</span></h2>
        <div class="bd-divider2" style="margin-left:0;"></div>
        <div class="bd-about-features">
          <?php foreach ($atouts as $atout) : ?>
          <div class="bd-about-feature">
            <div class="bd-about-feature-icon"><i class="<?php echo esc_attr($atout->icone_fa); ?>"></i></div>
            <div>
              <p class="bd-about-feature-title"><?php echo esc_html($atout->titre); ?></p>
              <p class="bd-about-feature-desc"><?php echo esc_html($atout->description); ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="bd-about-stats-row">
          <?php foreach ($stats as $stat) : ?>
          <div class="bd-about-stat">
            <span class="bd-about-stat-value"><?php echo esc_html($stat->valeur . $stat->suffixe); ?></span>
            <span class="bd-about-stat-label"><?php echo esc_html($stat->label); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     CONTACT COMPLET (infos + formulaire)
══════════════════════════════════════════ -->
<section class="bd-contact-section">
  <div class="bd-container2">
    <div class="bd-contact-grid">

      <!-- Colonne gauche : infos -->
      <div class="bd-reveal2">
        <span class="bd-contact-label">Contactez-nous</span>
        <h2 class="bd-contact-title">Parlons de<br>votre projet</h2>
        <p class="bd-contact-subtitle">Notre équipe est disponible du lundi au samedi de 8h à 18h pour répondre à toutes vos questions.</p>

        <?php
        $tel1  = bd_get('telephone1', '+226 07 59 29 97');
        $tel2  = bd_get('telephone2', '');
        $email = bd_get('email', 'contact@baobodeco.bf');
        $addr  = bd_get('adresse', 'Tampouy, Ouagadougou, Burkina Faso');
        $fb    = bd_get('facebook_url', '');
        ?>

        <div class="bd-contact-details">
          <div class="bd-contact-item">
            <div class="bd-contact-item-icon"><i class="fas fa-phone-alt"></i></div>
            <div>
              <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $tel1)); ?>"><?php echo esc_html($tel1); ?></a>
              <?php if ($tel2) : ?>
              &nbsp;—&nbsp;<a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $tel2)); ?>"><?php echo esc_html($tel2); ?></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="bd-contact-item">
            <div class="bd-contact-item-icon"><i class="fas fa-envelope"></i></div>
            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
          </div>
          <div class="bd-contact-item">
            <div class="bd-contact-item-icon"><i class="fas fa-map-marker-alt"></i></div>
            <span><?php echo esc_html($addr); ?></span>
          </div>
          <div class="bd-contact-item">
            <div class="bd-contact-item-icon"><i class="fab fa-whatsapp"></i></div>
            <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">WhatsApp disponible</a>
          </div>
          <div class="bd-contact-item">
            <div class="bd-contact-item-icon"><i class="fas fa-clock"></i></div>
            <span>Lun – Sam : 8h à 18h &nbsp;|&nbsp; Dim : 9h à 13h</span>
          </div>
        </div>

        <div class="bd-socials">
          <?php if ($fb) : ?>
          <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener" class="bd-social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <?php endif; ?>
          <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a href="<?php echo esc_url(bd_get('instagram_url','#')); ?>" target="_blank" rel="noopener" class="bd-social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="<?php echo esc_url(bd_get('tiktok_url','#')); ?>" target="_blank" rel="noopener" class="bd-social-btn" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>

      <!-- Colonne droite : formulaire complet -->
      <div class="bd-reveal2 bd-delay-2">
        <div class="bd-form-wrapper">
          <h3 class="bd-form-title">Envoyez-nous un message</h3>

          <form method="POST" action="<?php echo esc_url(home_url('/contact')); ?>">
            <?php wp_nonce_field('bd_contact_form', 'bd_contact_nonce'); ?>

            <div class="bd-form-grid">

              <div class="bd-form-group">
                <label class="bd-form-label" for="bd_nom">Nom complet *</label>
                <input type="text" id="bd_nom" name="nom" class="bd-form-input"
                       placeholder="Votre nom complet" required>
              </div>

              <div class="bd-form-group">
                <label class="bd-form-label" for="bd_tel">Téléphone *</label>
                <input type="tel" id="bd_tel" name="telephone" class="bd-form-input"
                       placeholder="+226 00 00 00 00" required>
              </div>

              <div class="bd-form-group">
                <label class="bd-form-label" for="bd_email">Email</label>
                <input type="email" id="bd_email" name="email" class="bd-form-input"
                       placeholder="votre@email.com">
              </div>

              <div class="bd-form-group">
                <label class="bd-form-label" for="bd_projet">Type de projet</label>
                <select id="bd_projet" name="projet" class="bd-form-select">
                  <option value="">Choisir...</option>
                  <option value="Décoration salon">Décoration salon</option>
                  <option value="Chambre à coucher">Chambre à coucher</option>
                  <option value="Bureau / Open space">Bureau / Open space</option>
                  <option value="Restaurant / Maquis">Restaurant / Maquis</option>
                  <option value="Hôtel / Résidence">Hôtel / Résidence</option>
                  <option value="Autre">Autre</option>
                </select>
              </div>

              <div class="bd-form-group bd-form-full">
                <label class="bd-form-label" for="bd_message">Message *</label>
                <textarea id="bd_message" name="message" class="bd-form-textarea"
                          placeholder="Décrivez votre projet, vos besoins, votre budget approximatif..."
                          required></textarea>
              </div>

            </div><!-- .bd-form-grid -->

            <!-- Notification succès/erreur -->
            <?php if (isset($_GET['contact']) && $_GET['contact'] === 'ok') : ?>
            <div style="background:rgba(45,125,70,.2);border:1px solid rgba(45,125,70,.4);border-radius:var(--r);padding:12px 16px;margin-bottom:16px;color:#6fcf97;font-size:.88rem;display:flex;align-items:center;gap:10px;">
              <i class="fas fa-check-circle"></i> Message envoyé ! Nous vous répondons sous 24h.
            </div>
            <?php endif; ?>

            <button type="submit" class="bd-btn-primary2" style="width:100%;justify-content:center;margin-top:20px;">
              <i class="fas fa-paper-plane"></i> Envoyer le message
            </button>

          </form>
        </div><!-- .bd-form-wrapper -->
      </div>

    </div><!-- .bd-contact-grid -->
  </div>
</section>

<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
(function() {
'use strict';

/* ── HERO SLIDER ── */
(function() {
  const slides   = document.querySelectorAll('.bd-hero-slide');
  const dotsWrap = document.getElementById('bdHeroDots');
  const btnPrev  = document.getElementById('bdHeroPrev');
  const btnNext  = document.getElementById('bdHeroNext');
  if (!slides.length) return;

  let current = 0, timer;

  slides.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.className = 'bd-hero-dot' + (i === 0 ? ' active' : '');
    dot.setAttribute('role', 'tab');
    dot.setAttribute('aria-label', 'Diapositive ' + (i + 1));
    dot.addEventListener('click', () => goTo(i));
    dotsWrap.appendChild(dot);
  });

  function goTo(idx) {
    const dots = dotsWrap.querySelectorAll('.bd-hero-dot');
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (idx + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
    resetTimer();
  }

  function resetTimer() {
    clearInterval(timer);
    timer = setInterval(() => goTo(current + 1), 6000);
  }

  btnNext && btnNext.addEventListener('click', () => goTo(current + 1));
  btnPrev && btnPrev.addEventListener('click', () => goTo(current - 1));
  resetTimer();
})();

/* ── FILTRES PRODUITS ── */
(function() {
  const tabs  = document.querySelectorAll('.bd-product-tab');
  const cards = document.querySelectorAll('#bdProductsGrid .bd-product-card');

  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      tabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      const filter = this.dataset.filter;
      cards.forEach(card => {
        let show = false;
        if (filter === 'tous')        show = true;
        else if (filter === 'promo')  show = card.dataset.badge === 'promo';
        else                          show = card.dataset.cat === filter;
        card.style.display = show ? '' : 'none';
      });
    });
  });
})();

/* ── SCROLL REVEAL ── */
(function() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.bd-reveal2').forEach(el => el.classList.add('bd-visible2'));
    return;
  }
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('bd-visible2'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.bd-reveal2').forEach(el => obs.observe(el));
})();

/* ── COUNTER ANIMATION ── */
(function() {
  if (!('IntersectionObserver' in window)) return;
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const el     = e.target;
      const raw    = el.dataset.counter || el.textContent.replace(/[^0-9]/g, '');
      if (!raw) return;
      const target = parseInt(raw);
      const suffix = el.textContent.replace(/[0-9]/g, '').trim();
      let n = 0;
      const step = Math.max(1, Math.floor(target / 60));
      const iv = setInterval(() => {
        n = Math.min(n + step, target);
        el.textContent = n + (suffix || '');
        if (n >= target) clearInterval(iv);
      }, 25);
      obs.unobserve(el);
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('.bd-stat-value[data-counter], .bd-about-stat-value').forEach(c => obs.observe(c));
})();

})();
</script>

<?php get_footer(); ?>