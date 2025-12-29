<?php

/**
 * Plugin Name: Custom-Archive-with-Multiple-loop
 * Description: Custom post type with Custom Archive Page design.
 * Author: Md Shakibur Rahman
 * Author URI: https://github.com/mdshakiburrahman6
 * Version: 1.0.0 
 * Text Domain: custom-post
 */

if(!defined('ABSPATH')) exit;

// Constants
define('CP_PATH', plugin_dir_path( __FILE__ ));
define('CP_URL', plugin_dir_url( __FILE__ ));



// Plugin activation / deactivation
add_filter('template_include', function ($template) {

    // Default BLOG category
    if ( is_category() ) {

        $plugin_template = CP_PATH . 'templates/category.php';

        if ( file_exists($plugin_template) ) {
            return $plugin_template;
        }
    }

    return $template;
});
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'custom-post-category-style',
        CP_URL . 'assets/css/frontend.css',
        [],
        filemtime( CP_PATH . 'assets/css/frontend.css' ) // cache bust
    );

});




// ===============================
// Category Image for DEFAULT POST CATEGORIES
// ===============================

// ADD FIELD (Add Category)
add_action('category_add_form_fields', function () { ?>
    <div class="form-field term-group">
        <label for="category_image_id">Category Image</label>
        <input type="hidden" id="category_image_id" name="category_image_id" value="">
        <div id="category-image-preview"></div>
        <button type="button" class="button category-image-upload">Upload Image</button>
    </div>
<?php });

// EDIT FIELD (Edit Category)
add_action('category_edit_form_fields', function ($term) {
    $image_id = get_term_meta($term->term_id, 'category_image_id', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="category_image_id">Category Image</label></th>
        <td>
            <input type="hidden" id="category_image_id" name="category_image_id"
                   value="<?php echo esc_attr($image_id); ?>">
            <div id="category-image-preview">
                <?php if ($image_id) echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
            </div>
            <button type="button" class="button category-image-upload">Upload Image</button>
        </td>
    </tr>
<?php });

// SAVE
add_action('created_category', function ($term_id) {
    if (isset($_POST['category_image_id'])) {
        update_term_meta($term_id, 'category_image_id', intval($_POST['category_image_id']));
    }
});
add_action('edited_category', function ($term_id) {
    if (isset($_POST['category_image_id'])) {
        update_term_meta($term_id, 'category_image_id', intval($_POST['category_image_id']));
    }
});

// ADMIN SCRIPTS
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'edit-tags.php' && $hook !== 'term.php') return;

    wp_enqueue_media();

    wp_register_script('category-image-js', false, ['jquery'], false, true);
    wp_enqueue_script('category-image-js');

    wp_add_inline_script('category-image-js', "
        jQuery(document).on('click', '.category-image-upload', function(e){
            e.preventDefault();

            let button = jQuery(this);
            let frame = wp.media({
                title: 'Select Category Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            frame.on('select', function(){
                let attachment = frame.state().get('selection').first().toJSON();
                button.closest('td, .term-group')
                      .find('#category_image_id')
                      .val(attachment.id);

                button.closest('td, .term-group')
                      .find('#category-image-preview')
                      .html('<img src=\"'+attachment.url+'\" style=\"max-width:150px;\">');
            });

            frame.open();
        });
    ");
});
