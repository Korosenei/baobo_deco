<?php
/**
 * footer.php — BAOBO DECO Child Theme
 * Footer simple : barre copyright uniquement + WhatsApp + Back to top
 */

function bd_s( $key, $default = '' ) {
    global $wpdb;
    $row = $wpdb->get_row( $wpdb->prepare(
        "SELECT setting_val FROM {$wpdb->prefix}baobo_settings WHERE setting_key=%s", $key
    ));
    return $row ? $row->setting_val : $default;
}

$wa_num   = bd_s( 'whatsapp_num', '22607592997' );
$wa_msg   = bd_s( 'whatsapp_msg', 'Bonjour BAOBO DECO, je souhaite des informations sur vos produits et services.' );
$adresse  = bd_s( 'adresse', 'Tampouy, Ouagadougou, Burkina Faso' );
$wa_url   = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_num) . '?text=' . rawurlencode( $wa_msg );
?>

</main><!-- #content -->

<!-- FOOTER SIMPLE -->
<footer class="bd-footer-wrap" id="bdFooter" role="contentinfo">
    <div class="bd-footer-bottom">
        <p>Copyright &copy; <?php echo date_i18n('Y'); ?> <a href="<?php echo esc_url( home_url('/') ); ?>">BAOBO DECO</a> &mdash; Signature Rafi-née</p>
        <span style="color:rgba(255,255,255,.25);">|</span>
        <p><?php echo esc_html( $adresse ); ?></p>
        <span style="color:rgba(255,255,255,.25);">|</span>
        <p>Développé avec <i class="fas fa-heart" style="color:var(--rouge);"></i> pour <a href="<?php echo esc_url( home_url('/') ); ?>">BAOBO DECO</a></p>
    </div>
</footer>

<!-- WHATSAPP FLOTTANT -->
<div class="bd-wa-wrap" id="bdWaWrap">
    <div class="bd-wa-pulse" aria-hidden="true"></div>
    <a href="<?php echo esc_url( $wa_url ); ?>"
       target="_blank"
       rel="noopener noreferrer"
       class="bd-wa-btn"
       id="bdWaBtn"
       aria-label="Nous contacter sur WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </a>
    <div class="bd-wa-tooltip" role="tooltip">Chattez avec nous !</div>
</div>

<!-- BACK TO TOP -->
<a href="#" class="bd-totop" id="bdToTop" aria-label="Retour en haut de page" title="Haut de page">
    <i class="fas fa-chevron-up" aria-hidden="true"></i>
</a>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>