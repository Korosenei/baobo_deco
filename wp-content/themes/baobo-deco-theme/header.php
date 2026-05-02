<?php
/**
 * header.php — BAOBO DECO Child Theme
 * Topbar + Header sticky + Mobile menu
 */

function bd_setting( $key, $default = '' ) {
    global $wpdb;
    $row = $wpdb->get_row( $wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$promo_actif  = bd_setting( 'promo_actif', '1' );
$promo_texte  = bd_setting( 'promo_texte', 'Livraison gratuite à Ouagadougou pour toute commande supérieure à 50 000 FCFA' );
$wa_num       = bd_setting( 'whatsapp_num', '22607592997' );
$wa_msg       = bd_setting( 'whatsapp_msg', 'Bonjour BAOBO DECO, je souhaite des informations sur vos produits et services.' );
$telephone1   = bd_setting( 'telephone1', '+226 07 59 29 97' );
$wa_url       = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode( $wa_msg );

$promo_items = [
    $promo_texte,
    '✦ Conseil déco personnalisé offert avec toute commande',
    '✦ Installation et pose incluses dans tout Ouagadougou',
    '✦ Paiement à la livraison disponible',
    '✦ Showroom ouvert Lun–Sam de 8h à 18h — Tampouy',
];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT AWESOME — Chargé en priorité absolue -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Jost:wght@300;400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap"
          rel="stylesheet">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ╔══════════════════════════════════════
     ║ TOPBAR
     ╚══════════════════════════════════════ -->
<div class="bd-topbar" id="bdTopbar">
    <div class="bd-topbar-inner">
        <div class="bd-topbar-marquee">
            ✦ Décoration Intérieure &middot; Vente de Meubles &middot; Aménagement d'Espaces &middot; Conseil Personnalisé &middot; Livraison &amp; Installation ✦
        </div>
        <div class="bd-topbar-right">
            <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $telephone1) ); ?>">
                <i class="fas fa-phone-alt"></i>
                <?php echo esc_html( $telephone1 ); ?>
            </a>
            <a href="#">
                <i class="fas fa-clock"></i>
                Lun–Sam, 8h–18h
            </a>
        </div>
    </div>
</div>

<!-- ╔══════════════════════════════════════
     ║ HEADER PRINCIPAL
     ╚══════════════════════════════════════ -->
<header class="bd-header" id="bdHeader" role="banner">
    <div class="bd-header-inner">

        <!-- LOGO -->
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="bd-logo" aria-label="<?php bloginfo('name'); ?> — Accueil">
            <?php
            $logo_url = get_stylesheet_directory_uri() . '/images/logo.png';
            if ( has_custom_logo() ) {
                $logo_id  = get_theme_mod('custom_logo');
                $logo_img = wp_get_attachment_image_src( $logo_id, 'full' );
                if ( $logo_img ) $logo_url = $logo_img[0];
            }
            ?>
            <img src="<?php echo esc_url( $logo_url ); ?>"
                 alt="<?php bloginfo('name'); ?>"
                 class="bd-logo-img"
                 width="180" height="58"
                 loading="eager">
        </a>

        <!-- NAV DESKTOP -->
        <nav class="bd-nav" role="navigation" aria-label="Navigation principale">

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/') ); ?>"
                   class="bd-nav-link <?php echo is_front_page() ? 'active' : ''; ?>">Accueil</a>
            </div>

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/a-propos') ); ?>"
                   class="bd-nav-link <?php echo is_page('a-propos') ? 'active' : ''; ?>">À Propos</a>
            </div>

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/services') ); ?>"
                   class="bd-nav-link <?php echo is_page('services') ? 'active' : ''; ?>">
                    Services <i class="fas fa-chevron-down bd-chevron" aria-hidden="true"></i>
                </a>
                <div class="bd-dropdown" role="menu">
                    <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-paint-brush"></i> Décoration Intérieure
                    </a>
                    <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-couch"></i> Vente de Meubles
                    </a>
                    <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-drafting-compass"></i> Aménagement d'Espaces
                    </a>
                    <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-lightbulb"></i> Conseil Personnalisé
                    </a>
                    <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-window-maximize"></i> Pose Rideaux &amp; Stores
                    </a>
                    <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-truck"></i> Livraison &amp; Installation
                    </a>
                </div>
            </div>

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/boutique') ); ?>"
                   class="bd-nav-link <?php echo ( function_exists('is_shop') && is_shop() ) ? 'active' : ''; ?>">
                    Boutique <i class="fas fa-chevron-down bd-chevron" aria-hidden="true"></i>
                </a>
                <div class="bd-dropdown" role="menu">
                    <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-couch"></i> Meubles de Salon
                    </a>
                    <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-bed"></i> Chambres à Coucher
                    </a>
                    <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-image"></i> Décoration Murale
                    </a>
                    <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-lightbulb"></i> Luminaires
                    </a>
                    <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-layer-group"></i> Tapis &amp; Moquettes
                    </a>
                    <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-dropdown-link" role="menuitem">
                        <i class="fas fa-window-maximize"></i> Rideaux &amp; Voilages
                    </a>
                </div>
            </div>

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/galerie') ); ?>"
                   class="bd-nav-link <?php echo is_page('galerie') ? 'active' : ''; ?>">Galerie</a>
            </div>

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/blog') ); ?>"
                   class="bd-nav-link <?php echo ( is_home() || is_single() ) ? 'active' : ''; ?>">Blog</a>
            </div>

            <div class="bd-nav-item">
                <a href="<?php echo esc_url( home_url('/contact') ); ?>"
                   class="bd-nav-link <?php echo is_page('contact') ? 'active' : ''; ?>">Contact</a>
            </div>

        </nav>

        <!-- ACTIONS -->
        <div class="bd-header-actions">

            <button class="bd-icon-btn" id="bdSearchToggle" aria-label="Rechercher">
                <i class="fas fa-search"></i>
            </button>

            <a href="<?php echo esc_url( home_url('/liste-de-souhaits') ); ?>"
               class="bd-icon-btn" aria-label="Mes favoris">
                <i class="far fa-heart"></i>
            </a>

            <?php if ( function_exists('WC') ) : ?>
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
               class="bd-icon-btn" aria-label="Mon panier" style="position:relative;">
                <i class="fas fa-shopping-bag"></i>
                <?php $cnt = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                <span class="bd-badge" id="bdCartCount"
                      <?php echo $cnt === 0 ? 'style="display:none"' : ''; ?>>
                    <?php echo esc_html($cnt); ?>
                </span>
            </a>
            <?php else : ?>
            <a href="<?php echo esc_url( home_url('/boutique') ); ?>"
               class="bd-icon-btn" aria-label="Boutique">
                <i class="fas fa-shopping-bag"></i>
            </a>
            <?php endif; ?>

            <a href="<?php echo esc_url( home_url('/devis') ); ?>" class="bd-btn-devis">
                <i class="fas fa-file-alt"></i> Devis Gratuit
            </a>

            <button class="bd-hamburger" id="bdHamburger" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

        </div>
    </div>

    <!-- BARRE RECHERCHE -->
    <div class="bd-search-bar" id="bdSearchBar" aria-hidden="true" role="search">
        <div class="bd-search-bar-inner">
            <form method="get" action="<?php echo esc_url( home_url('/') ); ?>" class="bd-search-form">
                <?php if ( function_exists('WC') ) : ?>
                <input type="hidden" name="post_type" value="product">
                <?php endif; ?>
                <i class="fas fa-search"></i>
                <input type="search" name="s" class="bd-search-input"
                       placeholder="Rechercher meubles, déco, services…"
                       autocomplete="off" id="bdSearchInput" aria-label="Recherche">
                <button type="button" class="bd-search-close" id="bdSearchClose" aria-label="Fermer">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>
    </div>

</header>

<!-- MENU MOBILE -->
<div class="bd-mobile-menu" id="bdMobileMenu" aria-hidden="true">
    <div class="bd-mobile-overlay" id="bdMobileOverlay"></div>
    <div class="bd-mobile-panel">
        <div class="bd-mobile-head">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="bd-logo">
                <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/logo.png' ); ?>"
                     alt="BAOBO DECO" class="bd-logo-img" style="height:46px;">
            </a>
            <button class="bd-mobile-close" id="bdMobileClose" aria-label="Fermer le menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="bd-mobile-nav">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-home"></i> Accueil</a>
            <a href="<?php echo esc_url( home_url('/a-propos') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-info-circle"></i> À Propos</a>
            <a href="<?php echo esc_url( home_url('/services') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-concierge-bell"></i> Services</a>
            <div class="bd-mobile-divider"></div>
            <a href="<?php echo esc_url( home_url('/boutique') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-store"></i> Boutique</a>
            <a href="<?php echo esc_url( home_url('/galerie') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-images"></i> Galerie</a>
            <a href="<?php echo esc_url( home_url('/blog') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-blog"></i> Blog</a>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="bd-mobile-nav-link"><i class="fas fa-envelope"></i> Contact</a>
        </nav>
        <div class="bd-mobile-footer">
            <a href="<?php echo esc_url( home_url('/devis') ); ?>" class="bd-btn-devis" style="width:100%;justify-content:center;display:flex;">
                <i class="fas fa-file-alt"></i> Demander un Devis Gratuit
            </a>
            <div class="bd-mobile-contact" style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">
                <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $telephone1) ); ?>"
                   style="display:flex;align-items:center;gap:10px;font-size:.82rem;color:var(--gris);text-decoration:none;">
                    <i class="fas fa-phone-alt" style="color:var(--rouge);width:14px;"></i>
                    <?php echo esc_html( $telephone1 ); ?>
                </a>
                <a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener"
                   style="display:flex;align-items:center;gap:10px;font-size:.82rem;color:var(--gris);text-decoration:none;">
                    <i class="fab fa-whatsapp" style="color:var(--rouge);width:14px;"></i>
                    WhatsApp disponible
                </a>
            </div>
        </div>
    </div>
</div>

<!-- STYLES BARRE RECHERCHE -->
<style>
.bd-search-bar {
    position: absolute; top: 100%; left: 0; right: 0;
    background: var(--blanc-pur);
    border-top: 2px solid var(--rouge);
    box-shadow: 0 12px 40px rgba(0,0,0,.1);
    max-height: 0; overflow: hidden;
    transition: max-height .35s ease, padding .35s ease;
    z-index: 99;
}
.bd-search-bar.open { max-height: 80px; padding: 16px 0; }
.bd-search-bar-inner { max-width: var(--container); margin: 0 auto; padding: 0 40px; }
.bd-search-form {
    display: flex; align-items: center; gap: 14px;
    border: 1.5px solid var(--gris-clair); border-radius: var(--r);
    padding: 10px 16px; background: var(--blanc);
}
.bd-search-form > i { color: var(--gris); font-size: .9rem; flex-shrink: 0; }
.bd-search-input {
    flex: 1; border: none; background: transparent;
    font-family: var(--ft-body); font-size: .92rem; color: var(--noir); outline: none;
}
.bd-search-input::placeholder { color: var(--gris); }
.bd-search-close {
    background: none; border: none; color: var(--gris);
    font-size: .9rem; cursor: pointer; transition: color .2s; padding: 0; flex-shrink: 0;
}
.bd-search-close:hover { color: var(--rouge); }
</style>

<div id="page" class="site">
<main id="content" class="site-content" role="main">