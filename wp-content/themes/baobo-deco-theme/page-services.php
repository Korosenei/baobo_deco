<?php
/**
 * Template Name: Page Services BAOBO DECO
 * page-services.php
 */

get_header();

global $wpdb;

function bd_get_sv($key, $default='') {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$services  = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_services WHERE actif=1 ORDER BY ordre ASC");
$stats     = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}baobo_stats ORDER BY ordre ASC");

$wa_num = bd_get_sv('whatsapp_num', '22607592997');
$wa_msg = bd_get_sv('whatsapp_msg', 'Bonjour BAOBO DECO, je souhaite des informations sur vos services.');
$wa_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode($wa_msg);
$tel1   = bd_get_sv('telephone1', '+226 07 59 29 97');
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

.bd-sv * { box-sizing: border-box; }
.bd-sv img { max-width: 100%; display: block; }
.bd-sv a { text-decoration: none; }

/* ═══════════════════════════════════════════
   HERO BANNIÈRE
═══════════════════════════════════════════ */
.bd-sv-hero {
  position: relative;
  height: 420px;
  overflow: hidden;
  display: flex;
  align-items: center;
}
.bd-sv-hero-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1800&q=80');
  background-size: cover;
  background-position: center;
}
.bd-sv-hero-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, rgba(10,8,6,.88) 0%, rgba(10,8,6,.6) 60%, rgba(10,8,6,.2) 100%);
}
.bd-sv-hero-content {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 0 40px; width: 100%;
}
.bd-sv-hero-label {
  display: inline-flex; align-items: center; gap: 8px;
  color: var(--or-clair); font-family: var(--ft-accent);
  font-style: italic; font-size: .9rem; margin-bottom: 16px;
}
.bd-sv-hero-label::before, .bd-sv-hero-label::after {
  content: ''; width: 28px; height: 1px; background: var(--or); display: block;
}
.bd-sv-hero-title {
  font-family: var(--ft-display);
  font-size: clamp(2.2rem, 5vw, 3.8rem);
  font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 20px;
}
.bd-sv-hero-title em { font-style: italic; color: var(--or-clair); }
.bd-sv-hero-breadcrumb {
  display: flex; align-items: center; gap: 8px;
  font-size: .82rem; color: rgba(255,255,255,.6);
}
.bd-sv-hero-breadcrumb a { color: rgba(255,255,255,.6); transition: color .25s; }
.bd-sv-hero-breadcrumb a:hover { color: var(--or-clair); }
.bd-sv-hero-breadcrumb i { font-size: .65rem; color: var(--or); }

/* ═══════════════════════════════════════════
   UTILITAIRES
═══════════════════════════════════════════ */
.bd-sv-container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }

.bd-sv-label {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: var(--ft-accent); font-size: .9rem; font-style: italic;
  color: var(--rouge); letter-spacing: .05em; margin-bottom: 14px;
}
.bd-sv-label::before, .bd-sv-label::after {
  content: ''; width: 28px; height: 1px; background: var(--rouge); display: block;
}
.bd-sv-title {
  font-family: var(--ft-display);
  font-size: clamp(1.9rem, 3.8vw, 2.8rem);
  font-weight: 700; line-height: 1.15; color: var(--noir); margin-bottom: 16px;
}
.bd-sv-title .bd-rouge { color: var(--rouge); }
.bd-sv-divider {
  width: 50px; height: 3px;
  background: linear-gradient(90deg, var(--rouge), var(--or));
  border-radius: 2px; margin-bottom: 24px;
}
.bd-sv-divider.center { margin-left: auto; margin-right: auto; }

/* ── BOUTONS ── */
.bd-sv-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: var(--rouge); color: #fff;
  border: none; cursor: pointer; transition: var(--tr);
  box-shadow: var(--shadow-rouge); text-decoration: none;
}
.bd-sv-btn-primary:hover { background: var(--rouge-fonce); color: #fff; transform: translateY(-2px); }
.bd-sv-btn-or {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: transparent;
  color: var(--or); border: 1.5px solid var(--or);
  cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-sv-btn-or:hover { background: var(--or); color: var(--noir); transform: translateY(-2px); }
.bd-sv-btn-ghost {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: transparent;
  color: #fff; border: 1.5px solid rgba(255,255,255,.5);
  cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-sv-btn-ghost:hover { background: rgba(255,255,255,.12); border-color: #fff; color: #fff; transform: translateY(-2px); }

/* ── REVEAL ── */
.bd-sv-reveal {
  opacity: 0; transform: translateY(36px);
  transition: opacity .7s cubic-bezier(.4,0,.2,1), transform .7s cubic-bezier(.4,0,.2,1);
}
.bd-sv-reveal.visible { opacity: 1; transform: translateY(0); }
.bd-sv-d1 { transition-delay: .1s; }
.bd-sv-d2 { transition-delay: .2s; }
.bd-sv-d3 { transition-delay: .3s; }

/* ═══════════════════════════════════════════
   SECTION 1 — INTRO
═══════════════════════════════════════════ */
.bd-sv-intro {
  padding: 80px 0;
  background: var(--blanc);
}
.bd-sv-intro-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.bd-sv-intro-text p {
  font-size: .95rem; color: var(--gris); line-height: 1.8; margin-bottom: 18px;
}
.bd-sv-intro-text p:last-of-type { margin-bottom: 0; }
.bd-sv-intro-btns { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 32px; }
.bd-sv-intro-img-wrap {
  position: relative;
  border-radius: var(--r-lg);
  overflow: hidden;
  aspect-ratio: 4/3;
}
.bd-sv-intro-img-wrap img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .6s ease;
}
.bd-sv-intro-img-wrap:hover img { transform: scale(1.04); }
.bd-sv-intro-badge {
  position: absolute; bottom: 20px; left: 20px;
  background: var(--rouge); color: #fff;
  padding: 12px 18px; border-radius: var(--r-lg);
  font-size: .8rem; font-weight: 600;
  box-shadow: var(--shadow-rouge);
}
.bd-sv-intro-badge strong {
  display: block;
  font-family: var(--ft-display);
  font-size: 1.6rem; font-weight: 800; line-height: 1;
}

/* ═══════════════════════════════════════════
   SECTION 2 — TOUS LES SERVICES (grille)
═══════════════════════════════════════════ */
.bd-sv-services {
  padding: 100px 0;
  background: var(--creme);
  position: relative; overflow: hidden;
}
.bd-sv-services::before {
  content: 'SERVICES';
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%,-50%);
  font-family: var(--ft-display); font-size: 14vw; font-weight: 900;
  color: rgba(0,0,0,.024); white-space: nowrap; pointer-events: none;
}
.bd-sv-services-head { text-align: center; margin-bottom: 64px; }
.bd-sv-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.bd-sv-card {
  background: var(--blanc-pur);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: var(--tr);
  display: flex; flex-direction: column;
}
.bd-sv-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}
.bd-sv-card-top {
  padding: 36px 32px 28px;
  position: relative;
  border-bottom: 1px solid var(--gris-clair);
  flex: 1;
}
.bd-sv-card-top::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 100%; height: 4px;
  background: linear-gradient(90deg, var(--rouge), var(--or));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform .4s ease;
}
.bd-sv-card:hover .bd-sv-card-top::before { transform: scaleX(1); }
.bd-sv-card-num {
  font-family: var(--ft-display);
  font-size: 3.5rem; font-weight: 900;
  color: rgba(184,40,42,.08);
  line-height: 1;
  position: absolute; top: 16px; right: 24px;
}
.bd-sv-card-icon-wrap {
  width: 60px; height: 60px;
  background: linear-gradient(135deg, rgba(184,40,42,.1), rgba(184,40,42,.04));
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem; color: var(--rouge);
  margin-bottom: 20px; transition: var(--tr);
}
.bd-sv-card:hover .bd-sv-card-icon-wrap {
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  color: #fff;
}
.bd-sv-card-title {
  font-family: var(--ft-display);
  font-size: 1.2rem; font-weight: 700;
  color: var(--noir); margin-bottom: 12px;
}
.bd-sv-card-desc {
  font-size: .88rem; color: var(--gris); line-height: 1.75;
}
.bd-sv-card-bottom {
  padding: 20px 32px;
  display: flex; align-items: center; justify-content: space-between;
  background: var(--creme);
}
.bd-sv-card-link {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: .78rem; font-weight: 600;
  color: var(--rouge); text-transform: uppercase; letter-spacing: .08em;
  text-decoration: none; transition: gap .25s;
}
.bd-sv-card:hover .bd-sv-card-link { gap: 10px; }
.bd-sv-card-link i { font-size: .7rem; }
.bd-sv-card-prix {
  font-family: var(--ft-accent);
  font-style: italic; font-size: .85rem; color: var(--gris);
}

/* ═══════════════════════════════════════════
   SECTION 3 — PROCESSUS DE TRAVAIL
═══════════════════════════════════════════ */
.bd-sv-processus {
  padding: 100px 0;
  background: var(--blanc);
}
.bd-sv-processus-head { text-align: center; margin-bottom: 64px; }
.bd-sv-steps {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
  position: relative;
}
.bd-sv-steps::before {
  content: '';
  position: absolute;
  top: 40px; left: 10%; right: 10%;
  height: 2px;
  background: linear-gradient(90deg, var(--rouge), var(--or), var(--rouge));
  z-index: 0;
}
.bd-sv-step {
  display: flex; flex-direction: column;
  align-items: center; text-align: center;
  padding: 0 20px;
  position: relative; z-index: 1;
}
.bd-sv-step-num {
  width: 80px; height: 80px;
  background: var(--blanc-pur);
  border: 3px solid var(--rouge);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--ft-display);
  font-size: 1.5rem; font-weight: 800;
  color: var(--rouge);
  margin-bottom: 28px;
  transition: var(--tr);
  box-shadow: var(--shadow-sm);
}
.bd-sv-step:hover .bd-sv-step-num {
  background: var(--rouge);
  color: #fff;
  transform: scale(1.1);
  box-shadow: var(--shadow-rouge);
}
.bd-sv-step-icon {
  font-size: 1.3rem; color: var(--rouge);
  margin-bottom: 16px; transition: color .3s;
}
.bd-sv-step:hover .bd-sv-step-icon { color: var(--or); }
.bd-sv-step-title {
  font-family: var(--ft-display);
  font-size: 1.05rem; font-weight: 700;
  color: var(--noir); margin-bottom: 10px;
}
.bd-sv-step-desc {
  font-size: .85rem; color: var(--gris); line-height: 1.7;
}

/* ═══════════════════════════════════════════
   SECTION 4 — DÉTAIL CHAQUE SERVICE
═══════════════════════════════════════════ */
.bd-sv-details {
  padding: 100px 0;
  background: var(--creme);
}
.bd-sv-detail-block {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
  padding: 60px 0;
  border-bottom: 1px solid var(--gris-clair);
}
.bd-sv-detail-block:first-child { padding-top: 0; }
.bd-sv-detail-block:last-child { border-bottom: none; padding-bottom: 0; }
.bd-sv-detail-block.reverse { direction: rtl; }
.bd-sv-detail-block.reverse > * { direction: ltr; }
.bd-sv-detail-img {
  border-radius: var(--r-lg);
  overflow: hidden;
  position: relative;
}
.bd-sv-detail-img img {
  width: 100%; aspect-ratio: 4/3;
  object-fit: cover; display: block;
  transition: transform .6s ease;
}
.bd-sv-detail-img:hover img { transform: scale(1.04); }
.bd-sv-detail-img-badge {
  position: absolute; top: 16px; left: 16px;
  background: var(--rouge); color: #fff;
  padding: 8px 14px; border-radius: var(--r);
  font-size: .72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em;
}
.bd-sv-detail-content {}
.bd-sv-detail-num {
  font-family: var(--ft-display);
  font-size: 4rem; font-weight: 900;
  color: rgba(184,40,42,.07); line-height: 1;
  margin-bottom: -16px;
}
.bd-sv-detail-icon {
  width: 56px; height: 56px;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.3rem; color: #fff;
  margin-bottom: 20px;
}
.bd-sv-detail-title {
  font-family: var(--ft-display);
  font-size: 1.6rem; font-weight: 700;
  color: var(--noir); margin-bottom: 16px; line-height: 1.2;
}
.bd-sv-detail-desc {
  font-size: .92rem; color: var(--gris); line-height: 1.8; margin-bottom: 24px;
}
.bd-sv-detail-features {
  display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px;
}
.bd-sv-detail-feature {
  display: flex; align-items: center; gap: 12px;
  font-size: .88rem; color: var(--gris-fonce);
}
.bd-sv-detail-feature i {
  width: 20px; height: 20px;
  background: rgba(184,40,42,.1); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--rouge); font-size: .65rem; flex-shrink: 0;
}

/* ═══════════════════════════════════════════
   SECTION 5 — STATS
═══════════════════════════════════════════ */
.bd-sv-stats {
  padding: 80px 0;
  background: var(--noir-doux);
  position: relative; overflow: hidden;
}
.bd-sv-stats::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--rouge-fonce), var(--rouge), var(--or), var(--rouge));
}
.bd-sv-stats-grid {
  display: grid;
  grid-template-columns: repeat(4,1fr);
  gap: 0;
}
.bd-sv-stat-item {
  display: flex; flex-direction: column; align-items: center;
  padding: 40px 20px; text-align: center;
  border-right: 1px solid rgba(255,255,255,.08);
  transition: var(--tr); cursor: default;
}
.bd-sv-stat-item:last-child { border-right: none; }
.bd-sv-stat-item:hover { background: rgba(184,40,42,.12); }
.bd-sv-stat-icon {
  width: 54px; height: 54px;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem; color: #fff; margin-bottom: 18px;
}
.bd-sv-stat-num {
  font-family: var(--ft-display);
  font-size: 2.8rem; font-weight: 800;
  color: var(--or); line-height: 1; margin-bottom: 6px;
}
.bd-sv-stat-label {
  font-size: .75rem; font-weight: 600;
  color: rgba(255,255,255,.5);
  text-transform: uppercase; letter-spacing: .1em;
}

/* ═══════════════════════════════════════════
   SECTION 6 — TARIFS / DEVIS
═══════════════════════════════════════════ */
.bd-sv-tarifs {
  padding: 100px 0;
  background: var(--blanc);
}
.bd-sv-tarifs-head { text-align: center; margin-bottom: 64px; }
.bd-sv-tarifs-grid {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 28px;
}
.bd-sv-tarif-card {
  background: var(--blanc-pur);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg);
  padding: 40px 32px;
  text-align: center;
  transition: var(--tr);
  position: relative;
  overflow: hidden;
}
.bd-sv-tarif-card:hover {
  transform: translateY(-6px);
  box-shadow: var(--shadow-lg);
  border-color: transparent;
}
.bd-sv-tarif-card.featured {
  background: var(--rouge);
  border-color: var(--rouge);
}
.bd-sv-tarif-card.featured:hover { box-shadow: var(--shadow-rouge); }
.bd-sv-tarif-badge {
  position: absolute; top: -1px; left: 50%;
  transform: translateX(-50%);
  background: var(--or); color: var(--noir);
  font-size: .7rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .1em;
  padding: 5px 16px; border-radius: 0 0 8px 8px;
}
.bd-sv-tarif-icon {
  width: 64px; height: 64px;
  background: rgba(184,40,42,.08);
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; color: var(--rouge);
  margin: 0 auto 20px;
}
.bd-sv-tarif-card.featured .bd-sv-tarif-icon {
  background: rgba(255,255,255,.15); color: #fff;
}
.bd-sv-tarif-title {
  font-family: var(--ft-display);
  font-size: 1.25rem; font-weight: 700;
  color: var(--noir); margin-bottom: 8px;
}
.bd-sv-tarif-card.featured .bd-sv-tarif-title { color: #fff; }
.bd-sv-tarif-desc {
  font-size: .85rem; color: var(--gris);
  line-height: 1.65; margin-bottom: 28px;
}
.bd-sv-tarif-card.featured .bd-sv-tarif-desc { color: rgba(255,255,255,.75); }
.bd-sv-tarif-sep {
  width: 40px; height: 2px;
  background: var(--or); margin: 0 auto 24px;
  border-radius: 2px;
}
.bd-sv-tarif-features {
  display: flex; flex-direction: column; gap: 10px;
  text-align: left; margin-bottom: 32px;
}
.bd-sv-tarif-feature {
  display: flex; align-items: center; gap: 10px;
  font-size: .85rem; color: var(--gris-fonce);
}
.bd-sv-tarif-card.featured .bd-sv-tarif-feature { color: rgba(255,255,255,.9); }
.bd-sv-tarif-feature i { color: var(--rouge); font-size: .85rem; flex-shrink: 0; }
.bd-sv-tarif-card.featured .bd-sv-tarif-feature i { color: var(--or-clair); }
.bd-sv-tarif-cta {
  display: block; width: 100%;
  padding: 12px 0; border-radius: var(--r);
  font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  background: var(--rouge); color: #fff;
  border: none; cursor: pointer; transition: var(--tr); text-decoration: none;
  text-align: center;
}
.bd-sv-tarif-card.featured .bd-sv-tarif-cta {
  background: #fff; color: var(--rouge);
}
.bd-sv-tarif-cta:hover { opacity: .88; transform: translateY(-2px); }

/* ═══════════════════════════════════════════
   SECTION 7 — FAQ
═══════════════════════════════════════════ */
.bd-sv-faq {
  padding: 100px 0;
  background: var(--creme);
}
.bd-sv-faq-grid {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 80px;
  align-items: start;
}
.bd-sv-faq-left p {
  font-size: .92rem; color: var(--gris); line-height: 1.8; margin-bottom: 28px;
}
.bd-sv-faq-contact {
  background: var(--rouge);
  border-radius: var(--r-lg);
  padding: 28px;
  color: #fff;
}
.bd-sv-faq-contact h4 {
  font-family: var(--ft-display);
  font-size: 1.1rem; margin-bottom: 12px;
}
.bd-sv-faq-contact p {
  font-size: .85rem; color: rgba(255,255,255,.75);
  line-height: 1.65; margin-bottom: 20px;
}
.bd-sv-faq-contact-links {
  display: flex; flex-direction: column; gap: 10px;
}
.bd-sv-faq-contact-link {
  display: flex; align-items: center; gap: 10px;
  color: rgba(255,255,255,.85); font-size: .88rem; text-decoration: none;
  transition: color .25s;
}
.bd-sv-faq-contact-link:hover { color: var(--or-clair); }
.bd-sv-faq-contact-link i { color: var(--or-clair); width: 16px; }
.bd-sv-faq-list { display: flex; flex-direction: column; gap: 12px; }
.bd-sv-faq-item {
  background: var(--blanc-pur);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg);
  overflow: hidden;
  transition: var(--tr);
}
.bd-sv-faq-item.open { border-color: var(--rouge); box-shadow: var(--shadow-sm); }
.bd-sv-faq-question {
  display: flex; align-items: center; justify-content: space-between;
  padding: 20px 24px;
  cursor: pointer;
  font-family: var(--ft-display);
  font-size: 1rem; font-weight: 600; color: var(--noir);
  transition: color .25s;
  user-select: none;
}
.bd-sv-faq-item.open .bd-sv-faq-question { color: var(--rouge); }
.bd-sv-faq-question-icon {
  width: 28px; height: 28px; flex-shrink: 0;
  background: rgba(184,40,42,.08);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--rouge); font-size: .75rem;
  transition: var(--tr);
}
.bd-sv-faq-item.open .bd-sv-faq-question-icon {
  background: var(--rouge); color: #fff;
  transform: rotate(180deg);
}
.bd-sv-faq-answer {
  max-height: 0; overflow: hidden;
  transition: max-height .4s ease, padding .4s ease;
  padding: 0 24px;
}
.bd-sv-faq-item.open .bd-sv-faq-answer {
  max-height: 300px;
  padding: 0 24px 20px;
}
.bd-sv-faq-answer p {
  font-size: .88rem; color: var(--gris); line-height: 1.75;
}

/* ═══════════════════════════════════════════
   SECTION 8 — CTA FINAL
═══════════════════════════════════════════ */
.bd-sv-cta {
  position: relative; padding: 100px 0; overflow: hidden; text-align: center;
}
.bd-sv-cta-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1800&q=80');
  background-size: cover; background-position: center; background-attachment: fixed;
}
.bd-sv-cta-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(139,26,28,.93) 0%, rgba(20,15,12,.88) 60%, rgba(139,26,28,.75) 100%);
}
.bd-sv-cta-content { position: relative; z-index: 2; max-width: 680px; margin: 0 auto; }
.bd-sv-cta-label {
  font-family: var(--ft-accent); font-style: italic;
  color: var(--or-clair); font-size: 1rem;
  letter-spacing: .08em; margin-bottom: 20px; display: block;
}
.bd-sv-cta-title {
  font-family: var(--ft-display);
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 20px;
}
.bd-sv-cta-title em { font-style: italic; color: var(--or-clair); }
.bd-sv-cta-sub {
  color: rgba(255,255,255,.78); font-size: .95rem; line-height: 1.75; margin-bottom: 40px;
}
.bd-sv-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
  .bd-sv-intro-grid { grid-template-columns: 1fr; gap: 48px; }
  .bd-sv-grid { grid-template-columns: repeat(2,1fr); }
  .bd-sv-steps { grid-template-columns: repeat(2,1fr); gap: 40px; }
  .bd-sv-steps::before { display: none; }
  .bd-sv-detail-block { grid-template-columns: 1fr; gap: 40px; }
  .bd-sv-detail-block.reverse { direction: ltr; }
  .bd-sv-stats-grid { grid-template-columns: repeat(2,1fr); }
  .bd-sv-tarifs-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
  .bd-sv-faq-grid { grid-template-columns: 1fr; gap: 48px; }
}
@media (max-width: 768px) {
  .bd-sv-container { padding: 0 20px; }
  .bd-sv-grid { grid-template-columns: 1fr; }
  .bd-sv-steps { grid-template-columns: 1fr 1fr; }
  .bd-sv-hero { height: 320px; }
  .bd-sv-hero-content { padding: 0 20px; }
}
@media (max-width: 480px) {
  .bd-sv-steps { grid-template-columns: 1fr; }
  .bd-sv-stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="bd-sv">

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="bd-sv-hero">
  <div class="bd-sv-hero-bg"></div>
  <div class="bd-sv-hero-overlay"></div>
  <div class="bd-sv-hero-content">
    <div class="bd-sv-hero-label">Ce que nous proposons</div>
    <h1 class="bd-sv-hero-title">
      Nos <em>Services</em><br>à Ouagadougou
    </h1>
    <div class="bd-sv-hero-breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
      <i class="fas fa-chevron-right"></i>
      <span style="color:var(--or-clair);">Services</span>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 1 — INTRO
══════════════════════════════════════════ -->
<section class="bd-sv-intro">
  <div class="bd-sv-container">
    <div class="bd-sv-intro-grid">

      <div class="bd-sv-reveal">
        <p class="bd-sv-label">Notre expertise</p>
        <h2 class="bd-sv-title">
          Des services complets pour <span class="bd-rouge">votre intérieur</span>
        </h2>
        <div class="bd-sv-divider"></div>
        <div class="bd-sv-intro-text">
          <p>
            Chez BAOBO DECO, nous offrons une gamme complète de services dédiés à
            l'embellissement et à la transformation de vos espaces intérieurs.
            Du conseil personnalisé à la livraison et l'installation, nous vous accompagnons
            à chaque étape de votre projet avec professionnalisme et passion.
          </p>
          <p>
            Que vous souhaitiez décorer un salon, aménager un bureau, meubler une chambre
            ou habiller vos fenêtres, notre équipe d'experts est là pour vous offrir
            le meilleur de la décoration intérieure à Ouagadougou.
          </p>
        </div>
        <div class="bd-sv-intro-btns">
          <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-sv-btn-primary">
            <i class="fas fa-file-invoice"></i> Demander un devis gratuit
          </a>
          <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-sv-btn-or">
            <i class="fab fa-whatsapp"></i> WhatsApp
          </a>
        </div>
      </div>

      <div class="bd-sv-reveal bd-sv-d2">
        <div class="bd-sv-intro-img-wrap">
          <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&q=80"
               alt="Services BAOBO DECO" loading="lazy">
          <div class="bd-sv-intro-badge">
            <strong><?php echo count($services) ?: 6; ?></strong>
            Services disponibles
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 2 — TOUS LES SERVICES
══════════════════════════════════════════ -->
<section class="bd-sv-services" id="nos-services">
  <div class="bd-sv-container">
    <div class="bd-sv-services-head bd-sv-reveal">
      <p class="bd-sv-label" style="justify-content:center;">Ce que nous faisons</p>
      <h2 class="bd-sv-title" style="text-align:center;">
        Tous nos <span class="bd-rouge">Services</span>
      </h2>
      <div class="bd-sv-divider center"></div>
      <p style="color:var(--gris);font-size:.95rem;max-width:560px;margin:0 auto;line-height:1.75;text-align:center;">
        De la conception à la réalisation, nous prenons en charge chaque aspect de votre projet de décoration.
      </p>
    </div>

    <div class="bd-sv-grid">
      <?php foreach ($services as $i => $service) : ?>
      <div class="bd-sv-card bd-sv-reveal bd-sv-d<?php echo ($i%3)+1; ?>">
        <div class="bd-sv-card-top">
          <div class="bd-sv-card-num"><?php echo str_pad($i+1, 2, '0', STR_PAD_LEFT); ?></div>
          <div class="bd-sv-card-icon-wrap">
            <i class="<?php echo esc_attr($service->icone_fa); ?>"></i>
          </div>
          <h3 class="bd-sv-card-title"><?php echo esc_html($service->titre); ?></h3>
          <p class="bd-sv-card-desc"><?php echo esc_html($service->description); ?></p>
        </div>
        <div class="bd-sv-card-bottom">
          <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-sv-card-link">
            Demander un devis <i class="fas fa-arrow-right"></i>
          </a>
          <span class="bd-sv-card-prix">Sur devis</span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 3 — PROCESSUS DE TRAVAIL
══════════════════════════════════════════ -->
<section class="bd-sv-processus">
  <div class="bd-sv-container">
    <div class="bd-sv-processus-head bd-sv-reveal">
      <p class="bd-sv-label" style="justify-content:center;">Comment ça marche</p>
      <h2 class="bd-sv-title" style="text-align:center;">
        Notre <span class="bd-rouge">Processus</span> de travail
      </h2>
      <div class="bd-sv-divider center"></div>
    </div>

    <div class="bd-sv-steps">
      <?php
      $steps = [
        ['num'=>'01', 'icon'=>'fas fa-comments',          'titre'=>'Consultation',       'desc'=>'Premier contact gratuit pour comprendre votre projet, vos goûts et votre budget disponible.'],
        ['num'=>'02', 'icon'=>'fas fa-drafting-compass',  'titre'=>'Conception',         'desc'=>'Nos designers créent des propositions personnalisées adaptées à votre espace et votre style.'],
        ['num'=>'03', 'icon'=>'fas fa-shopping-bag',      'titre'=>'Sélection',          'desc'=>'Choix des meubles, matériaux et accessoires dans notre catalogue ou sur commande spéciale.'],
        ['num'=>'04', 'icon'=>'fas fa-truck',             'titre'=>'Livraison & Pose',   'desc'=>'Installation professionnelle par notre équipe dans les délais convenus, à Ouagadougou.'],
      ];
      foreach ($steps as $i => $step) :
      ?>
      <div class="bd-sv-step bd-sv-reveal bd-sv-d<?php echo $i+1; ?>">
        <div class="bd-sv-step-num"><?php echo $step['num']; ?></div>
        <i class="<?php echo $step['icon']; ?> bd-sv-step-icon"></i>
        <h3 class="bd-sv-step-title"><?php echo $step['titre']; ?></h3>
        <p class="bd-sv-step-desc"><?php echo $step['desc']; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 4 — DÉTAIL SERVICES
══════════════════════════════════════════ -->
<section class="bd-sv-details">
  <div class="bd-sv-container">

    <?php
    $details_imgs = [
      'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&q=80',
      'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=80',
      'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=800&q=80',
      'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80',
      'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
      'https://images.unsplash.com/photo-1615800098779-1be32e60cca3?w=800&q=80',
    ];
    $details_features = [
      ['Étude personnalisée de votre espace', 'Proposition de palettes de couleurs', 'Sélection mobilier & accessoires', 'Suivi complet du projet'],
      ['Catalogue de plus de 500 références', 'Meubles modernes et contemporains', 'Livraison et montage inclus', 'Garantie qualité 2 ans'],
      ['Optimisation de chaque mètre carré', 'Plans 3D de votre futur espace', 'Gestion des travaux si nécessaire', 'Résultat clé en main'],
      ['Conseil en décoration offert', 'Visite à domicile sur rendez-vous', 'Accompagnement pas à pas', 'Devis gratuit et sans engagement'],
      ['Rideaux, voilages, stores', 'Mesure et découpe sur mesure', 'Pose professionnelle garantie', 'Large choix de tissus et matières'],
      ['Délais de livraison rapides', 'Équipe de montage qualifiée', 'Assurance transport incluse', 'Service après-livraison disponible'],
    ];

    foreach ($services as $i => $service) :
      $reverse = ($i % 2 !== 0) ? ' reverse' : '';
      $img     = $details_imgs[$i] ?? $details_imgs[0];
      $feats   = $details_features[$i] ?? $details_features[0];
    ?>
    <div class="bd-sv-detail-block<?php echo $reverse; ?> bd-sv-reveal">
      <!-- Image -->
      <div class="bd-sv-detail-img">
        <img src="<?php echo esc_url($img); ?>"
             alt="<?php echo esc_attr($service->titre); ?>" loading="lazy">
        <div class="bd-sv-detail-img-badge">
          <i class="<?php echo esc_attr($service->icone_fa); ?>"></i>
          <?php echo esc_html($service->titre); ?>
        </div>
      </div>
      <!-- Contenu -->
      <div class="bd-sv-detail-content bd-sv-reveal bd-sv-d2">
        <div class="bd-sv-detail-num"><?php echo str_pad($i+1, 2, '0', STR_PAD_LEFT); ?></div>
        <div class="bd-sv-detail-icon">
          <i class="<?php echo esc_attr($service->icone_fa); ?>"></i>
        </div>
        <h3 class="bd-sv-detail-title"><?php echo esc_html($service->titre); ?></h3>
        <p class="bd-sv-detail-desc"><?php echo esc_html($service->description); ?></p>
        <div class="bd-sv-detail-features">
          <?php foreach ($feats as $feat) : ?>
          <div class="bd-sv-detail-feature">
            <i class="fas fa-check"></i>
            <?php echo esc_html($feat); ?>
          </div>
          <?php endforeach; ?>
        </div>
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-sv-btn-primary">
          <i class="fas fa-file-alt"></i> Demander un devis
        </a>
      </div>
    </div>
    <?php endforeach; ?>

  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 5 — STATS
══════════════════════════════════════════ -->
<section class="bd-sv-stats">
  <div class="bd-sv-container">
    <div class="bd-sv-stats-grid">
      <?php foreach ($stats as $stat) : ?>
      <div class="bd-sv-stat-item bd-sv-reveal">
        <div class="bd-sv-stat-icon"><i class="<?php echo esc_attr($stat->icone_fa); ?>"></i></div>
        <div class="bd-sv-stat-num"
             data-target="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $stat->valeur)); ?>">
          <?php echo esc_html($stat->valeur . $stat->suffixe); ?>
        </div>
        <div class="bd-sv-stat-label"><?php echo esc_html($stat->label); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 6 — TARIFS
══════════════════════════════════════════ -->
<section class="bd-sv-tarifs">
  <div class="bd-sv-container">
    <div class="bd-sv-tarifs-head bd-sv-reveal">
      <p class="bd-sv-label" style="justify-content:center;">Nos formules</p>
      <h2 class="bd-sv-title" style="text-align:center;">
        Des formules adaptées à <span class="bd-rouge">votre budget</span>
      </h2>
      <div class="bd-sv-divider center"></div>
      <p style="color:var(--gris);font-size:.95rem;max-width:560px;margin:0 auto;line-height:1.75;text-align:center;">
        Tous nos devis sont gratuits et sans engagement. Contactez-nous pour une estimation personnalisée.
      </p>
    </div>

    <div class="bd-sv-tarifs-grid">
      <?php
      $tarifs = [
        [
          'icon'     => 'fas fa-home',
          'titre'    => 'Essentiel',
          'desc'     => 'Idéal pour une pièce ou un projet de décoration simple.',
          'featured' => false,
          'features' => ['Consultation initiale', 'Conseil en décoration', 'Sélection de produits', 'Livraison incluse'],
        ],
        [
          'icon'     => 'fas fa-star',
          'titre'    => 'Premium',
          'desc'     => 'Pour un aménagement complet avec suivi personnalisé.',
          'featured' => true,
          'badge'    => 'Le plus populaire',
          'features' => ['Tout Essentiel inclus', 'Aménagement complet', 'Plans 3D de l\'espace', 'Suivi de chantier', 'Garantie satisfaction'],
        ],
        [
          'icon'     => 'fas fa-building',
          'titre'    => 'Entreprise',
          'desc'     => 'Pour les hôtels, restaurants, bureaux et grands projets.',
          'featured' => false,
          'features' => ['Tout Premium inclus', 'Gestion de projet dédiée', 'Délais prioritaires', 'Tarifs négociés', 'SAV prioritaire'],
        ],
      ];
      foreach ($tarifs as $t) :
      ?>
      <div class="bd-sv-tarif-card<?php echo $t['featured'] ? ' featured' : ''; ?> bd-sv-reveal">
        <?php if (!empty($t['badge'])) : ?>
        <div class="bd-sv-tarif-badge"><?php echo esc_html($t['badge']); ?></div>
        <?php endif; ?>
        <div class="bd-sv-tarif-icon"><i class="<?php echo $t['icon']; ?>"></i></div>
        <h3 class="bd-sv-tarif-title"><?php echo esc_html($t['titre']); ?></h3>
        <p class="bd-sv-tarif-desc"><?php echo esc_html($t['desc']); ?></p>
        <div class="bd-sv-tarif-sep"></div>
        <div class="bd-sv-tarif-features">
          <?php foreach ($t['features'] as $f) : ?>
          <div class="bd-sv-tarif-feature">
            <i class="fas fa-check-circle"></i>
            <?php echo esc_html($f); ?>
          </div>
          <?php endforeach; ?>
        </div>
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-sv-tarif-cta">
          Demander un devis
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 7 — FAQ
══════════════════════════════════════════ -->
<section class="bd-sv-faq">
  <div class="bd-sv-container">
    <div class="bd-sv-faq-grid">

      <!-- Gauche -->
      <div class="bd-sv-reveal">
        <p class="bd-sv-label">Questions fréquentes</p>
        <h2 class="bd-sv-title">
          Vous avez des <span class="bd-rouge">questions ?</span>
        </h2>
        <div class="bd-sv-divider"></div>
        <p>
          Nous avons rassemblé les questions les plus fréquentes de nos clients.
          Si vous ne trouvez pas la réponse à votre question, n'hésitez pas à nous contacter directement.
        </p>
        <div class="bd-sv-faq-contact">
          <h4>Besoin d'aide ?</h4>
          <p>Notre équipe est disponible du lundi au samedi de 8h à 18h pour répondre à toutes vos questions.</p>
          <div class="bd-sv-faq-contact-links">
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $tel1)); ?>"
               class="bd-sv-faq-contact-link">
              <i class="fas fa-phone-alt"></i> <?php echo esc_html($tel1); ?>
            </a>
            <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener"
               class="bd-sv-faq-contact-link">
              <i class="fab fa-whatsapp"></i> WhatsApp disponible
            </a>
          </div>
        </div>
      </div>

      <!-- Droite — accordéon FAQ -->
      <div class="bd-sv-reveal bd-sv-d2">
        <div class="bd-sv-faq-list" id="bdFaqList">
          <?php
          $faqs = [
            ['q'=>'Comment se passe une première consultation ?',
             'r'=>'La première consultation est gratuite. Nous nous déplaçons chez vous ou vous pouvez nous rendre visite à notre showroom à Tampouy. Nous discutons de votre projet, vos goûts, votre budget et nous vous proposons des solutions adaptées.'],
            ['q'=>'Quels sont vos délais de livraison ?',
             'r'=>'Nos délais varient selon la nature du projet. Pour les articles en stock, la livraison est généralement sous 48h à Ouagadougou. Pour les commandes sur mesure ou spéciales, comptez 2 à 4 semaines selon les fournisseurs.'],
            ['q'=>'Livrez-vous en dehors d\'Ouagadougou ?',
             'r'=>'Nous intervenons principalement à Ouagadougou et ses environs. Pour les projets en dehors de la capitale, contactez-nous pour une estimation des frais supplémentaires de déplacement et de livraison.'],
            ['q'=>'Proposez-vous des garanties sur vos produits ?',
             'r'=>'Oui, tous nos produits sont garantis. Nous proposons une garantie de 2 ans sur les défauts de fabrication pour les meubles. Pour les installations (rideaux, stores), nous garantissons la qualité de la pose pendant 1 an.'],
            ['q'=>'Peut-on payer en plusieurs fois ?',
             'r'=>'Nous proposons la possibilité de payer en plusieurs versements pour les projets importants. Un acompte de 30% est généralement demandé à la commande, le solde étant réglé à la livraison. Contactez-nous pour discuter des modalités.'],
            ['q'=>'Peut-on modifier une commande après validation ?',
             'r'=>'Les modifications sont possibles avant le début de la fabrication ou de la livraison. Au-delà, des frais peuvent s\'appliquer. Nous vous recommandons de confirmer tous les détails avant la validation finale de votre commande.'],
          ];
          foreach ($faqs as $i => $faq) :
          ?>
          <div class="bd-sv-faq-item<?php echo $i === 0 ? ' open' : ''; ?>">
            <div class="bd-sv-faq-question" onclick="bdToggleFaq(this.parentElement)">
              <?php echo esc_html($faq['q']); ?>
              <span class="bd-sv-faq-question-icon"><i class="fas fa-chevron-down"></i></span>
            </div>
            <div class="bd-sv-faq-answer">
              <p><?php echo esc_html($faq['r']); ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 8 — CTA FINAL
══════════════════════════════════════════ -->
<section class="bd-sv-cta">
  <div class="bd-sv-cta-bg"></div>
  <div class="bd-sv-cta-overlay"></div>
  <div class="bd-sv-container">
    <div class="bd-sv-cta-content bd-sv-reveal">
      <span class="bd-sv-cta-label">Prêt(e) à transformer votre espace ?</span>
      <h2 class="bd-sv-cta-title">
        Demandez votre devis<br><em>gratuit dès aujourd'hui</em>
      </h2>
      <p class="bd-sv-cta-sub">
        Nos experts vous répondent sous 24h avec une proposition personnalisée
        et sans engagement. Consultation gratuite à Ouagadougou.
      </p>
      <div class="bd-sv-cta-btns">
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-sv-btn-primary">
          <i class="fas fa-file-invoice"></i> Demander un Devis Gratuit
        </a>
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-sv-btn-ghost">
          <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- .bd-sv -->

<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
(function() {
'use strict';

/* ── SCROLL REVEAL ── */
(function() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.bd-sv-reveal').forEach(el => el.classList.add('visible'));
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
  document.querySelectorAll('.bd-sv-reveal').forEach(el => obs.observe(el));
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
  document.querySelectorAll('.bd-sv-stat-num[data-target]').forEach(c => obs.observe(c));
})();

/* ── FAQ ACCORDION ── */
window.bdToggleFaq = function(item) {
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.bd-sv-faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
};

})();
</script>

<?php get_footer(); ?>