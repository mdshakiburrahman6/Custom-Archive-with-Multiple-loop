<?php get_header(); ?>

<?php
// Get all blog categories
$categories = get_categories([
    'taxonomy'   => 'category',
    'hide_empty' => true,
]);
$current_cat = get_queried_object();
?>

<?php if ( ! empty($categories) ) : ?>
<section class="category-bar">
    <ul class="category-bar-list">
        <?php foreach ( $categories as $cat ) : ?>
            <li class="<?php echo ($current_cat->term_id === $cat->term_id) ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                    <?php echo esc_html($cat->name); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php endif; ?>

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
<!-- 
        <div class="cat-row-1">
            <div class="cat-row-item-1">

            </div>
            <div class="cat-row-item-2">

            </div>
        </div> -->

        <?php if ( $count === 1 ) : ?>
            <section class="featured-area">
                <div class="featured-left">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large'); ?> 
                    </a>
                    <a href="<?php the_permalink(); ?>">
                        <h2><?php the_title(); ?></h2>
                    </a>
                    
                </div>

        <?php elseif ( $count === 2 ) : ?>
                <div class="featured-right">
                    <h2 class="cat-title"><?php single_cat_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large'); ?>
                        <h3><?php the_title(); ?></h3>
                    </a>
                </div>
            </section>

        <!-- =====================
            Trending Section
        ====================== -->
<!-- ======================
     Trending / Recent Posts
====================== -->
<section class="trending">
    <h2 class="trending-title" style="text-align: center;">STORIE DI TENDENZA</h2>
    <span class="trending-line"></span>

    <div class="trending-row">
        <?php
        $recent_posts = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        if ( $recent_posts->have_posts() ) :
            while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
        ?>
            <article class="trend-item">
                <div class="trend-img">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                </div>

                <div class="trend-content">
                    <h4>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h4>

                    <a class="trend-read" href="<?php the_permalink(); ?>">
                        Continua a leggere »
                    </a>
                </div>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
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
                    <h2 class="cat-title"><?php echo esc_html($cat_name); ?></h2>
                    <?php echo wp_kses_post($cat_desc); ?>
                </div>
            </section>

            <!-- START NEW DESIGN -->
            <section class="new-design">
                <article class="new-item">
                    <?php the_post_thumbnail('large'); ?>
                    <div>
                        <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 24); ?></p>
                    <a href="<?php the_permalink(); ?>">Continua a leggere </a>
                    </div>
                </article>

        <!-- =====================
            POSTS 8 → ∞
        ====================== -->
        <?php else : ?>
            <article class="new-item">
                <?php the_post_thumbnail('large'); ?>
               <div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 24); ?></p>
                    <a href="<?php the_permalink(); ?>">Continua a leggere </a>

               </div>
            </article>

        <?php endif; ?>

    <?php endwhile; ?>

    <?php if ( $count >= 7 ) echo '</section>'; ?>

<?php else : ?>
    <p>No posts found.</p>
<?php endif; ?>

</div>

<?php get_footer(); ?>


