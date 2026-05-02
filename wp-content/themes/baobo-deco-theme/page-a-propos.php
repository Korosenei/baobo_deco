<?php
/**
 * Template Name: Page À Propos BAOBO DECO
 * page-a-propos.php
 */

get_header();

global $wpdb;

function bd_get_ap($key, $default='') {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$stats    = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_stats ORDER BY ordre ASC");
$atouts   = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_atouts ORDER BY ordre ASC");
$services = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_services WHERE actif=1 ORDER BY ordre ASC LIMIT 6");

$wa_num = bd_get_ap('whatsapp_num', '22607592997');
$wa_msg = bd_get_ap('whatsapp_msg', 'Bonjour BAOBO DECO');
$wa_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode($wa_msg);
?>

<style>
/* ═══════════════════════════════════════════
   VARIABLES
═══════════════════════════════════════════ */
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

/* ═══════════════════════════════════════════
   RESET PAGE
═══════════════════════════════════════════ */
.bd-ap * { box-sizing: border-box; }
.bd-ap img { max-width: 100%; display: block; }
.bd-ap a { text-decoration: none; }

/* ═══════════════════════════════════════════
   HERO BANNIÈRE PAGE
═══════════════════════════════════════════ */
.bd-page-hero {
  position: relative;
  height: 420px;
  overflow: hidden;
  display: flex;
  align-items: center;
}
.bd-page-hero-bg {
  position: absolute;
  inset: 0;
  background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1800&q=80');
  background-size: cover;
  background-position: center;
  transform: scale(1.05);
}
.bd-page-hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, rgba(10,8,6,.85) 0%, rgba(10,8,6,.55) 60%, rgba(10,8,6,.2) 100%);
}
.bd-page-hero-content {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 40px;
  width: 100%;
}
.bd-page-hero-label {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: var(--or-clair);
  font-family: var(--ft-accent);
  font-style: italic;
  font-size: .9rem;
  margin-bottom: 16px;
}
.bd-page-hero-label::before,
.bd-page-hero-label::after {
  content: '';
  width: 28px;
  height: 1px;
  background: var(--or);
  display: block;
}
.bd-page-hero-title {
  font-family: var(--ft-display);
  font-size: clamp(2.2rem, 5vw, 3.8rem);
  font-weight: 800;
  color: #fff;
  line-height: 1.1;
  margin-bottom: 20px;
}
.bd-page-hero-title em { font-style: italic; color: var(--or-clair); }
.bd-page-hero-breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: .82rem;
  color: rgba(255,255,255,.6);
}
.bd-page-hero-breadcrumb a { color: rgba(255,255,255,.6); transition: color .25s; }
.bd-page-hero-breadcrumb a:hover { color: var(--or-clair); }
.bd-page-hero-breadcrumb i { font-size: .65rem; color: var(--or); }

/* ═══════════════════════════════════════════
   UTILITAIRES COMMUNS
═══════════════════════════════════════════ */
.bd-ap-container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }

.bd-ap-label {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: var(--ft-accent); font-size: .9rem; font-style: italic;
  color: var(--rouge); letter-spacing: .05em; margin-bottom: 14px;
}
.bd-ap-label::before, .bd-ap-label::after {
  content: ''; width: 28px; height: 1px; background: var(--rouge); display: block;
}
.bd-ap-title {
  font-family: var(--ft-display);
  font-size: clamp(1.9rem, 3.8vw, 2.8rem);
  font-weight: 700; line-height: 1.15; color: var(--noir);
  margin-bottom: 16px;
}
.bd-ap-title .bd-rouge { color: var(--rouge); }
.bd-ap-title-white { color: #fff; }
.bd-ap-divider {
  width: 50px; height: 3px;
  background: linear-gradient(90deg, var(--rouge), var(--or));
  border-radius: 2px; margin-bottom: 24px;
}
.bd-ap-divider.center { margin-left: auto; margin-right: auto; }

/* ── BOUTONS ── */
.bd-ap-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: var(--rouge); color: #fff;
  border: none; cursor: pointer; transition: var(--tr);
  box-shadow: var(--shadow-rouge); text-decoration: none;
}
.bd-ap-btn-primary:hover { background: var(--rouge-fonce); color: #fff; transform: translateY(-2px); }
.bd-ap-btn-border {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: transparent;
  color: var(--rouge); border: 1.5px solid var(--rouge);
  cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-ap-btn-border:hover { background: var(--rouge); color: #fff; transform: translateY(-2px); }
.bd-ap-btn-or {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: transparent;
  color: var(--or); border: 1.5px solid var(--or);
  cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-ap-btn-or:hover { background: var(--or); color: var(--noir); transform: translateY(-2px); }

/* ── REVEAL ── */
.bd-ap-reveal {
  opacity: 0; transform: translateY(36px);
  transition: opacity .7s cubic-bezier(.4,0,.2,1), transform .7s cubic-bezier(.4,0,.2,1);
}
.bd-ap-reveal.visible { opacity: 1; transform: translateY(0); }
.bd-ap-d1 { transition-delay: .1s; }
.bd-ap-d2 { transition-delay: .2s; }
.bd-ap-d3 { transition-delay: .3s; }
.bd-ap-d4 { transition-delay: .4s; }

/* ═══════════════════════════════════════════
   SECTION 1 — HISTOIRE & IDENTITÉ
═══════════════════════════════════════════ */
.bd-ap-histoire {
  padding: 100px 0;
  background: var(--blanc);
}
.bd-ap-histoire-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.bd-ap-histoire-imgs {
  position: relative;
}
.bd-ap-histoire-img-main {
  width: 100%;
  aspect-ratio: 4/5;
  object-fit: cover;
  border-radius: var(--r-lg);
  display: block;
}
.bd-ap-histoire-img-float {
  position: absolute;
  bottom: -30px;
  right: -30px;
  width: 200px;
  aspect-ratio: 1;
  object-fit: cover;
  border-radius: var(--r-lg);
  border: 6px solid var(--blanc);
  box-shadow: var(--shadow-lg);
}
.bd-ap-exp-badge {
  position: absolute;
  top: 24px;
  left: -20px;
  background: var(--rouge);
  color: #fff;
  padding: 20px;
  border-radius: var(--r-lg);
  text-align: center;
  box-shadow: var(--shadow-rouge);
  min-width: 100px;
}
.bd-ap-exp-badge-num {
  font-family: var(--ft-display);
  font-size: 2.4rem;
  font-weight: 800;
  line-height: 1;
  display: block;
}
.bd-ap-exp-badge-label {
  font-size: .72rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .08em;
  opacity: .85;
  margin-top: 4px;
  display: block;
}
.bd-ap-histoire-text p {
  font-size: .95rem;
  color: var(--gris);
  line-height: 1.8;
  margin-bottom: 18px;
}
.bd-ap-histoire-text p:last-of-type { margin-bottom: 0; }
.bd-ap-histoire-quote {
  border-left: 4px solid var(--or);
  padding: 16px 20px;
  margin: 28px 0;
  background: var(--creme);
  border-radius: 0 var(--r) var(--r) 0;
}
.bd-ap-histoire-quote p {
  font-family: var(--ft-accent);
  font-style: italic;
  font-size: 1.05rem;
  color: var(--gris-fonce);
  line-height: 1.65;
  margin: 0 !important;
}
.bd-ap-histoire-quote cite {
  display: block;
  margin-top: 8px;
  font-size: .78rem;
  font-weight: 600;
  color: var(--rouge);
  font-style: normal;
  letter-spacing: .06em;
  text-transform: uppercase;
}
.bd-ap-histoire-btns {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  margin-top: 32px;
}

/* ═══════════════════════════════════════════
   SECTION 2 — CHIFFRES CLÉS
═══════════════════════════════════════════ */
.bd-ap-stats {
  padding: 80px 0;
  background: var(--noir-doux);
  position: relative;
  overflow: hidden;
}
.bd-ap-stats::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--rouge-fonce), var(--rouge), var(--or), var(--rouge));
}
.bd-ap-stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
}
.bd-ap-stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  border-right: 1px solid rgba(255,255,255,.08);
  text-align: center;
  transition: var(--tr);
  cursor: default;
}
.bd-ap-stat-item:last-child { border-right: none; }
.bd-ap-stat-item:hover { background: rgba(184,40,42,.12); }
.bd-ap-stat-icon-wrap {
  width: 56px; height: 56px;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem; color: #fff;
  margin-bottom: 20px;
}
.bd-ap-stat-num {
  font-family: var(--ft-display);
  font-size: 2.8rem;
  font-weight: 800;
  color: var(--or);
  line-height: 1;
  margin-bottom: 8px;
}
.bd-ap-stat-label {
  font-size: .75rem;
  font-weight: 600;
  color: rgba(255,255,255,.5);
  text-transform: uppercase;
  letter-spacing: .1em;
}

/* ═══════════════════════════════════════════
   SECTION 3 — NOS VALEURS
═══════════════════════════════════════════ */
.bd-ap-valeurs {
  padding: 100px 0;
  background: var(--creme);
  position: relative;
  overflow: hidden;
}
.bd-ap-valeurs::before {
  content: 'VALEURS';
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-family: var(--ft-display); font-size: 14vw; font-weight: 900;
  color: rgba(0,0,0,.025); white-space: nowrap; pointer-events: none;
}
.bd-ap-valeurs-head { text-align: center; margin-bottom: 64px; }
.bd-ap-valeurs-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.bd-ap-valeur-card {
  background: var(--blanc-pur);
  border-radius: var(--r-lg);
  padding: 40px 32px;
  border: 1px solid var(--gris-clair);
  transition: var(--tr);
  position: relative;
  overflow: hidden;
  text-align: center;
}
.bd-ap-valeur-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--rouge), var(--or));
  transform: scaleX(0);
  transition: transform .4s ease;
  transform-origin: left;
}
.bd-ap-valeur-card:hover::after { transform: scaleX(1); }
.bd-ap-valeur-card:hover {
  transform: translateY(-6px);
  box-shadow: var(--shadow-lg);
  border-color: transparent;
}
.bd-ap-valeur-icon {
  width: 70px; height: 70px;
  background: linear-gradient(135deg, rgba(184,40,42,.1), rgba(184,40,42,.05));
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.6rem; color: var(--rouge);
  margin: 0 auto 24px;
  transition: var(--tr);
}
.bd-ap-valeur-card:hover .bd-ap-valeur-icon {
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  color: #fff;
}
.bd-ap-valeur-title {
  font-family: var(--ft-display);
  font-size: 1.2rem; font-weight: 700;
  color: var(--noir); margin-bottom: 12px;
}
.bd-ap-valeur-desc {
  font-size: .88rem; color: var(--gris); line-height: 1.75;
}

/* ═══════════════════════════════════════════
   SECTION 4 — NOTRE ÉQUIPE
═══════════════════════════════════════════ */
.bd-ap-equipe {
  padding: 100px 0;
  background: var(--blanc);
}
.bd-ap-equipe-head { text-align: center; margin-bottom: 64px; }
.bd-ap-equipe-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.bd-ap-membre-card {
  background: var(--blanc-pur);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: var(--tr);
  text-align: center;
}
.bd-ap-membre-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}
.bd-ap-membre-img-wrap {
  position: relative;
  overflow: hidden;
  aspect-ratio: 1 / 1;
  background: var(--gris-clair);
}
.bd-ap-membre-img-wrap img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .6s ease;
}
.bd-ap-membre-card:hover .bd-ap-membre-img-wrap img { transform: scale(1.06); }
.bd-ap-membre-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, transparent 40%, rgba(139,26,28,.85) 100%);
  opacity: 0;
  transition: opacity .4s ease;
  display: flex;
  align-items: flex-end;
  justify-content: center;
  padding-bottom: 20px;
  gap: 12px;
}
.bd-ap-membre-card:hover .bd-ap-membre-overlay { opacity: 1; }
.bd-ap-membre-social {
  width: 36px; height: 36px;
  background: rgba(255,255,255,.15);
  border: 1px solid rgba(255,255,255,.3);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .82rem;
  text-decoration: none;
  transition: var(--tr);
  backdrop-filter: blur(4px);
}
.bd-ap-membre-social:hover { background: var(--rouge); border-color: var(--rouge); }
.bd-ap-membre-info { padding: 24px 20px; }
.bd-ap-membre-initiales {
  width: 52px; height: 52px;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--ft-display); font-size: 1.1rem;
  font-weight: 700; color: #fff;
  margin: 0 auto 16px;
}
.bd-ap-membre-name {
  font-family: var(--ft-display);
  font-size: 1.1rem; font-weight: 700;
  color: var(--noir); margin-bottom: 4px;
}
.bd-ap-membre-role {
  font-size: .78rem; font-weight: 600;
  color: var(--rouge); text-transform: uppercase;
  letter-spacing: .08em; margin-bottom: 12px;
}
.bd-ap-membre-bio {
  font-size: .85rem; color: var(--gris); line-height: 1.65;
}

/* ═══════════════════════════════════════════
   SECTION 5 — POURQUOI NOUS CHOISIR
═══════════════════════════════════════════ */
.bd-ap-pourquoi {
  padding: 100px 0;
  background: var(--creme);
}
.bd-ap-pourquoi-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.bd-ap-pourquoi-features {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-top: 32px;
}
.bd-ap-pourquoi-feature {
  display: flex;
  align-items: flex-start;
  gap: 18px;
  padding: 20px;
  background: var(--blanc-pur);
  border-radius: var(--r-lg);
  border: 1px solid var(--gris-clair);
  transition: var(--tr);
}
.bd-ap-pourquoi-feature:hover {
  border-color: var(--rouge);
  box-shadow: var(--shadow-sm);
  transform: translateX(6px);
}
.bd-ap-pourquoi-feature-icon {
  width: 46px; height: 46px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1rem;
}
.bd-ap-pourquoi-feature-title {
  font-family: var(--ft-display);
  font-size: 1rem; font-weight: 600;
  color: var(--noir); margin-bottom: 4px;
}
.bd-ap-pourquoi-feature-desc {
  font-size: .85rem; color: var(--gris); line-height: 1.65;
}
.bd-ap-pourquoi-imgs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.bd-ap-pourquoi-img-item {
  border-radius: var(--r-lg);
  overflow: hidden;
  position: relative;
}
.bd-ap-pourquoi-img-item:first-child { grid-row: span 2; }
.bd-ap-pourquoi-img-item img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .6s ease;
}
.bd-ap-pourquoi-img-item:hover img { transform: scale(1.06); }

/* ═══════════════════════════════════════════
   SECTION 6 — SERVICES APERÇU
═══════════════════════════════════════════ */
.bd-ap-services-apercu {
  padding: 80px 0;
  background: var(--blanc);
}
.bd-ap-services-apercu-head { text-align: center; margin-bottom: 48px; }
.bd-ap-services-list {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}
.bd-ap-service-item {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 20px;
  background: var(--creme);
  border-radius: var(--r-lg);
  border: 1px solid var(--gris-clair);
  transition: var(--tr);
  text-decoration: none;
}
.bd-ap-service-item:hover {
  background: var(--blanc-pur);
  border-color: var(--rouge);
  transform: translateY(-3px);
  box-shadow: var(--shadow-sm);
}
.bd-ap-service-item-icon {
  width: 44px; height: 44px; flex-shrink: 0;
  background: linear-gradient(135deg, rgba(184,40,42,.1), rgba(184,40,42,.05));
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem; color: var(--rouge);
  transition: var(--tr);
}
.bd-ap-service-item:hover .bd-ap-service-item-icon {
  background: var(--rouge); color: #fff;
}
.bd-ap-service-item-title {
  font-family: var(--ft-display);
  font-size: .95rem; font-weight: 600; color: var(--noir);
  transition: color .25s;
}
.bd-ap-service-item:hover .bd-ap-service-item-title { color: var(--rouge); }

/* ═══════════════════════════════════════════
   SECTION 7 — CTA FINAL
═══════════════════════════════════════════ */
.bd-ap-cta {
  position: relative;
  padding: 100px 0;
  overflow: hidden;
  text-align: center;
}
.bd-ap-cta-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1800&q=80');
  background-size: cover; background-position: center;
  background-attachment: fixed;
}
.bd-ap-cta-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(139,26,28,.92) 0%, rgba(20,15,12,.88) 60%, rgba(139,26,28,.75) 100%);
}
.bd-ap-cta-content {
  position: relative; z-index: 2;
  max-width: 680px; margin: 0 auto;
}
.bd-ap-cta-label {
  font-family: var(--ft-accent); font-style: italic;
  color: var(--or-clair); font-size: 1rem;
  letter-spacing: .08em; margin-bottom: 20px;
  display: block;
}
.bd-ap-cta-title {
  font-family: var(--ft-display);
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 20px;
}
.bd-ap-cta-title em { font-style: italic; color: var(--or-clair); }
.bd-ap-cta-sub {
  color: rgba(255,255,255,.78); font-size: .95rem;
  line-height: 1.75; margin-bottom: 40px;
}
.bd-ap-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
  .bd-ap-histoire-grid { grid-template-columns: 1fr; gap: 60px; }
  .bd-ap-valeurs-grid { grid-template-columns: repeat(2, 1fr); }
  .bd-ap-equipe-grid { grid-template-columns: repeat(2, 1fr); }
  .bd-ap-pourquoi-grid { grid-template-columns: 1fr; gap: 48px; }
  .bd-ap-stats-grid { grid-template-columns: repeat(2, 1fr); }
  .bd-ap-services-list { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .bd-ap-container { padding: 0 20px; }
  .bd-ap-valeurs-grid { grid-template-columns: 1fr; }
  .bd-ap-equipe-grid { grid-template-columns: 1fr; max-width: 380px; margin: 0 auto; }
  .bd-ap-services-list { grid-template-columns: 1fr; }
  .bd-ap-histoire-img-float { display: none; }
  .bd-ap-exp-badge { left: 0; }
  .bd-ap-histoire-imgs { margin-bottom: 40px; }
  .bd-page-hero { height: 320px; }
  .bd-page-hero-content { padding: 0 20px; }
  .bd-ap-pourquoi-imgs { grid-template-columns: 1fr; }
  .bd-ap-pourquoi-img-item:first-child { grid-row: span 1; }
  .bd-ap-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .bd-ap-stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="bd-ap">

<!-- ══════════════════════════════════════════
     HERO BANNIÈRE
══════════════════════════════════════════ -->
<section class="bd-page-hero">
  <div class="bd-page-hero-bg"></div>
  <div class="bd-page-hero-overlay"></div>
  <div class="bd-page-hero-content">
    <div class="bd-page-hero-label">Notre histoire &amp; identité</div>
    <h1 class="bd-page-hero-title">
      À Propos de<br><em>BAOBO DECO</em>
    </h1>
    <div class="bd-page-hero-breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
      <i class="fas fa-chevron-right"></i>
      <span style="color:var(--or-clair);">À Propos</span>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 1 — HISTOIRE
══════════════════════════════════════════ -->
<section class="bd-ap-histoire">
  <div class="bd-ap-container">
    <div class="bd-ap-histoire-grid">

      <!-- Images -->
      <div class="bd-ap-histoire-imgs bd-ap-reveal">
        <div class="bd-ap-exp-badge">
          <span class="bd-ap-exp-badge-num">8</span>
          <span class="bd-ap-exp-badge-label">Ans<br>d'excellence</span>
        </div>
        <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&q=80"
             alt="BAOBO DECO — Showroom Ouagadougou"
             class="bd-ap-histoire-img-main">
        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&q=80"
             alt="Meubles BAOBO DECO"
             class="bd-ap-histoire-img-float">
      </div>

      <!-- Texte -->
      <div class="bd-ap-reveal bd-ap-d2">
        <p class="bd-ap-label">Notre histoire</p>
        <h2 class="bd-ap-title">
          L'histoire d'une passion pour <span class="bd-rouge">l'intérieur burkinabè</span>
        </h2>
        <div class="bd-ap-divider"></div>

        <div class="bd-ap-histoire-text">
          <p>
            Fondée avec la vision de révolutionner la décoration intérieure à Ouagadougou,
            <strong>BAOBO DECO</strong> est née d'une passion profonde pour les espaces beaux,
            fonctionnels et authentiques. Depuis nos débuts, nous avons accompagné des centaines
            de familles, d'entrepreneurs et d'hôteliers dans la transformation de leurs espaces.
          </p>

          <div class="bd-ap-histoire-quote">
            <p>
              Nous croyons que chaque intérieur est le reflet de l'âme de ceux qui l'habitent.
              Notre mission est de vous aider à exprimer cette âme avec élégance et caractère.
            </p>
            <cite>— L'équipe BAOBO DECO</cite>
          </div>

          <p>
            De la sélection minutieuse de nos meubles à la pose soignée de vos rideaux,
            chaque détail compte chez BAOBO DECO. Notre équipe d'experts passionnés met
            tout en œuvre pour que votre projet dépasse vos espérances, dans les délais
            et le budget convenus.
          </p>
          <p>
            Basés à <strong>Tampouy, Ouagadougou</strong>, nous intervenons dans toute
            la capitale et ses environs. Qualité premium, prix compétitifs et service
            client irréprochable — c'est la promesse BAOBO DECO.
          </p>
        </div>

        <div class="bd-ap-histoire-btns">
          <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-ap-btn-primary">
            <i class="fas fa-file-invoice"></i> Demander un devis
          </a>
          <a href="<?php echo esc_url(home_url('/galerie')); ?>" class="bd-ap-btn-border">
            <i class="fas fa-images"></i> Voir nos réalisations
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 2 — CHIFFRES CLÉS
══════════════════════════════════════════ -->
<section class="bd-ap-stats">
  <div class="bd-ap-container">
    <div class="bd-ap-stats-grid">
      <?php foreach ($stats as $stat) : ?>
      <div class="bd-ap-stat-item bd-ap-reveal">
        <div class="bd-ap-stat-icon-wrap">
          <i class="<?php echo esc_attr($stat->icone_fa); ?>"></i>
        </div>
        <div class="bd-ap-stat-num"
             data-target="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $stat->valeur)); ?>">
          <?php echo esc_html($stat->valeur . $stat->suffixe); ?>
        </div>
        <div class="bd-ap-stat-label"><?php echo esc_html($stat->label); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 3 — NOS VALEURS
══════════════════════════════════════════ -->
<section class="bd-ap-valeurs">
  <div class="bd-ap-container">
    <div class="bd-ap-valeurs-head bd-ap-reveal">
      <p class="bd-ap-label" style="justify-content:center;">Ce qui nous définit</p>
      <h2 class="bd-ap-title" style="text-align:center;">Nos <span class="bd-rouge">Valeurs</span></h2>
      <div class="bd-ap-divider center"></div>
      <p style="color:var(--gris);font-size:.95rem;max-width:560px;margin:0 auto;line-height:1.75;text-align:center;">
        Ces valeurs guident chacune de nos décisions et chacun de nos projets depuis notre création.
      </p>
    </div>

    <div class="bd-ap-valeurs-grid">
      <?php
      $valeurs = [
        ['icon'=>'fas fa-gem',          'titre'=>'Excellence',      'desc'=>'Nous ne transigeons jamais sur la qualité. Chaque produit, chaque installation, chaque conseil répond à nos standards d\'excellence les plus élevés.'],
        ['icon'=>'fas fa-handshake',    'titre'=>'Confiance',       'desc'=>'La relation de confiance avec nos clients est notre trésor le plus précieux. Nous tenons toujours nos promesses en matière de délais, de qualité et de prix.'],
        ['icon'=>'fas fa-lightbulb',    'titre'=>'Créativité',      'desc'=>'Chaque espace est unique. Nous apportons une vision créative et personnalisée à chaque projet, adaptée à votre personnalité et votre style de vie.'],
        ['icon'=>'fas fa-users',        'titre'=>'Proximité',       'desc'=>'Nous sommes proches de nos clients, à l\'écoute de leurs besoins et disponibles à chaque étape du projet pour répondre à leurs questions.'],
        ['icon'=>'fas fa-leaf',         'titre'=>'Authenticité',    'desc'=>'Nous valorisons les savoir-faire locaux et sélectionnons des produits de qualité qui reflètent l\'identité et les aspirations burkinabèes.'],
        ['icon'=>'fas fa-award',        'titre'=>'Satisfaction',    'desc'=>'Votre satisfaction est notre récompense ultime. Nous ne considérons un projet terminé que lorsque vous êtes pleinement heureux du résultat final.'],
      ];
      foreach ($valeurs as $i => $v) :
      ?>
      <div class="bd-ap-valeur-card bd-ap-reveal bd-ap-d<?php echo ($i%3)+1; ?>">
        <div class="bd-ap-valeur-icon">
          <i class="<?php echo esc_attr($v['icon']); ?>"></i>
        </div>
        <h3 class="bd-ap-valeur-title"><?php echo esc_html($v['titre']); ?></h3>
        <p class="bd-ap-valeur-desc"><?php echo esc_html($v['desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 4 — NOTRE ÉQUIPE
══════════════════════════════════════════ -->
<section class="bd-ap-equipe">
  <div class="bd-ap-container">
    <div class="bd-ap-equipe-head bd-ap-reveal">
      <p class="bd-ap-label" style="justify-content:center;">Les visages derrière l'excellence</p>
      <h2 class="bd-ap-title" style="text-align:center;">Notre <span class="bd-rouge">Équipe</span></h2>
      <div class="bd-ap-divider center"></div>
      <p style="color:var(--gris);font-size:.95rem;max-width:540px;margin:0 auto;line-height:1.75;text-align:center;">
        Des professionnels passionnés et expérimentés qui donnent vie à vos projets chaque jour.
      </p>
    </div>

    <div class="bd-ap-equipe-grid">
      <?php
      $equipe = [
        ['nom'=>'Inès Sawadogo',    'role'=>'Directrice & Designer',        'initiales'=>'IS', 'bio'=>'Passionnée de décoration depuis toujours, Inès a fondé BAOBO DECO avec la vision de rendre l\'élégance accessible à tous à Ouagadougou.'],
        ['nom'=>'Moussa Kaboré',    'role'=>'Responsable Commercial',       'initiales'=>'MK', 'bio'=>'Avec 6 ans d\'expérience dans le secteur du meuble, Moussa accompagne nos clients avec expertise et bienveillance dans leurs choix.'],
        ['nom'=>'Aminata Traoré',   'role'=>'Conseillère Déco',             'initiales'=>'AT', 'bio'=>'Spécialiste des couleurs et des harmonies d\'espaces, Aminata apporte son œil créatif pour transformer chaque projet en chef-d\'œuvre.'],
      ];
      foreach ($equipe as $i => $m) :
      ?>
      <div class="bd-ap-membre-card bd-ap-reveal bd-ap-d<?php echo $i+1; ?>">
        <div class="bd-ap-membre-img-wrap">
          <img src="https://images.unsplash.com/photo-<?php echo ['1573496359142-b8d87734a5a2','1472099645785-5658abf4ff4e','1580489944761-15a19d654956'][$i]; ?>?w=500&q=80"
               alt="<?php echo esc_attr($m['nom']); ?>" loading="lazy">
          <div class="bd-ap-membre-overlay">
            <a href="#" class="bd-ap-membre-social" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="<?php echo esc_url($wa_url); ?>" class="bd-ap-membre-social" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
        <div class="bd-ap-membre-info">
          <div class="bd-ap-membre-initiales"><?php echo esc_html($m['initiales']); ?></div>
          <h3 class="bd-ap-membre-name"><?php echo esc_html($m['nom']); ?></h3>
          <p class="bd-ap-membre-role"><?php echo esc_html($m['role']); ?></p>
          <p class="bd-ap-membre-bio"><?php echo esc_html($m['bio']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 5 — POURQUOI NOUS CHOISIR
══════════════════════════════════════════ -->
<section class="bd-ap-pourquoi">
  <div class="bd-ap-container">
    <div class="bd-ap-pourquoi-grid">

      <!-- Texte gauche -->
      <div class="bd-ap-reveal">
        <p class="bd-ap-label">Ce qui nous différencie</p>
        <h2 class="bd-ap-title">
          Pourquoi choisir <span class="bd-rouge">BAOBO DECO</span> ?
        </h2>
        <div class="bd-ap-divider"></div>
        <p style="color:var(--gris);font-size:.92rem;line-height:1.8;margin-bottom:8px;">
          Dans un marché où les choix sont nombreux, BAOBO DECO se distingue
          par un engagement total envers la qualité, le service et la satisfaction client.
        </p>

        <div class="bd-ap-pourquoi-features">
          <?php foreach ($atouts as $atout) : ?>
          <div class="bd-ap-pourquoi-feature">
            <div class="bd-ap-pourquoi-feature-icon">
              <i class="<?php echo esc_attr($atout->icone_fa); ?>"></i>
            </div>
            <div>
              <p class="bd-ap-pourquoi-feature-title"><?php echo esc_html($atout->titre); ?></p>
              <p class="bd-ap-pourquoi-feature-desc"><?php echo esc_html($atout->description); ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Images droite -->
      <div class="bd-ap-pourquoi-imgs bd-ap-reveal bd-ap-d2">
        <div class="bd-ap-pourquoi-img-item" style="height:380px;">
          <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600&q=80"
               alt="Intérieur BAOBO DECO" loading="lazy">
        </div>
        <div class="bd-ap-pourquoi-img-item" style="height:180px;">
          <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80"
               alt="Salon BAOBO DECO" loading="lazy">
        </div>
        <div class="bd-ap-pourquoi-img-item" style="height:180px;">
          <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=600&q=80"
               alt="Chambre BAOBO DECO" loading="lazy">
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 6 — APERÇU SERVICES
══════════════════════════════════════════ -->
<section class="bd-ap-services-apercu">
  <div class="bd-ap-container">
    <div class="bd-ap-services-apercu-head bd-ap-reveal">
      <p class="bd-ap-label" style="justify-content:center;">Ce que nous proposons</p>
      <h2 class="bd-ap-title" style="text-align:center;">Nos <span class="bd-rouge">Services</span></h2>
      <div class="bd-ap-divider center"></div>
    </div>
    <div class="bd-ap-services-list">
      <?php foreach ($services as $service) : ?>
      <a href="<?php echo esc_url(home_url('/services')); ?>" class="bd-ap-service-item bd-ap-reveal">
        <div class="bd-ap-service-item-icon">
          <i class="<?php echo esc_attr($service->icone_fa); ?>"></i>
        </div>
        <span class="bd-ap-service-item-title"><?php echo esc_html($service->titre); ?></span>
        <i class="fas fa-arrow-right" style="margin-left:auto;color:var(--rouge);font-size:.75rem;opacity:0;transition:opacity .25s;"></i>
      </a>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:40px;" class="bd-ap-reveal">
      <a href="<?php echo esc_url(home_url('/services')); ?>" class="bd-ap-btn-border">
        <i class="fas fa-concierge-bell"></i> Voir tous nos services
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 7 — CTA FINAL
══════════════════════════════════════════ -->
<section class="bd-ap-cta">
  <div class="bd-ap-cta-bg"></div>
  <div class="bd-ap-cta-overlay"></div>
  <div class="bd-ap-container">
    <div class="bd-ap-cta-content bd-ap-reveal">
      <span class="bd-ap-cta-label">Prêt(e) à transformer votre intérieur ?</span>
      <h2 class="bd-ap-cta-title">
        Commençons votre projet<br><em>ensemble dès aujourd'hui</em>
      </h2>
      <p class="bd-ap-cta-sub">
        Contactez notre équipe pour une consultation gratuite et sans engagement.
        Nous sommes disponibles du lundi au samedi de 8h à 18h.
      </p>
      <div class="bd-ap-cta-btns">
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-ap-btn-primary">
          <i class="fas fa-file-invoice"></i> Demander un Devis Gratuit
        </a>
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-ap-btn-or">
          <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- .bd-ap -->

<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
(function() {
'use strict';

/* ── SCROLL REVEAL ── */
(function() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.bd-ap-reveal').forEach(el => el.classList.add('visible'));
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
  document.querySelectorAll('.bd-ap-reveal').forEach(el => obs.observe(el));
})();

/* ── COUNTER ANIMATION ── */
(function() {
  if (!('IntersectionObserver' in window)) return;
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const el     = e.target;
      const target = parseInt(el.dataset.target || '0');
      if (!target) return;
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
  document.querySelectorAll('.bd-ap-stat-num[data-target]').forEach(c => obs.observe(c));
})();

/* ── SERVICE ITEM — afficher flèche au hover ── */
document.querySelectorAll('.bd-ap-service-item').forEach(item => {
  const arrow = item.querySelector('.fa-arrow-right');
  if (!arrow) return;
  item.addEventListener('mouseenter', () => arrow.style.opacity = '1');
  item.addEventListener('mouseleave', () => arrow.style.opacity = '0');
});

})();
</script>

<?php get_footer(); ?>