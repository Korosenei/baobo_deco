<?php
/**
 * functions.php — BAOBO DECO Child Theme
 * Chargement des assets, configuration WooCommerce, helpers
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ══════════════════════════════════════════════════════════
   1. ASSETS — Styles & Scripts
══════════════════════════════════════════════════════════ */
function baobo_child_enqueue_assets() {

    /* ─ CSS parent Astra (obligatoire pour le child theme) ─ */
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'astra' )->get( 'Version' )
    );

    /* ─ Google Fonts : Playfair Display + Jost + Cormorant Garamond ─ */
    wp_enqueue_style(
        'baobo-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Jost:wght@300;400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap',
        [],
        null
    );

    /* ─ Font Awesome 6 ─ */
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    /* ─ CSS enfant (style.css) ─ */
    wp_enqueue_style(
        'baobo-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [ 'astra-parent-style', 'baobo-fonts', 'font-awesome' ],
        wp_get_theme()->get( 'Version' )
    );

    /* ─ JS principal BAOBO DECO ─ */
    wp_enqueue_script(
        'baobo-main',
        get_stylesheet_directory_uri() . '/js/baobo-main.js',
        [],           // Pas de dépendance jQuery (vanilla JS)
        '2.0.0',
        true          // Dans le <footer>
    );

    /* ─ Variables PHP → JS ─ */
    wp_localize_script( 'baobo-main', 'baoboDeco', [
        'homeUrl'   => home_url('/'),
        'ajaxurl'   => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('baobo_nonce'),
        'cartUrl'   => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/boutique'),
        'isWC'      => function_exists('WC') ? 'yes' : 'no',
    ]);
}
add_action( 'wp_enqueue_scripts', 'baobo_child_enqueue_assets', 20 );

/* ══════════════════════════════════════════════════════════
   2. SUPPORT DU THÈME
══════════════════════════════════════════════════════════ */
add_action( 'after_setup_theme', function() {

    /* Logo personnalisé via Personnaliser */
    add_theme_support( 'custom-logo', [
        'height'      => 120,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ]);

    /* WooCommerce */
    add_theme_support( 'woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width'    => 900,
    ]);
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    /* Tailles d'images personnalisées */
    add_image_size( 'baobo-hero',    1920, 900,  true );
    add_image_size( 'baobo-produit',  600, 600,  true );
    add_image_size( 'baobo-galerie',  800, 600,  true );
    add_image_size( 'baobo-blog',     600, 400,  true );

}, 11 );

/* ══════════════════════════════════════════════════════════
   3. MASQUER LE HEADER ET FOOTER ASTRA
══════════════════════════════════════════════════════════ */

/* Supprimer le header Astra — on utilise le nôtre dans header.php */
add_filter( 'astra_header_html_before', '__return_empty_string', 99 );

/* Supprimer le footer Astra */
add_filter( 'astra_footer_html_before', '__return_empty_string', 99 );
add_filter( 'astra_footer_copyright_text', '__return_empty_string', 99 );

/* Désactiver les actions Astra pour le header */
add_action( 'init', function() {
    remove_action( 'astra_header', 'astra_header_markup' );
    remove_action( 'astra_footer', 'astra_footer_markup' );
}, 99 );

/* Option Astra : désactiver header/footer via filtres */
add_filter( 'astra_main_header_display',         '__return_false', 99 );
add_filter( 'astra_footer_display',              '__return_false', 99 );
add_filter( 'astra_primary_header_display',      '__return_false', 99 );
add_filter( 'astra_above_header_display',        '__return_false', 99 );
add_filter( 'astra_below_header_display',        '__return_false', 99 );
add_filter( 'astra_mobile_header_display',       '__return_false', 99 );

/* ══════════════════════════════════════════════════════════
   4. WOOCOMMERCE — Devise FCFA & Formatage
══════════════════════════════════════════════════════════ */
add_filter( 'woocommerce_currency', fn() => 'XOF' );
add_filter( 'woocommerce_currency_symbol', function( $symbol, $currency ) {
    return $currency === 'XOF' ? 'FCFA' : $symbol;
}, 10, 2 );
add_filter( 'woocommerce_price_format',       fn() => '%2$s %1$s' );
add_filter( 'woocommerce_price_decimal_sep',  fn() => ',' );
add_filter( 'woocommerce_price_thousand_sep', fn() => ' ' );
add_filter( 'woocommerce_price_num_decimals', fn() => 0 );
add_filter( 'loop_shop_per_page',             fn() => 12, 20 );
add_filter( 'loop_shop_columns',              fn() => 3 );

/* Textes bouton panier */
add_filter( 'woocommerce_product_add_to_cart_text', fn() => 'Ajouter au panier' );
add_filter( 'woocommerce_product_single_add_to_cart_text', fn() => 'Ajouter au panier' );

/* Mise à jour du badge panier via AJAX */
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    $count = WC()->cart->get_cart_contents_count();
    $fragments['span.bd-badge#bdCartCount'] = '<span class="bd-badge" id="bdCartCount"'
        . ( $count === 0 ? ' style="display:none"' : '' ) . '>'
        . esc_html( $count )
        . '</span>';
    return $fragments;
});

/* ══════════════════════════════════════════════════════════
   5. MENUS WORDPRESS
══════════════════════════════════════════════════════════ */
add_action( 'init', function() {
    register_nav_menus([
        'menu-principal' => 'Menu Principal (Header)',
        'menu-footer-1'  => 'Footer — Services',
        'menu-footer-2'  => 'Footer — Liens Utiles',
    ]);
});

/* ══════════════════════════════════════════════════════════
   6. PERFORMANCE & SÉCURITÉ
══════════════════════════════════════════════════════════ */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

add_action( 'init', function() {
    remove_action( 'wp_head',    'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
});


/* ══════════════════════════════════════════════════════════
   7. TEMPLATE HIERARCHY — Toutes les pages custom
══════════════════════════════════════════════════════════ */
add_filter( 'template_include', function( $template ) {

    if ( is_admin() ) return $template;

    // Mapping : slug de page → fichier template
    $page_templates = [
        'a-propos' => 'page-a-propos.php',
        'services' => 'page-services.php',
        'galerie'  => 'page-galerie.php',
        'boutique' => 'page-boutique.php',
        'blog'     => 'page-blog.php',
        'contact'  => 'page-contact.php',
        'devis'    => 'page-devis.php',
    ];

    // Page d'accueil
    if ( is_front_page() ) {
        $file = get_stylesheet_directory() . '/page-accueil.php';
        if ( file_exists( $file ) ) return $file;
    }

    // Pages par slug
    if ( is_page() ) {
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        if ( isset( $page_templates[ $slug ] ) ) {
            $file = get_stylesheet_directory() . '/' . $page_templates[ $slug ];
            if ( file_exists( $file ) ) return $file;
        }
    }

    return $template;
});

/* ══════════════════════════════════════════════════════════
   8. EXCERPT
══════════════════════════════════════════════════════════ */
add_filter( 'excerpt_length', fn() => 22, 999 );
add_filter( 'excerpt_more', function() {
    return '… <a class="bd-lire-suite" href="' . esc_url( get_permalink() ) . '">Lire la suite <i class="fas fa-arrow-right"></i></a>';
});

/* ══════════════════════════════════════════════════════════
   9. AJOUT DE BODY CLASSES PERSONNALISÉES
══════════════════════════════════════════════════════════ */
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'baobo-deco';
    if ( is_front_page() ) $classes[] = 'bd-homepage';
    return $classes;
});

/* ══════════════════════════════════════════════════════════
   10. SHORTCODES UTILITAIRES
══════════════════════════════════════════════════════════ */
add_shortcode( 'baobo_annee', fn() => date_i18n('Y') );

add_shortcode( 'baobo_tel', function( $a ) {
    $a     = shortcode_atts([ 'numero' => '+226 07 59 29 97', 'texte' => '' ], $a);
    $clean = preg_replace('/[^0-9+]/', '', $a['numero']);
    $texte = $a['texte'] ?: $a['numero'];
    return '<a href="tel:' . esc_attr($clean) . '" class="bd-tel-link"><i class="fas fa-phone-alt"></i> ' . esc_html($texte) . '</a>';
});

add_shortcode( 'baobo_whatsapp', function( $a ) {
    $a   = shortcode_atts([ 'texte' => 'WhatsApp', 'message' => 'Bonjour BAOBO DECO' ], $a);
    $num = function_exists('baobo_s') ? baobo_s('whatsapp_num', '22607592997') : '22607592997';
    $url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $num) . '?text=' . rawurlencode($a['message']);
    return '<a href="' . esc_url($url) . '" target="_blank" rel="noopener" class="bd-btn bd-btn-or"><i class="fab fa-whatsapp"></i> ' . esc_html($a['texte']) . '</a>';
});

/* ══════════════════════════════════════════════════════════
   11. WIDGETS
══════════════════════════════════════════════════════════ */
add_action( 'widgets_init', function() {
    register_sidebar([
        'name'          => 'Sidebar Boutique',
        'id'            => 'sidebar-boutique',
        'before_widget' => '<div class="bd-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="bd-widget-title">',
        'after_title'   => '</h4>',
    ]);
});

/* ══════════════════════════════════════════════════════════
   12. SÉCURITÉ LOGIN
══════════════════════════════════════════════════════════ */
add_filter( 'login_errors', fn() => 'Identifiants incorrects. Veuillez réessayer.' );
