<?php
if (!class_exists('ctGalleryType')) {


    //require_once CT_THEME_LIB_DIR . '/types/ctTypeBase.class.php';

/**
 * Custom type - Gallery
 */
class ctGalleryType extends ctTypeBase
{


    /**
     * Slug option name
     */

    const OPTION_SLUG = 'gallery_index_slug';

    /**
     * Gets display method for Gallery
     * @param array $meta - post meta
     * @return null|string
     */
    public static function getMethodFromMeta($meta)
    {
        $method = isset($meta['display_method']) ? $meta['display_method'][0] : null;
        /*
        if (!$method) {
            $method = isset($meta['video'][0]) && trim($meta['video'][0]) ? 'video' : 'image';
        }
        */
        return $method;
    }

    /**
     * Initializes gallery
     * @return mixed|void
     */

    public function init()
    {
        add_action('template_redirect', array($this, 'galleryContextFixer'));

        $this->registerType();
        $this->registerTaxonomies();

        add_action("admin_init", array($this, "addMetaBox"));

        /** @var $NHP_Options NHP_Options */
        global $NHP_Options;
        //add options listener for license
        add_action('nhp-opts-options-validate-' . $NHP_Options->args['opt_name'], array($this, 'handleSlugOptionSaved'));
    }

    /**
     * Register type
     */

    protected function registerType()
    {
        $typeData = $this->callFilter('pre_register_type', array(
            'labels' => array(
                'name' => _x('Gallery', 'post type general name', 'ct_theme'),
                'singular_name' => _x('Gallery', 'post type singular name', 'ct_theme'),
                'add_new' => _x('Add New', 'gallery', 'ct_theme'),
                'add_new_item' => __('Add New Gallery', 'ct_theme'),
                'edit_item' => __('Edit Gallery', 'ct_theme'),
                'new_item' => __('New Gallery', 'ct_theme'),
                'view_item' => __('View Gallery', 'ct_theme'),
                'search_items' => __('Search Galleries', 'ct_theme'),
                'not_found' => __('No Galleries found', 'ct_theme'),
                'not_found_in_trash' => __('No Gallery found in Trash', 'ct_theme'),
                'parent_item_colon' => '',
                'menu_name' => __('Galleries', 'ct_theme'),
            ),
            'singular_label' => __('Gallery', 'ct_theme'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            //'menu_position' => 20,
            'menu_icon' => 'dashicons-images-alt',
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'has_archive' => false,
            'rewrite' => array('slug' => $this->getPermalinkSlug(), 'with_front' => true, 'pages' => true, 'feeds' => false),
            'query_var' => false,
            'can_export' => true,
            'show_in_nav_menus' => true,
            'taxonomies' => array('post_tag')
        ));

        register_post_type('gallery', $typeData);
        $this->callHook('post_register_type');

    }

    /**
     * Returns permalink slug
     * @return string
     */

    protected function getPermalinkSlug()
    {
        // Rewriting Permalink Slug
        $permalink_slug = 'gallery';

        if (function_exists('ct_get_context_option')) {
            $permalink_slug = ct_get_context_option('gallery_slug', 'gallery');
        }

        return $permalink_slug;
    }

    /**
     * Creates taxonomies
     */

    protected function registerTaxonomies()
    {
        $data = $this->callFilter('pre_register_taxonomies', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Gallery Categories', 'taxonomy general name', 'ct_theme'),
                'singular_name' => _x('Gallery Category', 'taxonomy singular name', 'ct_theme'),
                'search_items' => __('Search Categories', 'ct_theme'),
                'popular_items' => __('Popular Categories', 'ct_theme'),
                'all_items' => __('All Categories', 'ct_theme'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Gallery Category', 'ct_theme'),
                'update_item' => __('Update Gallery Category', 'ct_theme'),
                'add_new_item' => __('Add New Gallery Category', 'ct_theme'),
                'new_item_name' => __('New Gallery Category Name', 'ct_theme'),
                'separate_items_with_commas' => __('Separate Gallery category with commas', 'ct_theme'),
                'add_or_remove_items' => __('Add or remove Gallery category', 'ct_theme'),
                'choose_from_most_used' => __('Choose from the most used Gallery category', 'ct_theme'),
                'menu_name' => __('Categories', 'ct_theme'),
            ),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'query_var' => 'Gallery_category',
            'rewrite' => false,

        ));
        register_taxonomy('gallery_category', 'Gallery', $data);
        $this->callHook('post_register_taxonomies');
    }

    /**
     * Adds meta box
     */

    public function addMetaBox()
    {
        add_meta_box("gallery-meta", __("Gallery settings", 'ct_theme'), array($this, "galleryMeta"), "gallery", "normal", "high");
        add_action('save_post', array($this, 'saveDetails'));
    }

    /**
     * Fixes proper menu state
     */

    public function galleryContextFixer()
    {
        if (get_query_var('post_type') == 'gallery') {
            global $wp_query;
            $wp_query->is_home = false;
        }
        if (get_query_var('taxonomy') == 'gallery_category') {
            global $wp_query;
            $wp_query->is_404 = true;
            $wp_query->is_tax = false;
            $wp_query->is_archive = false;
        }
    }

    /**
     * Handles rebuild
     */

    public function handleSlugOptionSaved($newValues)
    {
        $currentSlug = $this->getPermalinkSlug();
        //rebuild rewrite if new slug
        if (isset($newValues[self::OPTION_SLUG]) && ($currentSlug != $newValues[self::OPTION_SLUG])) {
            $this->callHook('pre_slug_option_saved', array('current_slug' => $currentSlug, 'new_slug' => $newValues[self::OPTION_SLUG]));

            //clean rewrite to refresh it
            delete_option('rewrite_rules');
        }
    }

    /**
     * Draw s gallery meta
     */

    public function galleryMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);

        $gallery_meta_description = isset($custom['gallery_meta_description'][0]) ? $custom['gallery_meta_description'][0] : '';

        ?>

        <p>
            <label for="gallery_meta_description"><?php _e('Description', 'ct_theme') ?></label>
            <textarea id="gallery_meta_description" class="regular-text" name="gallery_meta_description" cols="100"
                      rows="10"><?php echo esc_html($gallery_meta_description); ?></textarea>
        <p class="howto"><?php _e("Gallery description", 'ct_theme') ?></p>



    <?php
    }

    /**
     * gallery template settings
     */

    public function galleryTemplateMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);
    }

    public function saveDetails()
    {
        global $post;

        $fields = array('gallery_meta_description');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post->ID, $field, $_POST[$field]);
            }
        }
    }

    /**
     * Gets hook name
     * @return string
     */
    protected function getHookBaseName()
    {
        return 'ct_gallery';
    }
}

new ctGalleryType();
}