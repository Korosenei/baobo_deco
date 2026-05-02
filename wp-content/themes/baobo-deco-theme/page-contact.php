<?php
/**
 * Template Name: Page Contact BAOBO DECO
 * page-contact.php
 */

get_header();

global $wpdb;

function bd_get_ct($key, $default='') {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$tel1      = bd_get_ct('telephone1',    '+226 07 59 29 97');
$tel2      = bd_get_ct('telephone2',    '+226 70 53 76 58');
$tel3      = bd_get_ct('telephone3',    '+226 78 62 27 28');
$email     = bd_get_ct('email',         'contact@baobodeco.bf');
$adresse   = bd_get_ct('adresse',       'Tampouy, Ouagadougou, Burkina Faso');
$horaires  = bd_get_ct('horaires',      'Lun – Sam : 8h00 – 18h00');
$facebook  = bd_get_ct('facebook_url',  '');
$instagram = bd_get_ct('instagram_url', '');
$tiktok    = bd_get_ct('tiktok_url',    '');
$wa_num    = bd_get_ct('whatsapp_num',  '22607592997');
$wa_msg    = bd_get_ct('whatsapp_msg',  'Bonjour BAOBO DECO, je souhaite vous contacter.');
$wa_url    = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode($wa_msg);
$tel1_clean = preg_replace('/[^0-9+]/', '', $tel1);
$tel2_clean = preg_replace('/[^0-9+]/', '', $tel2);
$tel3_clean = preg_replace('/[^0-9+]/', '', $tel3);

/* ── Traitement du formulaire ── */
$form_success = false;
$form_errors  = [];

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bd_ct_nonce']) ) {
    if ( wp_verify_nonce( sanitize_text_field($_POST['bd_ct_nonce']), 'bd_contact_form' ) ) {

        $nom       = sanitize_text_field($_POST['nom']       ?? '');
        $telephone = sanitize_text_field($_POST['telephone'] ?? '');
        $mail      = sanitize_email($_POST['email']          ?? '');
        $projet    = sanitize_text_field($_POST['projet']    ?? '');
        $message   = sanitize_textarea_field($_POST['message'] ?? '');

        if ( empty($nom) )       $form_errors[] = 'Le nom est requis.';
        if ( empty($telephone) ) $form_errors[] = 'Le téléphone est requis.';
        if ( empty($message) )   $form_errors[] = 'Le message est requis.';

        if ( empty($form_errors) ) {
            /* Envoi email */
            $to      = $email;
            $subject = '[BAOBO DECO] Nouveau message de ' . $nom;
            $body    = "Nom : $nom\nTéléphone : $telephone\nEmail : $mail\nType de projet : $projet\n\nMessage :\n$message";
            $headers = ['Content-Type: text/plain; charset=UTF-8'];
            if ( !empty($mail) ) $headers[] = 'Reply-To: ' . $mail;

            wp_mail($to, $subject, $body, $headers);

            /* Sauvegarde en BDD optionnelle */
            $wpdb->insert(
                $wpdb->prefix . 'baobo_messages',
                [
                    'nom'       => $nom,
                    'telephone' => $telephone,
                    'email'     => $mail,
                    'projet'    => $projet,
                    'message'   => $message,
                    'date_envoi'=> current_time('mysql'),
                    'lu'        => 0,
                ],
                ['%s','%s','%s','%s','%s','%s','%d']
            );

            $form_success = true;
        }
    }
}
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

.bd-ct * { box-sizing: border-box; }
.bd-ct img { max-width: 100%; display: block; }
.bd-ct a { text-decoration: none; }

/* ═══════════════════════════════════════════
   HERO
═══════════════════════════════════════════ */
.bd-ct-hero {
  position: relative; height: 380px;
  overflow: hidden; display: flex; align-items: center;
}
.bd-ct-hero-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1800&q=80');
  background-size: cover; background-position: center;
}
.bd-ct-hero-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, rgba(10,8,6,.88) 0%, rgba(10,8,6,.6) 60%, rgba(10,8,6,.2) 100%);
}
.bd-ct-hero-content {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto; padding: 0 40px; width: 100%;
}
.bd-ct-hero-label {
  display: inline-flex; align-items: center; gap: 8px;
  color: var(--or-clair); font-family: var(--ft-accent);
  font-style: italic; font-size: .9rem; margin-bottom: 16px;
}
.bd-ct-hero-label::before, .bd-ct-hero-label::after {
  content: ''; width: 28px; height: 1px; background: var(--or); display: block;
}
.bd-ct-hero-title {
  font-family: var(--ft-display);
  font-size: clamp(2.2rem, 5vw, 3.8rem);
  font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 20px;
}
.bd-ct-hero-title em { font-style: italic; color: var(--or-clair); }
.bd-ct-hero-bread {
  display: flex; align-items: center; gap: 8px;
  font-size: .82rem; color: rgba(255,255,255,.6);
}
.bd-ct-hero-bread a { color: rgba(255,255,255,.6); transition: color .25s; }
.bd-ct-hero-bread a:hover { color: var(--or-clair); }
.bd-ct-hero-bread i { font-size: .65rem; color: var(--or); }

/* ═══════════════════════════════════════════
   UTILITAIRES
═══════════════════════════════════════════ */
.bd-ct-container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }
.bd-ct-label {
  display: inline-flex; align-items: center; gap: 10px;
  font-family: var(--ft-accent); font-size: .9rem; font-style: italic;
  color: var(--rouge); letter-spacing: .05em; margin-bottom: 14px;
}
.bd-ct-label::before, .bd-ct-label::after {
  content: ''; width: 28px; height: 1px; background: var(--rouge); display: block;
}
.bd-ct-title {
  font-family: var(--ft-display);
  font-size: clamp(1.9rem, 3.8vw, 2.8rem);
  font-weight: 700; line-height: 1.15; color: var(--noir); margin-bottom: 16px;
}
.bd-ct-title .bd-rouge { color: var(--rouge); }
.bd-ct-divider {
  width: 50px; height: 3px;
  background: linear-gradient(90deg, var(--rouge), var(--or));
  border-radius: 2px; margin-bottom: 24px;
}

/* ── REVEAL ── */
.bd-ct-reveal {
  opacity: 0; transform: translateY(36px);
  transition: opacity .7s cubic-bezier(.4,0,.2,1), transform .7s cubic-bezier(.4,0,.2,1);
}
.bd-ct-reveal.visible { opacity: 1; transform: translateY(0); }
.bd-ct-d1 { transition-delay: .1s; }
.bd-ct-d2 { transition-delay: .2s; }
.bd-ct-d3 { transition-delay: .3s; }

/* ═══════════════════════════════════════════
   SECTION 1 — INFOS + FORMULAIRE
═══════════════════════════════════════════ */
.bd-ct-main {
  padding: 80px 0 100px;
  background: var(--blanc);
}
.bd-ct-main-grid {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 80px;
  align-items: start;
}

/* ── Colonne infos ── */
.bd-ct-info-subtitle {
  font-size: .95rem; color: var(--gris);
  line-height: 1.8; margin-bottom: 36px;
}
.bd-ct-info-cards {
  display: flex; flex-direction: column; gap: 14px; margin-bottom: 36px;
}
.bd-ct-info-card {
  display: flex; align-items: flex-start; gap: 16px;
  background: var(--creme);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg);
  padding: 18px 20px;
  transition: var(--tr);
}
.bd-ct-info-card:hover {
  border-color: var(--rouge);
  box-shadow: var(--shadow-sm);
  transform: translateX(4px);
}
.bd-ct-info-card-icon {
  width: 44px; height: 44px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--rouge), var(--rouge-fonce));
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .95rem;
}
.bd-ct-info-card-label {
  font-size: .7rem; font-weight: 700;
  color: var(--rouge); text-transform: uppercase;
  letter-spacing: .1em; margin-bottom: 4px;
}
.bd-ct-info-card-val {
  font-size: .88rem; color: var(--gris-fonce); line-height: 1.55;
}
.bd-ct-info-card-val a { color: var(--gris-fonce); transition: color .25s; }
.bd-ct-info-card-val a:hover { color: var(--rouge); }

/* Horaires */
.bd-ct-horaires {
  background: var(--noir-doux);
  border-radius: var(--r-lg);
  padding: 24px;
  margin-bottom: 28px;
}
.bd-ct-horaires h4 {
  font-family: var(--ft-display);
  font-size: 1rem; color: var(--or-clair);
  margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
}
.bd-ct-horaires h4 i { color: var(--or); font-size: .9rem; }
.bd-ct-horaires-list { display: flex; flex-direction: column; gap: 8px; }
.bd-ct-horaires-row {
  display: flex; align-items: center; justify-content: space-between;
  font-size: .85rem; padding-bottom: 8px;
  border-bottom: 1px solid rgba(255,255,255,.06);
}
.bd-ct-horaires-row:last-child { border-bottom: none; padding-bottom: 0; }
.bd-ct-horaires-day { color: rgba(255,255,255,.55); font-weight: 500; }
.bd-ct-horaires-time { color: var(--or-clair); font-weight: 600; }
.bd-ct-horaires-badge {
  background: rgba(45,125,70,.25);
  color: #6fcf97;
  font-size: .65rem; font-weight: 700;
  padding: 2px 8px; border-radius: 20px;
  text-transform: uppercase; letter-spacing: .08em;
}

/* Réseaux sociaux */
.bd-ct-socials { display: flex; gap: 10px; }
.bd-ct-social-btn {
  width: 42px; height: 42px;
  border-radius: var(--r-lg);
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; transition: var(--tr);
  border: 1.5px solid var(--gris-clair);
  color: var(--gris); text-decoration: none;
}
.bd-ct-social-btn:hover { background: var(--rouge); border-color: var(--rouge); color: #fff; transform: translateY(-3px); }
.bd-ct-social-btn.wa:hover { background: #25D366; border-color: #25D366; }

/* ── Formulaire ── */
.bd-ct-form-wrap {
  background: var(--blanc-pur);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg);
  padding: 40px;
  box-shadow: var(--shadow-sm);
}
.bd-ct-form-title {
  font-family: var(--ft-display);
  font-size: 1.5rem; font-weight: 700;
  color: var(--noir); margin-bottom: 6px;
}
.bd-ct-form-sub {
  font-size: .85rem; color: var(--gris); margin-bottom: 28px; line-height: 1.6;
}
.bd-ct-form-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
}
.bd-ct-form-full { grid-column: 1 / -1; }
.bd-ct-form-group { display: flex; flex-direction: column; gap: 6px; }
.bd-ct-form-label {
  font-size: .75rem; font-weight: 600;
  color: var(--gris-fonce); letter-spacing: .06em; text-transform: uppercase;
}
.bd-ct-form-label span { color: var(--rouge); }
.bd-ct-form-input,
.bd-ct-form-select,
.bd-ct-form-textarea {
  width: 100%; padding: 13px 16px;
  background: var(--creme);
  border: 1.5px solid var(--gris-clair);
  border-radius: var(--r);
  font-family: var(--ft-body); font-size: .9rem;
  color: var(--noir); outline: none;
  transition: var(--tr);
  appearance: none; -webkit-appearance: none;
}
.bd-ct-form-input::placeholder,
.bd-ct-form-textarea::placeholder { color: var(--gris); }
.bd-ct-form-input:focus,
.bd-ct-form-select:focus,
.bd-ct-form-textarea:focus {
  border-color: var(--rouge);
  background: var(--blanc-pur);
  box-shadow: 0 0 0 3px rgba(184,40,42,.1);
}
.bd-ct-form-select {
  cursor: pointer;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236B6B6B' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  padding-right: 40px;
}
.bd-ct-form-select option { background: var(--blanc-pur); }
.bd-ct-form-textarea { resize: vertical; min-height: 120px; }

/* Budget radio */
.bd-ct-budget-grid {
  display: grid; grid-template-columns: repeat(3,1fr); gap: 10px;
}
.bd-ct-budget-option { position: relative; }
.bd-ct-budget-option input {
  position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; margin: 0; z-index: 1;
}
.bd-ct-budget-label {
  display: flex; flex-direction: column; align-items: center;
  gap: 4px; padding: 12px 8px;
  border: 1.5px solid var(--gris-clair);
  border-radius: var(--r);
  text-align: center; cursor: pointer;
  transition: var(--tr); background: var(--creme);
}
.bd-ct-budget-option input:checked + .bd-ct-budget-label {
  border-color: var(--rouge);
  background: rgba(184,40,42,.06);
}
.bd-ct-budget-label-title {
  font-size: .78rem; font-weight: 700; color: var(--rouge);
}
.bd-ct-budget-label-sub {
  font-size: .68rem; color: var(--gris);
}

/* Checkbox consentement */
.bd-ct-consent {
  display: flex; align-items: flex-start; gap: 10px;
}
.bd-ct-consent input[type="checkbox"] {
  width: 18px; height: 18px; flex-shrink: 0;
  accent-color: var(--rouge); cursor: pointer; margin-top: 1px;
}
.bd-ct-consent-text {
  font-size: .8rem; color: var(--gris); line-height: 1.55;
}

/* Bouton submit */
.bd-ct-submit {
  display: flex; align-items: center; justify-content: center; gap: 10px;
  width: 100%; padding: 15px;
  background: var(--rouge); color: #fff;
  font-family: var(--ft-body); font-size: .88rem;
  font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  border: none; border-radius: var(--r);
  cursor: pointer; transition: var(--tr);
  box-shadow: var(--shadow-rouge);
  margin-top: 8px;
}
.bd-ct-submit:hover { background: var(--rouge-fonce); transform: translateY(-2px); box-shadow: 0 12px 40px rgba(184,40,42,.4); }
.bd-ct-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

/* Alertes */
.bd-ct-alert {
  padding: 14px 18px; border-radius: var(--r);
  font-size: .88rem; margin-bottom: 20px;
  display: flex; align-items: flex-start; gap: 12px;
}
.bd-ct-alert i { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
.bd-ct-alert-success {
  background: rgba(45,125,70,.1);
  border: 1px solid rgba(45,125,70,.3);
  color: #2D7D46;
}
.bd-ct-alert-error {
  background: rgba(184,40,42,.08);
  border: 1px solid rgba(184,40,42,.25);
  color: var(--rouge-fonce);
}

/* ═══════════════════════════════════════════
   SECTION 2 — CARTE / LOCALISATION
═══════════════════════════════════════════ */
.bd-ct-map-section {
  padding: 0;
  background: var(--creme);
}
.bd-ct-map-inner {
  display: grid;
  grid-template-columns: 1fr 2fr;
}
.bd-ct-map-info {
  background: var(--noir-doux);
  padding: 60px 48px;
  display: flex; flex-direction: column; justify-content: center;
}
.bd-ct-map-info-title {
  font-family: var(--ft-display);
  font-size: 1.6rem; font-weight: 700;
  color: #fff; margin-bottom: 20px; line-height: 1.2;
}
.bd-ct-map-info-title em { font-style: italic; color: var(--or-clair); }
.bd-ct-map-info-list {
  display: flex; flex-direction: column; gap: 18px; margin-bottom: 32px;
}
.bd-ct-map-info-item {
  display: flex; align-items: flex-start; gap: 14px;
  color: rgba(255,255,255,.7); font-size: .88rem; line-height: 1.55;
}
.bd-ct-map-info-item-icon {
  width: 36px; height: 36px; flex-shrink: 0;
  background: rgba(184,40,42,.25);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: var(--rouge-clair); font-size: .85rem;
}
.bd-ct-map-info-item a { color: rgba(255,255,255,.7); transition: color .25s; }
.bd-ct-map-info-item a:hover { color: var(--or-clair); }
.bd-ct-map-wa-btn {
  display: flex; align-items: center; gap: 10px;
  background: #25D366; color: #fff;
  padding: 13px 22px; border-radius: var(--r);
  font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
  text-decoration: none; transition: var(--tr);
  box-shadow: 0 4px 20px rgba(37,211,102,.35);
  width: fit-content;
}
.bd-ct-map-wa-btn:hover { background: #1DA851; transform: translateY(-2px); color: #fff; }

/* Carte Google Maps */
.bd-ct-map-embed {
  min-height: 420px;
  position: relative;
}
.bd-ct-map-embed iframe {
  width: 100%; height: 100%; min-height: 420px;
  display: block; border: none; filter: grayscale(20%);
}

/* ═══════════════════════════════════════════
   SECTION 3 — CANAUX DE CONTACT RAPIDE
═══════════════════════════════════════════ */
.bd-ct-channels {
  padding: 80px 0;
  background: var(--blanc);
}
.bd-ct-channels-head { text-align: center; margin-bottom: 48px; }
.bd-ct-channels-grid {
  display: grid;
  grid-template-columns: repeat(4,1fr);
  gap: 20px;
}
.bd-ct-channel-card {
  display: flex; flex-direction: column; align-items: center;
  text-align: center; padding: 36px 20px;
  background: var(--creme);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg);
  transition: var(--tr);
  text-decoration: none;
}
.bd-ct-channel-card:hover {
  transform: translateY(-6px);
  box-shadow: var(--shadow-lg);
  border-color: transparent;
}
.bd-ct-channel-icon {
  width: 64px; height: 64px;
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; color: #fff;
  margin-bottom: 20px; transition: var(--tr);
}
.bd-ct-channel-card:hover .bd-ct-channel-icon { transform: scale(1.1); }
.bd-ct-channel-title {
  font-family: var(--ft-display);
  font-size: 1.05rem; font-weight: 700;
  color: var(--noir); margin-bottom: 6px;
}
.bd-ct-channel-val {
  font-size: .85rem; color: var(--gris); line-height: 1.55;
}
.bd-ct-channel-action {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 14px; font-size: .78rem; font-weight: 600;
  color: var(--rouge); text-transform: uppercase; letter-spacing: .06em;
}

/* ═══════════════════════════════════════════
   SECTION 4 — FAQ CONTACT
═══════════════════════════════════════════ */
.bd-ct-faq {
  padding: 80px 0;
  background: var(--creme);
}
.bd-ct-faq-head { text-align: center; margin-bottom: 48px; }
.bd-ct-faq-grid {
  display: grid; grid-template-columns: repeat(2,1fr); gap: 16px;
}
.bd-ct-faq-item {
  background: var(--blanc-pur);
  border: 1px solid var(--gris-clair);
  border-radius: var(--r-lg); overflow: hidden; transition: var(--tr);
}
.bd-ct-faq-item.open { border-color: var(--rouge); box-shadow: var(--shadow-sm); }
.bd-ct-faq-q {
  display: flex; align-items: center; justify-content: space-between;
  padding: 18px 22px; cursor: pointer;
  font-weight: 600; font-size: .92rem; color: var(--noir);
  transition: color .25s; user-select: none;
  gap: 12px;
}
.bd-ct-faq-item.open .bd-ct-faq-q { color: var(--rouge); }
.bd-ct-faq-q-icon {
  width: 26px; height: 26px; flex-shrink: 0;
  background: rgba(184,40,42,.08); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--rouge); font-size: .72rem; transition: var(--tr);
}
.bd-ct-faq-item.open .bd-ct-faq-q-icon {
  background: var(--rouge); color: #fff; transform: rotate(180deg);
}
.bd-ct-faq-a {
  max-height: 0; overflow: hidden;
  transition: max-height .4s ease, padding .4s ease;
  padding: 0 22px;
}
.bd-ct-faq-item.open .bd-ct-faq-a { max-height: 200px; padding: 0 22px 18px; }
.bd-ct-faq-a p { font-size: .87rem; color: var(--gris); line-height: 1.75; }

/* ═══════════════════════════════════════════
   SECTION 5 — CTA FINAL
═══════════════════════════════════════════ */
.bd-ct-cta {
  position: relative; padding: 80px 0; overflow: hidden; text-align: center;
}
.bd-ct-cta-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1800&q=80');
  background-size: cover; background-position: center; background-attachment: fixed;
}
.bd-ct-cta-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(139,26,28,.93) 0%, rgba(20,15,12,.88) 60%, rgba(139,26,28,.75) 100%);
}
.bd-ct-cta-content { position: relative; z-index: 2; max-width: 600px; margin: 0 auto; }
.bd-ct-cta-title {
  font-family: var(--ft-display);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 16px;
}
.bd-ct-cta-title em { font-style: italic; color: var(--or-clair); }
.bd-ct-cta-sub {
  color: rgba(255,255,255,.75); font-size: .9rem; line-height: 1.75; margin-bottom: 32px;
}
.bd-ct-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.bd-ct-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 26px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: var(--rouge); color: #fff;
  border: none; cursor: pointer; transition: var(--tr);
  box-shadow: var(--shadow-rouge); text-decoration: none;
}
.bd-ct-btn-primary:hover { background: var(--rouge-fonce); color: #fff; transform: translateY(-2px); }
.bd-ct-btn-wa {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 26px; font-family: var(--ft-body); font-size: .82rem;
  font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  border-radius: var(--r); background: #25D366; color: #fff;
  border: none; cursor: pointer; transition: var(--tr); text-decoration: none;
}
.bd-ct-btn-wa:hover { background: #1DA851; color: #fff; transform: translateY(-2px); }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
  .bd-ct-main-grid { grid-template-columns: 1fr; gap: 48px; }
  .bd-ct-map-inner { grid-template-columns: 1fr; }
  .bd-ct-map-info { padding: 48px 32px; }
  .bd-ct-channels-grid { grid-template-columns: repeat(2,1fr); }
  .bd-ct-faq-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .bd-ct-container { padding: 0 20px; }
  .bd-ct-hero { height: 300px; }
  .bd-ct-hero-content { padding: 0 20px; }
  .bd-ct-form-wrap { padding: 24px 20px; }
  .bd-ct-form-grid { grid-template-columns: 1fr; }
  .bd-ct-form-full { grid-column: 1; }
  .bd-ct-budget-grid { grid-template-columns: repeat(2,1fr); }
  .bd-ct-channels-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 480px) {
  .bd-ct-channels-grid { grid-template-columns: 1fr; }
  .bd-ct-budget-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="bd-ct">

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="bd-ct-hero">
  <div class="bd-ct-hero-bg"></div>
  <div class="bd-ct-hero-overlay"></div>
  <div class="bd-ct-hero-content">
    <div class="bd-ct-hero-label">Nous sommes à votre écoute</div>
    <h1 class="bd-ct-hero-title">
      <em>Contactez</em><br>BAOBO DECO
    </h1>
    <div class="bd-ct-hero-bread">
      <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
      <i class="fas fa-chevron-right"></i>
      <span style="color:var(--or-clair);">Contact</span>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 1 — INFOS + FORMULAIRE
══════════════════════════════════════════ -->
<section class="bd-ct-main">
  <div class="bd-ct-container">
    <div class="bd-ct-main-grid">

      <!-- ── Colonne gauche : infos ── -->
      <div class="bd-ct-reveal">
        <p class="bd-ct-label">Nos coordonnées</p>
        <h2 class="bd-ct-title">
          Parlons de votre <span class="bd-rouge">projet</span>
        </h2>
        <div class="bd-ct-divider"></div>
        <p class="bd-ct-info-subtitle">
          Notre équipe est disponible du lundi au samedi pour répondre à toutes
          vos questions et vous accompagner dans votre projet de décoration.
        </p>

        <div class="bd-ct-info-cards">
          <!-- Téléphones -->
          <div class="bd-ct-info-card">
            <div class="bd-ct-info-card-icon"><i class="fas fa-phone-alt"></i></div>
            <div>
              <div class="bd-ct-info-card-label">Téléphone</div>
              <div class="bd-ct-info-card-val">
                <a href="tel:<?php echo esc_attr($tel1_clean); ?>"><?php echo esc_html($tel1); ?></a>
                <?php if ($tel2) : ?>
                <br><a href="tel:<?php echo esc_attr($tel2_clean); ?>"><?php echo esc_html($tel2); ?></a>
                <?php endif; ?>
                <?php if ($tel3) : ?>
                <br><a href="tel:<?php echo esc_attr($tel3_clean); ?>"><?php echo esc_html($tel3); ?></a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <!-- WhatsApp -->
          <div class="bd-ct-info-card">
            <div class="bd-ct-info-card-icon" style="background:linear-gradient(135deg,#25D366,#1DA851);">
              <i class="fab fa-whatsapp"></i>
            </div>
            <div>
              <div class="bd-ct-info-card-label">WhatsApp</div>
              <div class="bd-ct-info-card-val">
                <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">
                  Discuter sur WhatsApp →
                </a>
              </div>
            </div>
          </div>
          <!-- Email -->
          <div class="bd-ct-info-card">
            <div class="bd-ct-info-card-icon"><i class="fas fa-envelope"></i></div>
            <div>
              <div class="bd-ct-info-card-label">Email</div>
              <div class="bd-ct-info-card-val">
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
              </div>
            </div>
          </div>
          <!-- Adresse -->
          <div class="bd-ct-info-card">
            <div class="bd-ct-info-card-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <div class="bd-ct-info-card-label">Showroom</div>
              <div class="bd-ct-info-card-val"><?php echo esc_html($adresse); ?></div>
            </div>
          </div>
        </div>

        <!-- Horaires -->
        <div class="bd-ct-horaires">
          <h4><i class="fas fa-clock"></i> Nos Horaires d'ouverture</h4>
          <div class="bd-ct-horaires-list">
            <div class="bd-ct-horaires-row">
              <span class="bd-ct-horaires-day">Lundi – Vendredi</span>
              <span class="bd-ct-horaires-time">8h00 – 18h00 <span class="bd-ct-horaires-badge">Ouvert</span></span>
            </div>
            <div class="bd-ct-horaires-row">
              <span class="bd-ct-horaires-day">Samedi</span>
              <span class="bd-ct-horaires-time">8h00 – 18h00 <span class="bd-ct-horaires-badge">Ouvert</span></span>
            </div>
            <div class="bd-ct-horaires-row">
              <span class="bd-ct-horaires-day">Dimanche</span>
              <span class="bd-ct-horaires-time" style="color:rgba(255,255,255,.4);">9h00 – 13h00</span>
            </div>
          </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="bd-ct-socials">
          <?php if ($facebook) : ?>
          <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener"
             class="bd-ct-social-btn" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <?php endif; ?>
          <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener"
             class="bd-ct-social-btn wa" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
          </a>
          <?php if ($instagram) : ?>
          <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener"
             class="bd-ct-social-btn" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <?php endif; ?>
          <?php if ($tiktok) : ?>
          <a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener"
             class="bd-ct-social-btn" aria-label="TikTok">
            <i class="fab fa-tiktok"></i>
          </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- ── Colonne droite : formulaire ── -->
      <div class="bd-ct-reveal bd-ct-d2">
        <div class="bd-ct-form-wrap">
          <h3 class="bd-ct-form-title">Envoyez-nous un message</h3>
          <p class="bd-ct-form-sub">
            Remplissez ce formulaire et nous vous répondons sous <strong>24h</strong>.
            Tous les devis sont gratuits et sans engagement.
          </p>

          <?php if ($form_success) : ?>
          <div class="bd-ct-alert bd-ct-alert-success">
            <i class="fas fa-check-circle"></i>
            <div>
              <strong>Message envoyé avec succès !</strong><br>
              Merci <?php echo esc_html($_POST['nom'] ?? ''); ?>, nous vous répondons sous 24h.
            </div>
          </div>
          <?php endif; ?>

          <?php if (!empty($form_errors)) : ?>
          <div class="bd-ct-alert bd-ct-alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
              <?php foreach ($form_errors as $err) echo '<div>' . esc_html($err) . '</div>'; ?>
            </div>
          </div>
          <?php endif; ?>

          <form method="POST" action="" id="bdCtForm" novalidate>
            <?php wp_nonce_field('bd_contact_form', 'bd_ct_nonce'); ?>

            <div class="bd-ct-form-grid">

              <div class="bd-ct-form-group">
                <label class="bd-ct-form-label" for="ct_nom">
                  Nom complet <span>*</span>
                </label>
                <input type="text" id="ct_nom" name="nom" class="bd-ct-form-input"
                       placeholder="Votre nom complet"
                       value="<?php echo esc_attr($_POST['nom'] ?? ''); ?>" required>
              </div>

              <div class="bd-ct-form-group">
                <label class="bd-ct-form-label" for="ct_tel">
                  Téléphone <span>*</span>
                </label>
                <input type="tel" id="ct_tel" name="telephone" class="bd-ct-form-input"
                       placeholder="+226 00 00 00 00"
                       value="<?php echo esc_attr($_POST['telephone'] ?? ''); ?>" required>
              </div>

              <div class="bd-ct-form-group">
                <label class="bd-ct-form-label" for="ct_email">Email</label>
                <input type="email" id="ct_email" name="email" class="bd-ct-form-input"
                       placeholder="votre@email.com"
                       value="<?php echo esc_attr($_POST['email'] ?? ''); ?>">
              </div>

              <div class="bd-ct-form-group">
                <label class="bd-ct-form-label" for="ct_projet">Type de projet</label>
                <select id="ct_projet" name="projet" class="bd-ct-form-select">
                  <option value="">Choisir...</option>
                  <?php
                  $projets = ['Décoration salon','Chambre à coucher','Bureau / Open space',
                              'Restaurant / Maquis','Hôtel / Résidence','Aménagement complet','Autre'];
                  foreach ($projets as $p) :
                    $sel = (($_POST['projet'] ?? '') === $p) ? 'selected' : '';
                  ?>
                  <option value="<?php echo esc_attr($p); ?>" <?php echo $sel; ?>>
                    <?php echo esc_html($p); ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Budget -->
              <div class="bd-ct-form-group bd-ct-form-full">
                <label class="bd-ct-form-label">Budget approximatif</label>
                <div class="bd-ct-budget-grid">
                  <?php
                  $budgets = [
                    ['val'=>'< 100k',   'label'=>'Moins de','sub'=>'100 000 FCFA'],
                    ['val'=>'100-500k', 'label'=>'100k –',  'sub'=>'500 000 FCFA'],
                    ['val'=>'500k-1M',  'label'=>'500k –',  'sub'=>'1 000 000 FCFA'],
                    ['val'=>'1M-3M',    'label'=>'1M –',    'sub'=>'3 000 000 FCFA'],
                    ['val'=>'3M-5M',    'label'=>'3M –',    'sub'=>'5 000 000 FCFA'],
                    ['val'=>'> 5M',     'label'=>'Plus de', 'sub'=>'5 000 000 FCFA'],
                  ];
                  foreach ($budgets as $b) :
                    $checked = (($_POST['budget'] ?? '') === $b['val']) ? 'checked' : '';
                  ?>
                  <label class="bd-ct-budget-option">
                    <input type="radio" name="budget" value="<?php echo esc_attr($b['val']); ?>" <?php echo $checked; ?>>
                    <span class="bd-ct-budget-label">
                      <span class="bd-ct-budget-label-title"><?php echo esc_html($b['label']); ?></span>
                      <span class="bd-ct-budget-label-sub"><?php echo esc_html($b['sub']); ?></span>
                    </span>
                  </label>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="bd-ct-form-group bd-ct-form-full">
                <label class="bd-ct-form-label" for="ct_message">
                  Décrivez votre projet <span>*</span>
                </label>
                <textarea id="ct_message" name="message" class="bd-ct-form-textarea"
                          placeholder="Décrivez votre projet, vos besoins, les pièces concernées, vos préférences de style..."
                          required><?php echo esc_textarea($_POST['message'] ?? ''); ?></textarea>
              </div>

              <div class="bd-ct-form-group bd-ct-form-full">
                <label class="bd-ct-consent">
                  <input type="checkbox" name="consentement" required
                         <?php echo !empty($_POST['consentement']) ? 'checked' : ''; ?>>
                  <span class="bd-ct-consent-text">
                    J'accepte que mes données soient utilisées pour traiter ma demande de contact.
                    Elles ne seront jamais partagées à des tiers.
                  </span>
                </label>
              </div>

            </div><!-- .bd-ct-form-grid -->

            <button type="submit" class="bd-ct-submit" id="bdCtSubmit">
              <i class="fas fa-paper-plane"></i>
              Envoyer le message
            </button>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 2 — CARTE
══════════════════════════════════════════ -->
<section class="bd-ct-map-section">
  <div class="bd-ct-map-inner">

    <div class="bd-ct-map-info bd-ct-reveal">
      <h2 class="bd-ct-map-info-title">
        Venez nous <em>rendre visite</em>
      </h2>
      <div class="bd-ct-map-info-list">
        <div class="bd-ct-map-info-item">
          <div class="bd-ct-map-info-item-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <strong style="color:#fff;display:block;margin-bottom:2px;">Notre showroom</strong>
            <?php echo esc_html($adresse); ?>
          </div>
        </div>
        <div class="bd-ct-map-info-item">
          <div class="bd-ct-map-info-item-icon"><i class="fas fa-car"></i></div>
          <div>
            <strong style="color:#fff;display:block;margin-bottom:2px;">Accès facile</strong>
            Parking disponible sur place. Facile d'accès depuis le centre-ville.
          </div>
        </div>
        <div class="bd-ct-map-info-item">
          <div class="bd-ct-map-info-item-icon"><i class="fas fa-phone-alt"></i></div>
          <div>
            <strong style="color:#fff;display:block;margin-bottom:2px;">Prendre rendez-vous</strong>
            <a href="tel:<?php echo esc_attr($tel1_clean); ?>"><?php echo esc_html($tel1); ?></a>
          </div>
        </div>
      </div>
      <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-ct-map-wa-btn">
        <i class="fab fa-whatsapp"></i> Prendre RDV sur WhatsApp
      </a>
    </div>

    <div class="bd-ct-map-embed">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3897.042!2d-1.5152!3d12.3784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDIyJzQyLjMiTiAxwrAzMCc1NC43Ilc!5e0!3m2!1sfr!2sbf!4v1234567890"
        allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="BAOBO DECO — Tampouy, Ouagadougou">
      </iframe>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 3 — CANAUX DE CONTACT RAPIDE
══════════════════════════════════════════ -->
<section class="bd-ct-channels">
  <div class="bd-ct-container">
    <div class="bd-ct-channels-head bd-ct-reveal">
      <p class="bd-ct-label" style="justify-content:center;">Contactez-nous directement</p>
      <h2 class="bd-ct-title" style="text-align:center;">
        Choisissez votre <span class="bd-rouge">canal préféré</span>
      </h2>
      <div class="bd-ct-divider" style="margin:0 auto 0;"></div>
    </div>

    <div class="bd-ct-channels-grid">
      <?php
      $channels = [
        [
          'href'  => 'tel:' . $tel1_clean,
          'icon'  => 'fas fa-phone-alt',
          'color' => 'linear-gradient(135deg,var(--rouge),var(--rouge-fonce))',
          'titre' => 'Téléphone',
          'val'   => $tel1,
          'action'=> 'Appeler maintenant',
        ],
        [
          'href'  => $wa_url,
          'icon'  => 'fab fa-whatsapp',
          'color' => 'linear-gradient(135deg,#25D366,#1DA851)',
          'titre' => 'WhatsApp',
          'val'   => 'Réponse rapide garantie',
          'action'=> 'Écrire sur WhatsApp',
          'target'=> '_blank',
        ],
        [
          'href'  => 'mailto:' . $email,
          'icon'  => 'fas fa-envelope',
          'color' => 'linear-gradient(135deg,var(--or),#B8892A)',
          'titre' => 'Email',
          'val'   => $email,
          'action'=> 'Envoyer un email',
        ],
        [
          'href'  => $facebook ?: '#',
          'icon'  => 'fab fa-facebook-f',
          'color' => 'linear-gradient(135deg,#1877F2,#0C5DC7)',
          'titre' => 'Facebook',
          'val'   => 'BAOBO déco par les entreprises MBM',
          'action'=> 'Visiter la page',
          'target'=> '_blank',
        ],
      ];
      foreach ($channels as $i => $ch) :
      ?>
      <a href="<?php echo esc_url($ch['href']); ?>"
         <?php echo !empty($ch['target']) ? 'target="' . esc_attr($ch['target']) . '" rel="noopener"' : ''; ?>
         class="bd-ct-channel-card bd-ct-reveal bd-ct-d<?php echo $i+1; ?>">
        <div class="bd-ct-channel-icon" style="background:<?php echo $ch['color']; ?>;">
          <i class="<?php echo esc_attr($ch['icon']); ?>"></i>
        </div>
        <div class="bd-ct-channel-title"><?php echo esc_html($ch['titre']); ?></div>
        <div class="bd-ct-channel-val"><?php echo esc_html($ch['val']); ?></div>
        <span class="bd-ct-channel-action">
          <?php echo esc_html($ch['action']); ?> <i class="fas fa-arrow-right"></i>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 4 — FAQ
══════════════════════════════════════════ -->
<section class="bd-ct-faq">
  <div class="bd-ct-container">
    <div class="bd-ct-faq-head bd-ct-reveal">
      <p class="bd-ct-label" style="justify-content:center;">Questions fréquentes</p>
      <h2 class="bd-ct-title" style="text-align:center;">
        Vous avez des <span class="bd-rouge">questions ?</span>
      </h2>
      <div class="bd-ct-divider" style="margin:0 auto;"></div>
    </div>

    <div class="bd-ct-faq-grid">
      <?php
      $faqs = [
        ['q'=>'Combien coûte une consultation ?',
         'r'=>'La première consultation est entièrement gratuite. Nos experts se déplacent chez vous ou vous accueillent dans notre showroom à Tampouy sans aucun frais.'],
        ['q'=>'Quel est le délai de réponse à un devis ?',
         'r'=>'Nous nous engageons à répondre à toutes les demandes de devis sous 24h ouvrables. Pour les projets complexes, un délai de 48h peut être nécessaire.'],
        ['q'=>'Livrez-vous en dehors de Ouagadougou ?',
         'r'=>'Nous intervenons principalement à Ouagadougou et ses environs. Pour les projets en province, contactez-nous pour discuter des modalités et frais de déplacement.'],
        ['q'=>'Comment se passe le paiement ?',
         'r'=>'Nous acceptons les paiements en espèces, par virement ou mobile money. Pour les grands projets, un acompte de 30% est demandé à la commande, le solde à la livraison.'],
        ['q'=>'Puis-je visiter votre showroom ?',
         'r'=>'Bien sûr ! Notre showroom à Tampouy est ouvert du lundi au samedi de 8h à 18h et le dimanche de 9h à 13h. Venez découvrir nos produits et rencontrer notre équipe.'],
        ['q'=>'Proposez-vous des garanties ?',
         'r'=>'Oui, tous nos meubles sont garantis 2 ans. La pose et l\'installation sont garanties 1 an. En cas de problème, notre service après-vente intervient rapidement.'],
      ];
      foreach ($faqs as $i => $faq) :
      ?>
      <div class="bd-ct-faq-item<?php echo $i === 0 ? ' open' : ''; ?> bd-ct-reveal">
        <div class="bd-ct-faq-q" onclick="bdCtFaq(this.parentElement)">
          <?php echo esc_html($faq['q']); ?>
          <span class="bd-ct-faq-q-icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="bd-ct-faq-a">
          <p><?php echo esc_html($faq['r']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 5 — CTA FINAL
══════════════════════════════════════════ -->
<section class="bd-ct-cta">
  <div class="bd-ct-cta-bg"></div>
  <div class="bd-ct-cta-overlay"></div>
  <div class="bd-ct-container">
    <div class="bd-ct-cta-content bd-ct-reveal">
      <h2 class="bd-ct-cta-title">
        Votre projet commence<br><em>par un simple message</em>
      </h2>
      <p class="bd-ct-cta-sub">
        Devis gratuit · Réponse sous 24h · Sans engagement
      </p>
      <div class="bd-ct-cta-btns">
        <a href="<?php echo esc_url(home_url('/devis')); ?>" class="bd-ct-btn-primary">
          <i class="fas fa-file-invoice"></i> Demander un Devis
        </a>
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="bd-ct-btn-wa">
          <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- .bd-ct -->

<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
(function() {
'use strict';

/* ── SCROLL REVEAL ── */
(function() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.bd-ct-reveal').forEach(el => el.classList.add('visible'));
    return;
  }
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.bd-ct-reveal').forEach(el => obs.observe(el));
})();

/* ── FAQ ── */
window.bdCtFaq = function(item) {
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.bd-ct-faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
};

/* ── FORMULAIRE — validation + loading ── */
(function() {
  const form   = document.getElementById('bdCtForm');
  const submit = document.getElementById('bdCtSubmit');
  if (!form || !submit) return;

  form.addEventListener('submit', function(e) {
    /* Validation côté client */
    const nom = document.getElementById('ct_nom');
    const tel = document.getElementById('ct_tel');
    const msg = document.getElementById('ct_message');
    let valid  = true;

    [nom, tel, msg].forEach(field => {
      if (!field) return;
      if (!field.value.trim()) {
        field.style.borderColor = 'var(--rouge)';
        field.style.boxShadow   = '0 0 0 3px rgba(184,40,42,.15)';
        valid = false;
      } else {
        field.style.borderColor = '';
        field.style.boxShadow   = '';
      }
    });

    if (!valid) {
      e.preventDefault();
      nom && nom.focus();
      return;
    }

    /* Loading state */
    submit.disabled     = true;
    submit.innerHTML    = '<i class="fas fa-circle-notch fa-spin"></i> Envoi en cours...';
  });

  /* Reset style au focus */
  ['ct_nom','ct_tel','ct_message'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', () => {
      el.style.borderColor = '';
      el.style.boxShadow   = '';
    });
  });
})();

/* ── SCROLL vers le formulaire si succès ── */
<?php if ($form_success) : ?>
document.addEventListener('DOMContentLoaded', () => {
  const wrap = document.querySelector('.bd-ct-form-wrap');
  if (wrap) wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
<?php endif; ?>

})();
</script>

<?php get_footer(); ?>