<?php
/**
 * Template Name: Page Galerie BAOBO DECO
 * page-galerie.php
 */

get_header();

global $wpdb;

function bd_get_gl($key, $default='') {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$galerie = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_galerie WHERE actif=1 ORDER BY ordre ASC");

$wa_num = bd_get_gl('whatsapp_num', '22607592997');
$wa_msg = bd_get_gl('whatsapp_msg', 'Bonjour BAOBO DECO, j\'ai vu votre galerie et je souhaite un projet similaire.');
$wa_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode($wa_msg);
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

.bd-gl * { box-sizing: border-box; }
.bd-gl img { max-width: 100%; display: block; }
.bd-gl a { text-decoration: none; }

/* ═══════════════════════════════════════════
   HERO
═══════════════════════════════════════════ */
.bd-gl-hero {
  position: relative; height: 420px;
  overflow: hidden; display: flex; align-items: center;
}
.bd-gl-hero-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1800&q=80');
  background-size: cover; background-position: center;
}
.bd-gl-hero-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, rgba(10,8,6,.88) 0%, rgba(10,8,6,.6) 60%, rgba(10,8,6,.2) 100%);
}
.bd-gl-hero-content {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto; padding: 0 40px; width: 100%;
}
.bd-gl-hero-label {
  display: inline-flex; align-items: center; gap: 8px;
  color: var(--or-clair); font-family: var(--ft-accent);
  font-style: italic; font-size: .9rem; margin-bottom: 16px;
}
.bd-gl-hero-label::before, .bd-gl-hero-label::after {
  content: ''; width: 28px; height: 1px; background: var(--or); display: block;
}
.bd-gl-hero-title {
  font-family: var(--ft-display);
  font-size: clamp(2.2rem, 5vw, 3.8rem);
  font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 20px;
}
.bd-gl-hero-title em { font-style: italic; color: var(--or-clair); }
.bd-gl-hero-bread {
  display: flex; align-items: center; gap: 8px;
  font-size: .82rem; color: rgba(255,255,255,.6);
}
.bd-gl-hero-bread a { color: rgba(255,255,255,.6); transition: color .25s; }
.bd-gl-hero-bread a:hover { color: var(--or-clair); }
.bd-gl-hero-bread i { font-size: .65rem; color: var(--or); }

/* ═══════════════════════════════════════════
   UTILITAIRES
═══════════════════════════════════════════ */
.bd-gl-container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }
.bd-gl-label {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: var(--ft-accent); font-size: .9rem; font-style: italic;
  color: var(--rouge); letter-spacing: .05em; margin-bottom: 14px;
}
.bd-gl-label::before, .bd-gl-label::after {
  content: ''; width: 28px; height: 1px; background: var(--rouge); display: block;
}
.bd-gl-title {
  font-family: var(--ft-display);
  font-size: clamp(1.9rem, 3.8vw, 2.8rem);
  font-weight: 700; line-height: 1.15; color: var(--noir); margin-bottom: 16px;
}
.bd-gl-title .bd-rouge { color: var(--rouge); }
.bd-gl-divider {
  width: 50px; height: 3px;
  background: linear-gradient(90deg, var(--rouge), var(--or));
  border-radius: 2px; margin-bottom: 24px;
}
.bd-gl-divider.center { margin-left: auto; margin-right: auto; }

/* ── BOUTONS ── */
.bd-gl-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: var(--rouge); color: #fff;
  border: none; cursor: pointer; transition: var(--tr);
  box-shadow: var(--shadow-rouge); text-decoration: none;
}
.bd-gl-btn-primary:hover { background: var(--rouge-fonce); color: #fff; transform: translateY(-2px); }
.bd-gl-btn-or {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: transparent;
  color: var(--or); border: 1.5px solid var(--or);
  cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-gl-btn-or:hover { background: var(--or); color: var(--noir); transform: translateY(-2px); }
.bd-gl-btn-ghost {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: transparent;
  color: #fff; border: 1.5px solid rgba(255,255,255,.5);
  cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-gl-btn-ghost:hover { background: rgba(255,255,255,.12); color: #fff; transform: translateY(-2px); }

/* ── REVEAL ── */
.bd-gl-reveal {
  opacity: 0; transform: translateY(36px);
  transition: opacity .7s cubic-bezier(.4,0,.2,1), transform .7s cubic-bezier(.4,0,.2,1);
}
.bd-gl-reveal.visible { opacity: 1; transform: translateY(0); }
.bd-gl-d1 { transition-delay: .1s; }
.bd-gl-d2 { transition-delay: .2s; }
.bd-gl-d3 { transition-delay: .3s; }

/* ═══════════════════════════════════════════
   SECTION 1 — FILTRES + GRILLE MASONRY
═══════════════════════════════════════════ */
.bd-gl-main {
  padding: 80px 0 100px;
  background: var(--blanc);
}
.bd-gl-main-head { text-align: center; margin-bottom: 48px; }

/* Filtres */
.bd-gl-filters {
  display: flex; align-items: center; justify-content: center;
  gap: 8px; flex-wrap: wrap; margin-bottom: 48px;
}
.bd-gl-filter-btn {
  padding: 9px 22px; border-radius: 40px;
  font-family: var(--ft-body); font-size: .82rem; font-weight: 500;
  color: var(--gris); border: 1.5px solid var(--gris-clair);
  background: transparent; cursor: pointer; transition: var(--tr);
  letter-spacing: .03em;
}
.bd-gl-filter-btn.active, .bd-gl-filter-btn:hover {
  background: var(--rouge); color: #fff; border-color: var(--rouge);
}

/* Compteur résultats */
.bd-gl-count {
  text-align: center; margin-bottom: 32px;
  font-size: .85rem; color: var(--gris);
}
.bd-gl-count strong { color: var(--rouge); font-weight: 700; }

/* Grille masonry CSS */
.bd-gl-grid {
  columns: 3;
  column-gap: 20px;
}
.bd-gl-item {
  break-inside: avoid;
  margin-bottom: 20px;
  position: relative;
  border-radius: var(--r-lg);
  overflow: hidden;
  cursor: pointer;
  display: block;
}
.bd-gl-item img {
  width: 100%; display: block;
  transition: transform .6s cubic-bezier(.4,0,.2,1);
}
.bd-gl-item:hover img { transform: scale(1.06); }
.bd-gl-item-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(180deg, transparent 40%, rgba(10,8,6,.88) 100%);
  opacity: 0;
  transition: opacity .4s ease;
  display: flex; flex-direction: column;
  justify-content: flex-end;
  padding: 24px;
}
.bd-gl-item:hover .bd-gl-item-overlay { opacity: 1; }
.bd-gl-item-cat {
  font-size: .7rem; font-weight: 700;
  color: var(--or); text-transform: uppercase;
  letter-spacing: .12em; margin-bottom: 6px;
}
.bd-gl-item-title {
  font-family: var(--ft-display);
  font-size: 1rem; font-weight: 700;
  color: #fff; line-height: 1.3; margin-bottom: 10px;
}
.bd-gl-item-desc {
  font-size: .8rem; color: rgba(255,255,255,.75);
  line-height: 1.5; margin-bottom: 14px;
}
.bd-gl-item-zoom {
  width: 36px; height: 36px;
  background: rgba(255,255,255,.15);
  border: 1px solid rgba(255,255,255,.3);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .85rem;
  backdrop-filter: blur(4px);
  transition: var(--tr);
  position: absolute; top: 16px; right: 16px;
  opacity: 0;
}
.bd-gl-item:hover .bd-gl-item-zoom { opacity: 1; }
.bd-gl-item-zoom:hover { background: var(--rouge); border-color: var(--rouge); }

/* Badge catégorie */
.bd-gl-item-badge {
  position: absolute; top: 14px; left: 14px;
  background: var(--rouge); color: #fff;
  font-size: .68rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .1em;
  padding: 4px 10px; border-radius: var(--r);
  opacity: 0; transition: opacity .3s;
}
.bd-gl-item:hover .bd-gl-item-badge { opacity: 1; }

/* Message aucun résultat */
.bd-gl-empty {
  text-align: center; padding: 60px 20px;
  display: none;
}
.bd-gl-empty i { font-size: 3rem; color: var(--gris-clair); margin-bottom: 16px; display: block; }
.bd-gl-empty p { color: var(--gris); font-size: .95rem; }

/* ═══════════════════════════════════════════
   SECTION 2 — PROJET VEDETTE
═══════════════════════════════════════════ */
.bd-gl-vedette {
  padding: 100px 0;
  background: var(--creme);
}
.bd-gl-vedette-inner {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 80px;
  align-items: center;
}
.bd-gl-vedette-imgs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 240px 240px;
  gap: 16px;
}
.bd-gl-vedette-img {
  border-radius: var(--r-lg); overflow: hidden;
}
.bd-gl-vedette-img:first-child { grid-row: span 2; }
.bd-gl-vedette-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .6s ease;
}
.bd-gl-vedette-img:hover img { transform: scale(1.06); }
.bd-gl-vedette-tag {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(184,40,42,.1); color: var(--rouge);
  font-size: .75rem; font-weight: 600;
  text-transform: uppercase; letter-spacing: .1em;
  padding: 6px 14px; border-radius: 40px;
  margin-bottom: 20px;
}
.bd-gl-vedette-title {
  font-family: var(--ft-display);
  font-size: clamp(1.6rem, 3vw, 2.4rem);
  font-weight: 700; color: var(--noir);
  line-height: 1.2; margin-bottom: 16px;
}
.bd-gl-vedette-desc {
  font-size: .92rem; color: var(--gris);
  line-height: 1.8; margin-bottom: 28px;
}
.bd-gl-vedette-specs {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 16px; margin-bottom: 32px;
}
.bd-gl-vedette-spec {
  background: var(--blanc-pur);
  border-radius: var(--r-lg); padding: 16px;
  border: 1px solid var(--gris-clair);
}
.bd-gl-vedette-spec-label {
  font-size: .7rem; font-weight: 600;
  color: var(--rouge); text-transform: uppercase;
  letter-spacing: .1em; margin-bottom: 4px;
}
.bd-gl-vedette-spec-val {
  font-family: var(--ft-display);
  font-size: .95rem; font-weight: 700; color: var(--noir);
}
.bd-gl-vedette-btns { display: flex; gap: 12px; flex-wrap: wrap; }

/* ═══════════════════════════════════════════
   SECTION 3 — CATÉGORIES
═══════════════════════════════════════════ */
.bd-gl-cats {
  padding: 80px 0;
  background: var(--noir-doux);
}
.bd-gl-cats-head { text-align: center; margin-bottom: 48px; }
.bd-gl-cats-title {
  font-family: var(--ft-display);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700; color: #fff; margin-bottom: 12px;
}
.bd-gl-cats-sub {
  color: rgba(255,255,255,.55); font-size: .9rem; line-height: 1.7;
}
.bd-gl-cats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
.bd-gl-cat-card {
  position: relative; border-radius: var(--r-lg);
  overflow: hidden; cursor: pointer;
  aspect-ratio: 4/3;
}
.bd-gl-cat-card img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .6s ease;
}
.bd-gl-cat-card:hover img { transform: scale(1.08); }
.bd-gl-cat-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(180deg, rgba(10,8,6,.2) 0%, rgba(10,8,6,.75) 100%);
  display: flex; flex-direction: column;
  justify-content: flex-end; padding: 24px;
  transition: var(--tr);
}
.bd-gl-cat-card:hover .bd-gl-cat-overlay {
  background: linear-gradient(180deg, rgba(139,26,28,.3) 0%, rgba(139,26,28,.85) 100%);
}
.bd-gl-cat-name {
  font-family: var(--ft-display);
  font-size: 1.2rem; font-weight: 700;
  color: #fff; margin-bottom: 4px;
}
.bd-gl-cat-count {
  font-size: .78rem; color: rgba(255,255,255,.7);
  font-weight: 500;
}
.bd-gl-cat-arrow {
  position: absolute; top: 16px; right: 16px;
  width: 34px; height: 34px;
  background: rgba(255,255,255,.15);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .8rem;
  opacity: 0; transition: var(--tr);
}
.bd-gl-cat-card:hover .bd-gl-cat-arrow { opacity: 1; transform: scale(1.1); }

/* ═══════════════════════════════════════════
   SECTION 4 — TÉMOIGNAGE PROJET
═══════════════════════════════════════════ */
.bd-gl-temoignage {
  padding: 80px 0;
  background: var(--creme);
}
.bd-gl-temo-inner {
  display: grid;
  grid-template-columns: 1fr 1.5fr;
  gap: 80px;
  align-items: center;
}
.bd-gl-temo-img {
  border-radius: var(--r-lg); overflow: hidden;
  aspect-ratio: 1; position: relative;
}
.bd-gl-temo-img img { width: 100%; height: 100%; object-fit: cover; }
.bd-gl-temo-badge {
  position: absolute; bottom: -20px; right: -20px;
  width: 100px; height: 100px;
  background: var(--rouge);
  border-radius: 50%;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  color: #fff; text-align: center;
  box-shadow: var(--shadow-rouge);
}
.bd-gl-temo-badge strong {
  font-family: var(--ft-display);
  font-size: 1.8rem; font-weight: 800; line-height: 1;
}
.bd-gl-temo-badge span {
  font-size: .6rem; text-transform: uppercase;
  letter-spacing: .08em; opacity: .85;
}
.bd-gl-temo-quote {
  font-family: var(--ft-accent);
  font-style: italic; font-size: 1.35rem;
  color: var(--gris-fonce); line-height: 1.6;
  margin-bottom: 28px; position: relative;
}
.bd-gl-temo-quote::before {
  content: '\201C';
  font-size: 5rem; color: var(--rouge);
  opacity: .25; position: absolute;
  top: -20px; left: -20px; line-height: 1;
  font-style: normal;
}
.bd-gl-temo-author {
  display: flex; align-items: center; gap: 16px;
  padding-top: 20px; border-top: 1px solid var(--gris-clair);
}
.bd-gl-temo-avatar {
  width: 52px; height: 52px;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--ft-display); font-size: 1.1rem;
  font-weight: 700; color: #fff; flex-shrink: 0;
}
.bd-gl-temo-name {
  font-weight: 600; color: var(--noir); font-size: .95rem; margin-bottom: 2px;
}
.bd-gl-temo-role { font-size: .8rem; color: var(--gris); }
.bd-gl-temo-stars { display: flex; gap: 3px; color: var(--or); font-size: .85rem; margin-bottom: 8px; }

/* ═══════════════════════════════════════════
   SECTION 5 — CTA
═══════════════════════════════════════════ */
.bd-gl-cta {
  position: relative; padding: 100px 0; overflow: hidden; text-align: center;
}
.bd-gl-cta-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1800&q=80');
  background-size: cover; background-position: center; background-attachment: fixed;
}
.bd-gl-cta-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(139,26,28,.93) 0%, rgba(20,15,12,.88) 60%, rgba(139,26,28,.75) 100%);
}
.bd-gl-cta-content { position: relative; z-index: 2; max-width: 680px; margin: 0 auto; }
.bd-gl-cta-label {
  font-family: var(--ft-accent); font-style: italic;
  color: var(--or-clair); font-size: 1rem;
  letter-spacing: .08em; margin-bottom: 20px; display: block;
}
.bd-gl-cta-title {
  font-family: var(--ft-display);
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 20px;
}
.bd-gl-cta-title em { font-style: italic; color: var(--or-clair); }
.bd-gl-cta-sub {
  color: rgba(255,255,255,.78); font-size: .95rem; line-height: 1.75; margin-bottom: 40px;
}
.bd-gl-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

/* ═══════════════════════════════════════════
   LIGHTBOX
═══════════════════════════════════════════ */
.bd-gl-lightbox {
  position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.95);
  display: none; align-items: center; justify-content: center;
  padding: 20px;
  backdrop-filter: blur(8px);
}
.bd-gl-lightbox.open { display: flex; }
.bd-gl-lightbox-inner {
  position: relative;
  max-width: 1000px; width: 100%;
  max-height: 90vh;
}
.bd-gl-lightbox-img {
  width: 100%; max-height: 80vh;
  object-fit: contain; border-radius: var(--r-lg);
  display: block;
}
.bd-gl-lightbox-close {
  position: absolute; top: -48px; right: 0;
  width: 40px; height: 40px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.25);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1rem;
  cursor: pointer; transition: var(--tr);
}
.bd-gl-lightbox-close:hover { background: var(--rouge); border-color: var(--rouge); }
.bd-gl-lightbox-nav {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 100%; display: flex; justify-content: space-between;
  pointer-events: none;
}
.bd-gl-lightbox-btn {
  pointer-events: all;
  width: 44px; height: 44px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.25);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .9rem;
  cursor: pointer; transition: var(--tr);
  margin: 0 -60px;
}
.bd-gl-lightbox-btn:hover { background: var(--rouge); border-color: var(--rouge); }
.bd-gl-lightbox-info {
  text-align: center; padding-top: 16px;
}
.bd-gl-lightbox-title {
  font-family: var(--ft-display);
  font-size: 1.1rem; color: #fff; font-weight: 600; margin-bottom: 4px;
}
.bd-gl-lightbox-cat {
  font-size: .78rem; color: var(--or); text-transform: uppercase; letter-spacing: .1em;
}
.bd-gl-lightbox-counter {
  position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%);
  font-size: .8rem; color: rgba(255,255,255,.5);
}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
  .bd-gl-grid { columns: 2; }
  .bd-gl-vedette-inner { grid-template-columns: 1fr; gap: 48px; }
  .bd-gl-cats-grid { grid-template-columns: repeat(2, 1fr); }
  .bd-gl-temo-inner { grid-template-columns: 1fr; gap: 48px; }
}
@media (max-width: 768px) {
  .bd-gl-container { padding: 0 20px; }
  .bd-gl-grid { columns: 2; }
  .bd-gl-hero { height: 320px; }
  .bd-gl-hero-content { padding: 0 20px; }
  .bd-gl-cats-grid { grid-template-columns: 1fr; }
  .bd-gl-lightbox-btn { margin: 0 -10px; }
  .bd-gl-vedette-specs { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
  .bd-gl-grid { columns: 1; }
}
</style>

<div class="bd-gl">

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="bd-gl-hero">
  <div class="bd-gl-hero-bg"></div>
  <div class="bd-gl-hero-overlay"></div>
  <div class="bd-gl-hero-content">
    <div class="bd-gl-hero-label">Nos réalisations</div>
    <h1 class="bd-gl-hero-title">
      Notre <em>Galerie</em><br>de Réalisations
    </h1>
    <div class="bd-gl-hero-bread">
      <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
      <i class="fas fa-chevron-right"></i>
      <span style="color:var(--or-clair);">Galerie</span>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 1 — FILTRES + GRILLE
══════════════════════════════════════════ -->
<section class="bd-gl-main">
  <div class="bd-gl-container">

    <div class="bd-gl-main-head bd-gl-reveal">
      <p class="bd-gl-label" style="justify-content:center;">Notre portfolio</p>
      <h2 class="bd-gl-title" style="text-align:center;">
        Nos <span class="bd-rouge">Réalisations</span>
      </h2>
      <div class="bd-gl-divider center"></div>
      <p style="color:var(--gris);font-size:.95rem;max-width:560px;margin:0 auto;line-height:1.75;text-align:center;">
        Découvrez nos projets réalisés à Ouagadougou — salons, chambres, bureaux, hôtels et restaurants.
      </p>
    </div>

    <!-- Filtres -->
    <div class="bd-gl-filters bd-gl-reveal">
      <button class="bd-gl-filter-btn active" data-filter="tous">
        <i class="fas fa-th"></i> Tous
      </button>
      <?php
      $cats_unique = array_unique(array_column($galerie, 'categorie'));
      $cat_labels  = [
        'salon'   => ['label'=>'Salon',      'icon'=>'fas fa-couch'],
        'chambre' => ['label'=>'Chambre',     'icon'=>'fas fa-bed'],
        'bureau'  => ['label'=>'Bureau',      'icon'=>'fas fa-briefcase'],
        'hotel'   => ['label'=>'Hôtel',       'icon'=>'fas fa-hotel'],
        'resto'   => ['label'=>'Restaurant',  'icon'=>'fas fa-utensils'],
        'autre'   => ['label'=>'Autre',       'icon'=>'fas fa-star'],
      ];
      foreach ($cats_unique as $cat) :
        $info = $cat_labels[$cat] ?? ['label'=>ucfirst($cat), 'icon'=>'fas fa-layer-group'];
      ?>
      <button class="bd-gl-filter-btn" data-filter="<?php echo esc_attr($cat); ?>">
        <i class="<?php echo esc_attr($info['icon']); ?>"></i>
        <?php echo esc_html($info['label']); ?>
      </button>
      <?php endforeach; ?>
    </div>

    <!-- Compteur -->
    <div class="bd-gl-count">
      <strong id="bdGlCount"><?php echo count($galerie); ?></strong>
      réalisation<?php echo count($galerie) > 1 ? 's' : ''; ?> affichée<?php echo count($galerie) > 1 ? 's' : ''; ?>
    </div>

    <!-- Grille -->
    <div class="bd-gl-grid" id="bdGlGrid">
      <?php foreach ($galerie as $i => $item) :
        $cat_info = $cat_labels[$item->categorie] ?? ['label'=>ucfirst($item->categorie), 'icon'=>'fas fa-layer-group'];
      ?>
      <div class="bd-gl-item bd-gl-reveal"
           data-cat="<?php echo esc_attr($item->categorie); ?>"
           data-img="<?php echo esc_url($item->image_url); ?>"
           data-title="<?php echo esc_attr($item->titre); ?>"
           data-cat-label="<?php echo esc_attr($cat_info['label']); ?>"
           onclick="bdGlOpen(<?php echo $i; ?>)">
        <img src="<?php echo esc_url($item->image_url); ?>"
             alt="<?php echo esc_attr($item->titre); ?>"
             loading="lazy">
        <div class="bd-gl-item-badge"><?php echo esc_html($cat_info['label']); ?></div>
        <div class="bd-gl-item-zoom"><i class="fas fa-expand"></i></div>
        <div class="bd-gl-item-overlay">
          <div class="bd-gl-item-cat"><?php echo esc_html($cat_info['label']); ?></div>
          <div class="bd-gl-item-title"><?php echo esc_html($item->titre); ?></div>
          <?php if ($item->description) : ?>
          <div class="bd-gl-item-desc"><?php echo esc_html(wp_trim_words($item->description, 12)); ?></div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>

      <?php if (empty($galerie)) :
        // Galerie de démo si BDD vide
        $demo = [
          ['titre'=>'Salon Contemporain — Villa Ouaga 2000',       'cat'=>'salon',   'img'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&q=80'],
          ['titre'=>'Suite Parentale — Résidence Kossodo',          'cat'=>'chambre', 'img'=>'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80'],
          ['titre'=>'Espace Bureau — Cabinet d\'Avocats',           'cat'=>'bureau',  'img'=>'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80'],
          ['titre'=>'Restaurant Gastronomique — Hôtel Laïco',       'cat'=>'hotel',   'img'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80'],
          ['titre'=>'Salon Classique — Cité An III',                'cat'=>'salon',   'img'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=800&q=80'],
          ['titre'=>'Chambre Enfant — Quartier Gounghin',           'cat'=>'chambre', 'img'=>'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80'],
          ['titre'=>'Réception Hôtel — Résidence Premium',          'cat'=>'hotel',   'img'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=80'],
          ['titre'=>'Bureau Direction — Société Minière',           'cat'=>'bureau',  'img'=>'https://images.unsplash.com/photo-1493663284031-b7e3aaa4f8b4?w=800&q=80'],
          ['titre'=>'Salon Marocain — Villa Patte d\'Oie',          'cat'=>'salon',   'img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80'],
        ];
        foreach ($demo as $i => $d) :
          $ci = $cat_labels[$d['cat']] ?? ['label'=>ucfirst($d['cat']), 'icon'=>'fas fa-layer-group'];
        ?>
        <div class="bd-gl-item bd-gl-reveal"
             data-cat="<?php echo esc_attr($d['cat']); ?>"
             data-img="<?php echo esc_url($d['img']); ?>"
             data-title="<?php echo esc_attr($d['titre']); ?>"
             data-cat-label="<?php echo esc_attr($ci['label']); ?>"
             onclick="bdGlOpen(<?php echo $i; ?>)">
          <img src="<?php echo esc_url($d['img']); ?>"
               alt="<?php echo esc_attr($d['titre']); ?>" loading="lazy">
          <div class="bd-gl-item-badge"><?php echo esc_html($ci['label']); ?></div>
          <div class="bd-gl-item-zoom"><i class="fas fa-expand"></i></div>
          <div class="bd-gl-item-overlay">
            <div class="bd-gl-item-cat"><?php echo esc_html($ci['label']); ?></div>
            <div class="bd-gl-item-title"><?php echo esc_html($d['titre']); ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="bd-gl-empty" id="bdGlEmpty">
      <i class="fas fa-images"></i>
      <p>Aucune réalisation trouvée dans cette catégorie.</p>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 2 — PROJET VEDETTE
══════════════════════════════════════════ -->
<section class="bd-gl-vedette">
  <div class="bd-gl-container">
    <div class="bd-gl-vedette-inner">

      <!-- Images -->
      <div class="bd-gl-vedette-imgs bd-gl-reveal">
        <div class="bd-gl-vedette-img">
          <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&q=80"
               alt="Projet vedette BAOBO DECO" loading="lazy">
        </div>
        <div class="bd-gl-vedette-img">
          <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600&q=80"
               alt="Projet vedette détail" loading="lazy">
        </div>
        <div class="bd-gl-vedette-img">
          <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80"
               alt="Projet vedette meuble" loading="lazy">
        </div>
      </div>

      <!-- Contenu -->
      <div class="bd-gl-reveal bd-gl-d2">
        <span class="bd-gl-vedette-tag">
          <i class="fas fa-star"></i> Projet Vedette
        </span>
        <h2 class="bd-gl-vedette-title">
          Villa Résidentielle — Quartier Ouaga 2000
        </h2>
        <p class="bd-gl-vedette-desc">
          Aménagement complet d'une villa de 400m² à Ouaga 2000. Salon, salle à manger,
          5 chambres et espaces communs entièrement décorés par nos équipes en 6 semaines.
          Un projet alliant modernité et élégance typiquement burkinabè.
        </p>
        <div class="bd-gl-vedette-specs">
          <div class="bd-gl-vedette-spec">
            <div class="bd-gl-vedette-spec-label">Surface</div>
            <div class="bd-gl-vedette-spec-val">400 m²</div>
          </div>
          <div class="bd-gl-vedette-spec">
            <div class="bd-gl-vedette-spec-label">Durée</div>
            <div class="bd-gl-vedette-spec-val">6 semaines</div>
          </div>
          <div class="bd-gl-vedette-spec">
            <div class="bd-gl-vedette-spec-label">Pièces</div>
            <div class="bd-gl-vedette-spec-val">8 pièces</div>
          </div>
          <div class="bd-gl-vedette-spec">
            <div class="bd-gl-vedette-spec-label">Style</div>
            <div class="bd-gl-vedette-spec-val">Contemporain</div>
          </div>
        </div>
        <div class="bd-gl-vedette-btns">
          <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-gl-btn-primary">
            <i class="fas fa-file-invoice"></i> Projet similaire
          </a>
          <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-gl-btn-or">
            <i class="fab fa-whatsapp"></i> WhatsApp
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 3 — CATÉGORIES
══════════════════════════════════════════ -->
<section class="bd-gl-cats">
  <div class="bd-gl-container">
    <div class="bd-gl-cats-head bd-gl-reveal">
      <p style="display:inline-flex;align-items:center;gap:10px;font-family:var(--ft-accent);font-size:.9rem;font-style:italic;color:var(--or);margin-bottom:14px;">
        <span style="width:28px;height:1px;background:var(--or);display:block;"></span>
        Nos domaines d'intervention
        <span style="width:28px;height:1px;background:var(--or);display:block;"></span>
      </p>
      <h2 class="bd-gl-cats-title">Explorer par <span style="color:var(--or-clair);">catégorie</span></h2>
      <p class="bd-gl-cats-sub" style="max-width:500px;margin:0 auto;">
        Du salon familial aux espaces professionnels, découvrez l'étendue de notre savoir-faire.
      </p>
    </div>

    <div class="bd-gl-cats-grid">
      <?php
      $cats_display = [
        ['key'=>'salon',   'label'=>'Salons',       'count'=>'50+', 'img'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=600&q=80'],
        ['key'=>'chambre', 'label'=>'Chambres',     'count'=>'40+', 'img'=>'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80'],
        ['key'=>'bureau',  'label'=>'Bureaux',      'count'=>'30+', 'img'=>'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80'],
        ['key'=>'hotel',   'label'=>'Hôtels',       'count'=>'20+', 'img'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80'],
        ['key'=>'resto',   'label'=>'Restaurants',  'count'=>'15+', 'img'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80'],
        ['key'=>'autre',   'label'=>'Autres',       'count'=>'45+', 'img'=>'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600&q=80'],
      ];
      foreach ($cats_display as $i => $c) :
      ?>
      <div class="bd-gl-cat-card bd-gl-reveal bd-gl-d<?php echo ($i%3)+1; ?>"
           onclick="bdGlFilterCat('<?php echo esc_attr($c['key']); ?>')">
        <img src="<?php echo esc_url($c['img']); ?>"
             alt="<?php echo esc_attr($c['label']); ?>" loading="lazy">
        <div class="bd-gl-cat-overlay">
          <div class="bd-gl-cat-name"><?php echo esc_html($c['label']); ?></div>
          <div class="bd-gl-cat-count"><?php echo esc_html($c['count']); ?> projets réalisés</div>
        </div>
        <div class="bd-gl-cat-arrow"><i class="fas fa-arrow-right"></i></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 4 — TÉMOIGNAGE
══════════════════════════════════════════ -->
<section class="bd-gl-temoignage">
  <div class="bd-gl-container">
    <div class="bd-gl-temo-inner">

      <div class="bd-gl-reveal">
        <div class="bd-gl-temo-img">
          <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&q=80"
               alt="Cliente BAOBO DECO" loading="lazy">
          <div class="bd-gl-temo-badge">
            <strong>5★</strong>
            <span>Note client</span>
          </div>
        </div>
      </div>

      <div class="bd-gl-reveal bd-gl-d2">
        <p style="display:inline-flex;align-items:center;gap:10px;font-family:var(--ft-accent);font-size:.9rem;font-style:italic;color:var(--rouge);margin-bottom:20px;">
          <span style="width:28px;height:1px;background:var(--rouge);display:block;"></span>
          Témoignage client
          <span style="width:28px;height:1px;background:var(--rouge);display:block;"></span>
        </p>
        <div class="bd-gl-temo-stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i>
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <blockquote class="bd-gl-temo-quote">
          BAOBO DECO a transformé notre villa en véritable havre de paix.
          Du premier rendez-vous à la livraison finale, l'équipe a fait preuve
          d'un professionnalisme exemplaire. Chaque détail a été soigné avec passion.
          Je recommande les yeux fermés !
        </blockquote>
        <div class="bd-gl-temo-author">
          <div class="bd-gl-temo-avatar">AK</div>
          <div>
            <div class="bd-gl-temo-name">Aminata Koné</div>
            <div class="bd-gl-temo-role">Propriétaire, Villa Ouaga 2000</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 5 — CTA
══════════════════════════════════════════ -->
<section class="bd-gl-cta">
  <div class="bd-gl-cta-bg"></div>
  <div class="bd-gl-cta-overlay"></div>
  <div class="bd-gl-container">
    <div class="bd-gl-cta-content bd-gl-reveal">
      <span class="bd-gl-cta-label">Votre projet mérite le meilleur</span>
      <h2 class="bd-gl-cta-title">
        Votre réalisation dans<br><em>notre galerie bientôt ?</em>
      </h2>
      <p class="bd-gl-cta-sub">
        Rejoignez nos 200+ clients satisfaits. Contactez-nous pour donner vie
        à votre projet de décoration à Ouagadougou.
      </p>
      <div class="bd-gl-cta-btns">
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-gl-btn-primary">
          <i class="fas fa-file-invoice"></i> Démarrer mon projet
        </a>
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-gl-btn-ghost">
          <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- .bd-gl -->

<!-- ══════════════════════════════════════════
     LIGHTBOX
══════════════════════════════════════════ -->
<div class="bd-gl-lightbox" id="bdGlLightbox" onclick="bdGlLightboxClose(event)">
  <div class="bd-gl-lightbox-inner">
    <button class="bd-gl-lightbox-close" onclick="bdGlClose()">
      <i class="fas fa-times"></i>
    </button>
    <div class="bd-gl-lightbox-nav">
      <button class="bd-gl-lightbox-btn" onclick="bdGlLightboxNav(-1); event.stopPropagation();">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="bd-gl-lightbox-btn" onclick="bdGlLightboxNav(1); event.stopPropagation();">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
    <img src="" alt="" class="bd-gl-lightbox-img" id="bdGlLbImg">
    <div class="bd-gl-lightbox-info">
      <div class="bd-gl-lightbox-title" id="bdGlLbTitle"></div>
      <div class="bd-gl-lightbox-cat" id="bdGlLbCat"></div>
    </div>
    <div class="bd-gl-lightbox-counter" id="bdGlLbCounter"></div>
  </div>
</div>

<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
(function() {
'use strict';

/* ── SCROLL REVEAL ── */
(function() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.bd-gl-reveal').forEach(el => el.classList.add('visible'));
    return;
  }
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.bd-gl-reveal').forEach(el => obs.observe(el));
})();

/* ── FILTRES ── */
const filterBtns = document.querySelectorAll('.bd-gl-filter-btn');
const glItems    = document.querySelectorAll('.bd-gl-item');
const countEl    = document.getElementById('bdGlCount');
const emptyEl    = document.getElementById('bdGlEmpty');

filterBtns.forEach(btn => {
  btn.addEventListener('click', function() {
    filterBtns.forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    applyFilter(this.dataset.filter);
  });
});

function applyFilter(filter) {
  let visible = 0;
  glItems.forEach(item => {
    const show = filter === 'tous' || item.dataset.cat === filter;
    item.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  if (countEl) countEl.textContent = visible;
  if (emptyEl) emptyEl.style.display = visible === 0 ? 'block' : 'none';
}

/* Filtre depuis les cartes catégories */
window.bdGlFilterCat = function(cat) {
  filterBtns.forEach(b => {
    b.classList.toggle('active', b.dataset.filter === cat);
  });
  applyFilter(cat);
  document.querySelector('.bd-gl-main').scrollIntoView({ behavior: 'smooth', block: 'start' });
};

/* ── LIGHTBOX ── */
let currentIdx = 0;
const visibleItems = () => [...glItems].filter(i => i.style.display !== 'none');

window.bdGlOpen = function(idx) {
  const items = visibleItems();
  const targetItem = document.querySelector(`.bd-gl-item:nth-child(${idx+1})`);
  currentIdx = items.indexOf(targetItem);
  if (currentIdx < 0) currentIdx = 0;
  bdGlLightboxShow(items[currentIdx]);
  document.getElementById('bdGlLightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
};

window.bdGlClose = function() {
  document.getElementById('bdGlLightbox').classList.remove('open');
  document.body.style.overflow = '';
};

window.bdGlLightboxClose = function(e) {
  if (e.target === document.getElementById('bdGlLightbox')) bdGlClose();
};

window.bdGlLightboxNav = function(dir) {
  const items = visibleItems();
  currentIdx = (currentIdx + dir + items.length) % items.length;
  bdGlLightboxShow(items[currentIdx]);
};

function bdGlLightboxShow(item) {
  if (!item) return;
  const items = visibleItems();
  document.getElementById('bdGlLbImg').src     = item.dataset.img;
  document.getElementById('bdGlLbImg').alt     = item.dataset.title;
  document.getElementById('bdGlLbTitle').textContent  = item.dataset.title;
  document.getElementById('bdGlLbCat').textContent    = item.dataset.catLabel;
  document.getElementById('bdGlLbCounter').textContent = (currentIdx+1) + ' / ' + items.length;
}

/* Clavier lightbox */
document.addEventListener('keydown', e => {
  if (!document.getElementById('bdGlLightbox').classList.contains('open')) return;
  if (e.key === 'Escape')     bdGlClose();
  if (e.key === 'ArrowRight') bdGlLightboxNav(1);
  if (e.key === 'ArrowLeft')  bdGlLightboxNav(-1);
});

})();
</script>

<?php get_footer(); ?>