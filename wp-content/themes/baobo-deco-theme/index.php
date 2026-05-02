<?php
/**
 * index.php — Template par défaut BAOBO DECO Child
 * Affiché si aucun template plus spécifique n'est trouvé
 */
get_header();
?>

<div class="bd-container" style="padding-top: 60px; padding-bottom: 60px; min-height: 50vh;">
    <?php if ( have_posts() ) : ?>
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 32px;">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bd-reveal'); ?>>
                    <?php if ( has_post_thumbnail() ) the_post_thumbnail('baobo-blog', ['style' => 'width:100%;border-radius:12px;']); ?>
                    <div style="padding: 20px 0;">
                        <h2 style="font-family: var(--ft-display); font-size: 1.3rem; margin-bottom: 10px;">
                            <a href="<?php the_permalink(); ?>" style="color: var(--noir);"><?php the_title(); ?></a>
                        </h2>
                        <div style="color: var(--gris); font-size: .88rem; margin-bottom: 12px;"><?php the_excerpt(); ?></div>
                        <a href="<?php the_permalink(); ?>" class="bd-btn bd-btn-border" style="font-size:.8rem; padding: 9px 20px;">
                            Lire la suite <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <div style="margin-top: 40px; text-align: center;">
            <?php the_posts_navigation(); ?>
        </div>
    <?php else : ?>
        <div style="text-align: center; padding: 80px 0;">
            <i class="fas fa-couch" style="font-size: 3rem; color: var(--gris-clair); display:block; margin-bottom: 20px;"></i>
            <h2 style="font-family: var(--ft-display); color: var(--gris);">Aucun contenu trouvé</h2>
            <p style="color: var(--gris); margin-top: 10px;">Revenez bientôt !</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
