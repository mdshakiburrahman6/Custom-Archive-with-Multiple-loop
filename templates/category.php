<?php get_header(); ?>

<div class="archive-wrap">

<?php
$count = 0;
$list_open = false;

// ===== BLOG CATEGORY DATA =====
$term      = get_queried_object();
$cat_id    = $term->term_id;
$cat_name  = single_cat_title('', false);
$cat_desc  = term_description();
$cat_imgID = get_term_meta($cat_id, 'category_image_id', true); // manual image field
?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); $count++; ?>

        <!-- =====================
            FEATURED POSTS
        ====================== -->
        <?php if ( $count === 1 ) : ?>
            <section class="featured-area">
                <div class="featured-left">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large'); ?>
                        <h2><?php the_title(); ?></h2>
                    </a>
                </div>

        <?php elseif ( $count === 2 ) : ?>
                <div class="featured-right">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large'); ?>
                        <h3><?php the_title(); ?></h3>
                    </a>
                </div>
            </section>

        <!-- =====================
            POSTS 3–6
        ====================== -->
        <?php elseif ( $count <= 6 ) : ?>

            <?php if ( ! $list_open ) {
                echo '<section class="list-wrap">';
                $list_open = true;
            } ?>

            <article class="list-item">
                <div class="list-img"><?php the_post_thumbnail('medium'); ?></div>
                <div class="list-content">
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
                    <a href="<?php the_permalink(); ?>">Read more →</a>
                </div>
            </article>

            <?php if ( $count === 6 ) echo '</section>'; ?>

        <!-- =====================
            CATEGORY INFO (AFTER 6)
        ====================== -->
        <?php elseif ( $count === 7 ) : ?>

            <section class="category-info">
                <?php if ( $cat_imgID ) : ?>
                    <div class="cat-img">
                        <?php echo wp_get_attachment_image($cat_imgID, 'large'); ?>
                    </div>
                <?php endif; ?>

                <div class="cat-content">
                    <h2><?php echo esc_html($cat_name); ?></h2>
                    <?php echo wp_kses_post($cat_desc); ?>
                </div>
            </section>

            <!-- START NEW DESIGN -->
            <section class="new-design">
                <article class="new-item">
                    <?php the_post_thumbnail('large'); ?>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 24); ?></p>
                </article>

        <!-- =====================
            POSTS 8 → ∞
        ====================== -->
        <?php else : ?>
            <article class="new-item">
                <?php the_post_thumbnail('large'); ?>
                <h3><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), 24); ?></p>
            </article>

        <?php endif; ?>

    <?php endwhile; ?>

    <?php if ( $count >= 7 ) echo '</section>'; ?>

<?php else : ?>
    <p>No posts found.</p>
<?php endif; ?>

</div>

<?php get_footer(); ?>
