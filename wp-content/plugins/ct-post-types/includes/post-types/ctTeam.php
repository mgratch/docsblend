<?php
if (!class_exists('ctTeamType')) {
    //require_once CT_THEME_LIB_DIR . '/types/ctTypeBase.class.php';

/**
 * Custom type - ctTestimonialType
 */
class ctTeamType extends ctTypeBase
{


    /**
     * Slug option name
     */

    const OPTION_SLUG = 'team_index_slug';

    /**
     * Initializes Team
     * @return mixed|void
     */

    public function init()
    {
        add_action('template_redirect', array($this, 'teamContextFixer'));

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
        add_meta_box("team-meta", __("Team settings", 'ct_theme'), array($this, "teamMeta"), "team", "normal", "high");
        add_meta_box("socials-meta", __("socials-meta", 'ct_theme'), array($this, "socialsMeta"), "team", "normal", "high");
        add_action('save_post', array($this, 'saveDetails'));
    }

    /**
     * Fixes proper menu state
     */

    public function teamContextFixer()
    {
        if (get_query_var('post_type') == 'team') {
            global $wp_query;
            $wp_query->is_home = false;
        }
        if (get_query_var('taxonomy') == 'team_category') {
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
                'name' => _x('Team', 'post type general name', 'ct_theme'),
                'singular_name' => _x('Team Member', 'post type singular name', 'ct_theme'),
                'add_new' => _x('Add New', 'Team member', 'ct_theme'),
                'add_new_item' => __('Add New Team member', 'ct_theme'),
                'edit_item' => __('Edit Team Member', 'ct_theme'),
                'new_item' => __('New Team Member', 'ct_theme'),
                'view_item' => __('View Team Member', 'ct_theme'),
                'search_items' => __('Search Team Members', 'ct_theme'),
                'not_found' => __('No Team Members found', 'ct_theme'),
                'not_found_in_trash' => __('No Team Members found in Trash', 'ct_theme'),
                'parent_item_colon' => '',
                'menu_name' => __('Team Members', 'ct_theme'),
            ),
            'singular_label' => __('Team Member', 'ct_theme'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            //'menu_position' => 20,
            'menu_icon' => 'dashicons-groups',
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

        register_post_type('team', $typeData);
        $this->callHook('post_register_type');
    }

    /**
     * Returns permalink slug
     * @return string
     */

    protected function getPermalinkSlug()
    {
        // Rewriting Permalink Slug
        $permalink_slug = 'team';
        if (function_exists('ct_get_option')) {
            $permalink_slug = ct_get_option('th', 'team');

        }

        return $permalink_slug;
    }

    /**
     * Gets hook name
     * @return string
     */
    protected function getHookBaseName()
    {
        return 'ct_team';
    }

    /**
     * Creates taxonomies
     */

    protected function registerTaxonomies()
    {
        $data = $this->callFilter('pre_register_taxonomies', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Team Categories', 'taxonomy general name', 'ct_theme'),
                'singular_name' => _x('Team Category', 'taxonomy singular name', 'ct_theme'),
                'search_items' => __('Search Categories', 'ct_theme'),
                'popular_items' => __('Popular Categories', 'ct_theme'),
                'all_items' => __('All Categories', 'ct_theme'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Team Category', 'ct_theme'),
                'update_item' => __('Update Team Category', 'ct_theme'),
                'add_new_item' => __('Add New Team Category', 'ct_theme'),
                'new_item_name' => __('New Team Category Name', 'ct_theme'),
                'separate_items_with_commas' => __('Separate Team category with commas', 'ct_theme'),
                'add_or_remove_items' => __('Add or remove Team category', 'ct_theme'),
                'choose_from_most_used' => __('Choose from the most used Team category', 'ct_theme'),
                'menu_name' => __('Categories', 'ct_theme'),
            ),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'query_var' => 'team_category',
            'rewrite' => false,

        ));
        register_taxonomy('team_category', 'team', $data);
        $this->callHook('post_register_taxonomies');
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

    public function teamMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);


        $team_position = isset($custom["team_position"][0]) ? $custom["team_position"][0] : "";
        $team_surname = isset($custom["team_surname"][0]) ? $custom["team_surname"][0] : "";
        $team_name = isset($custom["team_name"][0]) ? $custom["team_name"][0] : "";
        $description = isset($custom["description"][0]) ? $custom["description"][0] : "";
        $small_description = isset($custom["small_description"][0]) ? $custom["small_description"][0] : "";


        ?>


        <p>
            <label
                for="team_name"><?php _e("Name", 'ct_theme') ?> </label>
            <input id="team_name" class="regular-text" name="team_name"
                   value="<?php echo esc_html($team_name); ?>"/>
        </p>

        <p>
            <label
                for="team_surname"><?php _e("Surname", 'ct_theme') ?> </label>
            <input id="team_surname" class="regular-text" name="team_surname"
                   value="<?php echo esc_html($team_surname); ?>"/>
        </p>

        <p>
            <label
                for="team_position"><?php _e("Position", 'ct_theme') ?> </label>
            <input id="team_position" class="regular-text" name="team_position" value="<?php echo esc_attr($team_position); ?>"/>
        </p>
        <p>

            <label
                for="description"><?php echo __("Description", 'ct_theme') ?> </label>
            <textarea id="description" class="regular-text" name="description" cols="100"
                      rows="15"><?php echo $description; ?></textarea>
        </p>

        <p>

            <label
                for="small_description"><?php echo __("Small Description", 'ct_theme') ?> </label>
            <textarea id="small_description" class="regular-text" name="small_description" cols="100"
                      rows="2"><?php echo $small_description; ?></textarea>
        </p>

    <?php
    }


    public function socialsMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        if(class_exists('ctSocialsMetaFields')){
            $socials = new ctSocialsMetaFields();
            echo $socials->getTheFields($custom);
        }


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
            'team_name',
            'team_position',
            'team_surname',
            'description',
            'small_description',
        );
        if(class_exists('ctSocialsMetaFields')){
            $fields = array_merge(ctSocialsMetaFields::getFieldsArray(), $fields);
        }



        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post->ID, $field, $_POST[$field]);
            }
        }
    }
}

new ctTeamType();
}