<?php
if (!class_exists('ctPortfolioType')) {


/**
 * Custom type - portfolio
 */
class ctPortfolioType extends ctPortfolioTypeBase
{

    /**
     * Adds meta box
     */

    public function addMetaBox()
    {
        parent::addMetaBox();
        add_meta_box("portfolio-template-meta", __("Template settings", 'ct_theme'), array($this, "portfolioTemplateMeta"), "portfolio", "normal", "high");

    }
    /**
     * Draw s portfolio meta
     */

    public function portfolioMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        $client = isset($custom["client"][0]) ? $custom["client"][0] : "";
        $project_type = isset($custom["project_type"][0]) ? $custom["project_type"][0] : "";
        $technologies = isset($custom["technologies"][0]) ? $custom["technologies"][0] : "";
        $external_url = isset($custom["external_url"][0]) ? $custom["external_url"][0] : "";
        $external_url_label = isset($custom["external_url_label"][0]) ? $custom["external_url_label"][0] : '';
        $video = isset($custom["video"][0]) ? $custom["video"][0] : "";
        $displayMethod = isset($custom['display_method'][0]) ? $custom['display_method'][0] : 'image';


        $title= isset($custom["title"][0]) ? $custom["title"][0] : "";
        $top_title= isset($custom["top_title"][0]) ? $custom["top_title"][0] : "";
        $bottom_title= isset($custom["bottom_title"][0]) ? $custom["bottom_title"][0] : "";


        ?>

        <p>
            <label for="title"><?php _e('title', 'ct_theme') ?>: </label>
            <input id="title" class="regular-text" name="title" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p class="howto"><?php _e("Title to show", 'ct_theme') ?></p>


        <p>
            <label for="top_title"><?php _e('Top title', 'ct_theme') ?>: </label>
            <input id="top_title" class="regular-text" name="top_title" value="<?php echo esc_attr($top_title); ?>"/>
        </p>
        <p class="howto"><?php _e("Top Title to show", 'ct_theme') ?></p>


        <p>
            <label for="bottom_title"><?php _e('bottom title', 'ct_theme') ?>: </label>
            <input id="bottom_title" class="regular-text" name="bottom_title" value="<?php echo esc_attr($bottom_title); ?>"/>
        </p>
        <p class="howto"><?php _e("bottom Title to show", 'ct_theme') ?></p>













        <!--  <p>
            <label for="client"><?php /*_e('Client', 'ct_theme') */?>: </label>
            <input id="client" class="regular-text" name="client" value="<?php /*echo esc_attr($client); */?>"/>
        </p>
        <p class="howto"><?php /*_e("Information about client", 'ct_theme') */?></p>


        <p>
            <label for="project_type"><?php /*_e('Project type', 'ct_theme') */?>: </label>
            <input id="project_type" class="regular-text" name="project_type" value="<?php /*echo esc_attr($project_type); */?>"/>
        </p>
        <p class="howto"><?php /*_e("Information about project type", 'ct_theme') */?></p>


        <p>
            <label for="technologies"><?php /*_e('Technologies', 'ct_theme') */?>: </label>
            <input id="technologies" class="regular-text" name="technologies" value="<?php /*echo esc_attr($technologies); */?>"/>
        </p>
        <p class="howto"><?php /*_e("Information about technologies", 'ct_theme') */?></p>



        <p>
            <label for="external_url">Url: </label>
            <input id="external_url" class="regular-text" name="external_url" value="<?php /*echo esc_attr($external_url); */?>"/>
        </p>
        <p class="howto"><?php /*_e("Link to external site. Leave empty to hide button", 'ct_theme') */?></p>


        <p>
            <label for="external_url_label"><?php /*echo __('Url label:', 'ct_theme') */?></label>
            <input id="external_url_label" class="regular-text" name="external_url_label"
                   value="<?php /*echo esc_attr($external_url_label); */?>"/>
        </p>
        <p class="howto"><?php /*_e("Link to external site. Leave empty to hide button", 'ct_theme') */?></p>


        <p>
            <label for="display_method"><?php /*_e('Show portfolio item as', 'ct_theme') */?>: </label>
            <select class="ct-toggler" id="display_method" name="display_method">
                <option data-group=".display"
                        value="image" <?php /*echo selected('image', $displayMethod) */?>><?php /*_e("Featured image", 'ct_theme') */?></option>
                <option data-group=".display" data-toggle=".ct-toggable.gallery"
                        value="gallery" <?php /*echo selected('gallery', $displayMethod) */?>><?php /*_e("Gallery", 'ct_theme') */?></option>
                <option data-group=".display" data-toggle=".ct-toggable.video"
                        value="video" <?php /*echo selected('video', $displayMethod) */?>><?php /*_e("Video", 'ct_theme') */?></option>
            </select>
        </p>
        <p class="ct-toggable video display">
            <label for="video"><?php /*_e('Video url', 'ct_theme') */?>: </label>
            <input id="video" class="regular-text" name="video" value="<?php /*echo $video; */?>"/>
        </p>-->

    <?php
    }

    /**
     * portfolio template settings
     */

    public function portfolioTemplateMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        $title = isset($custom["show_title_row"][0]) ? $custom["show_title_row"][0] : "";
        $bread = isset($custom["show_breadcrumbs"][0]) ? $custom["show_breadcrumbs"][0] : "";
        ?>



        <p>
            <label for="show_title_row"><?php _e('Show title', 'ct_theme') ?>: </label>
            <select id="show_title_row" name="show_title_row">
                <option
                    value="global" <?php echo selected('global', $title) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option value="yes" <?php echo selected('yes', $title) ?>><?php _e("show title", 'ct_theme') ?></option>
                <option value="no" <?php echo selected('no', $title) ?>><?php _e("hide title", 'ct_theme') ?></option>
            </select>
        </p>
        <p class="howto"><?php _e("Show page title?", 'ct_theme') ?></p>

        <p>
            <label for="show_breadcrumbs"><?php _e('Show breadcrumbs', 'ct_theme') ?>: </label>
            <select id="show_breadcrumbs" name="show_breadcrumbs">
                <option
                    value="global" <?php echo selected('global', $bread) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option
                    value="yes" <?php echo selected('yes', $bread) ?>><?php _e("show breadcrumbs", 'ct_theme') ?></option>
                <option
                    value="no" <?php echo selected('no', $bread) ?>><?php _e("hide breadcrumbs", 'ct_theme') ?></option>
            </select>
        </p>
        <p class="howto"><?php _e("Show breadcrumbs?", 'ct_theme') ?></p>


    <?php
    }


    public function saveDetails()
    {
        parent::saveDetails();
        global $post;

        $fields = array('title', 'bottom_title', 'top_title','project_type', 'technologies', 'client', 'show_title_row', 'show_breadcrumbs', 'summary', 'external_url_label', 'external_url');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post->ID, $field, $_POST[$field]);
            }
        }
    }
}

new ctPortfolioType();
}