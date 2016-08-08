<?php
if (!class_exists('ctTestimonialType')) {

    //require_once CT_THEME_LIB_DIR . '/types/ctTypeBase.class.php';

    /**
     * Custom type - ctTestimonialType
     */
    class ctTestimonialType extends ctTypeBase
    {


        /**
         * Slug option name
         */

        const OPTION_SLUG = 'testimonial_index_slug';

        /**
         * Initializes Testimonials
         * @return mixed|void
         */

        public function init()
        {
            add_action('template_redirect', array($this, 'testimonialContextFixer'));

            $this->registerType();
            $this->registerTaxonomies();

            add_action("admin_init", array($this, "addMetaBox"));

            /** @var $NHP_Options NHP_Options */
            global $NHP_Options;
            //add options listener for license
            add_action('nhp-opts-options-validate-' . $NHP_Options->args['opt_name'], array($this, 'handleSlugOptionSaved'));
        }

        /**
         * Adds meta box
         */

        public function addMetaBox()
        {
            add_meta_box("testimonial-meta", __("Testimonial settings", 'ct_theme'), array($this, "testimonialMeta"), "testimonial", "normal", "high");
            // add_meta_box("socials-meta", __("socials-meta", 'ct_theme'), array($this, "socialsMeta"), "testimonial", "normal", "high");
            add_action('save_post', array($this, 'saveDetails'));
        }

        /**
         * Fixes proper menu state
         */

        public function testimonialContextFixer()
        {
            if (get_query_var('post_type') == 'testimonial') {
                global $wp_query;
                $wp_query->is_home = false;
            }
            if (get_query_var('taxonomy') == 'testimonial_category') {
                global $wp_query;
                $wp_query->is_404 = true;
                $wp_query->is_tax = false;
                $wp_query->is_archive = false;
            }
        }

        /**
         * Register type
         */

        protected function registerType()
        {
            $typeData = $this->callFilter('pre_register_type', array(
                'labels' => array(
                    'name' => _x('Testimonials', 'post type general name', 'ct_theme'),
                    'singular_name' => _x('Testimonial', 'post type singular name', 'ct_theme'),
                    'add_new' => _x('Add New', 'Testimonials', 'ct_theme'),
                    'add_new_item' => __('Add New Testimonial', 'ct_theme'),
                    'edit_item' => __('Edit Testimonial', 'ct_theme'),
                    'new_item' => __('New Testimonial', 'ct_theme'),
                    'view_item' => __('View Testimonial', 'ct_theme'),
                    'search_items' => __('Search Testimonials', 'ct_theme'),
                    'not_found' => __('No Testimonials found', 'ct_theme'),
                    'not_found_in_trash' => __('No Testimonials found in Trash', 'ct_theme'),
                    'parent_item_colon' => '',
                    'menu_name' => __('Testimonials', 'ct_theme'),
                ),
                'singular_label' => __('testimonial', 'ct_theme'),
                'public' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                //'menu_position' => 20,
                'menu_icon' => 'dashicons-format-quote',
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

            register_post_type('testimonial', $typeData);
            $this->callHook('post_register_type');
        }

        /**
         * Returns permalink slug
         * @return string
         */

        protected function getPermalinkSlug()
        {
            // Rewriting Permalink Slug
            $permalink_slug = ct_get_option('testimonial', 'testimonial');
            if (empty($permalink_slug)) {
                $permalink_slug = 'testimonial';
            }

            return $permalink_slug;
        }

        /**
         * Gets hook name
         * @return string
         */
        protected function getHookBaseName()
        {
            return 'ct_testimonial';
        }

        /**
         * Creates taxonomies
         */

        protected function registerTaxonomies()
        {
            $data = $this->callFilter('pre_register_taxonomies', array(
                'hierarchical' => true,
                'labels' => array(
                    'name' => _x('Testimonial Categories', 'taxonomy general name', 'ct_theme'),
                    'singular_name' => _x('Testimonial Category', 'taxonomy singular name', 'ct_theme'),
                    'search_items' => __('Search Categories', 'ct_theme'),
                    'popular_items' => __('Popular Categories', 'ct_theme'),
                    'all_items' => __('All Categories', 'ct_theme'),
                    'parent_item' => null,
                    'parent_item_colon' => null,
                    'edit_item' => __('Edit Testimonial Category', 'ct_theme'),
                    'update_item' => __('Update Testimonial Category', 'ct_theme'),
                    'add_new_item' => __('Add New Testimonial Category', 'ct_theme'),
                    'new_item_name' => __('New Testimonial Category Name', 'ct_theme'),
                    'separate_items_with_commas' => __('Separate Testimonial category with commas', 'ct_theme'),
                    'add_or_remove_items' => __('Add or remove Testimonial category', 'ct_theme'),
                    'choose_from_most_used' => __('Choose from the most used Testimonial category', 'ct_theme'),
                    'menu_name' => __('Categories', 'ct_theme'),
                ),
                'public' => false,
                'show_in_nav_menus' => false,
                'show_ui' => true,
                'show_tagcloud' => false,
                'query_var' => 'testimonial_category',
                'rewrite' => false,

            ));
            register_taxonomy('testimonial_category', 'testimonial', $data);
            $this->callHook('post_register_taxonomies');
        }


        /**
         * Gets display method for testimonial
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
         * Draw s Testimonial meta
         */

        public function testimonialMeta()
        {
            global $post;
            $custom = get_post_custom($post->ID);


            $testimonial_auth_name = isset($custom["testimonial_auth_name"][0]) ? $custom["testimonial_auth_name"][0] : "";
            $testimonial_auth_surname = isset($custom["testimonial_auth_surname"][0]) ? $custom["testimonial_auth_surname"][0] : "";
            $testimonial_auth_desc = isset($custom["testimonial_auth_desc"][0]) ? $custom["testimonial_auth_desc"][0] : "";

            ?>

            <p>
                <label
                    for="testimonial_auth_name"><?php _e("Testimonial author name", 'ct_theme') ?> </label>
                <input id="testimonial_auth_name" class="regular-text" name="testimonial_auth_name"
                       value="<?php echo esc_attr($testimonial_auth_name); ?>"/>
            </p>

            <p>
                <label
                    for="testimonial_auth_surname"><?php _e("Testimonial author surname", 'ct_theme') ?> </label>
                <input id="testimonial_auth_surname" class="regular-text" name="testimonial_auth_surname"
                       value="<?php echo esc_attr($testimonial_auth_surname); ?>"/>
            </p>

            <p>
                <label
                    for="testimonial_auth_desc"><?php _e("Testimonial author description", 'ct_theme') ?> </label>
                <input id="testimonial_auth_desc" class="regular-text" name="testimonial_auth_desc"
                       value="<?php echo esc_attr($testimonial_auth_desc); ?>"/>
            </p>
        <?php

        }


        public function socialsMeta()
        {
            global $post;
            $custom = get_post_custom($post->ID);
            //$socials = new ctSocialsMetaFields();
            //$socials->theFields($custom);

            //var_dump(ctSocialsMetaFields::getFieldsArray());
        }

        /**
         * testimonial_footer template settings
         */

        public function testimonialTemplateMeta()
        {
            global $post;
            $custom = get_post_custom($post->ID);

        }

        public function saveDetails()
        {
            global $post;

            $fields = array(
                'testimonial_auth_name', 'testimonial_auth_surname', 'testimonial_auth_desc'
            );

            //$fields = array_merge(ctSocialsMetaFields::getFieldsArray(), $fields);

            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    update_post_meta($post->ID, $field, $_POST[$field]);
                }
            }
        }
    }

//new ctTestimonialType();
}