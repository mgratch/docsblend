<?php
if (!class_exists('ctPageType')) {


/**
 * page type
 */
class ctPageType extends ctPageTypeBase
{

    /**
     * Adds meta box
     */

    public function addMetaBox()
    {
        parent::addMetaBox();
        add_meta_box("page-template-meta", __("Template settings", 'ct_theme'), array($this, "pageTemplateMeta"), "page", "normal", "low");
    }


    /**
     * page template settings
     * todo: every select should be have "global" option
     */

    public function pageTemplateMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);
        $pages_show_title_row = isset($custom["pages_show_title_row"][0]) ? $custom["pages_show_title_row"][0] : "";
        $bread = isset($custom["show_breadcrumbs"][0]) ? $custom["show_breadcrumbs"][0] : "";

        $pages_color_bar = isset($custom["pages_color_bar"][0]) ? $custom["pages_color_bar"][0] : "";
        $pages_size_bar = isset($custom["pages_size_bar"][0]) ? $custom["pages_size_bar"][0] : "";
        $pages_show_bar = isset($custom["pages_show_bar"][0]) ? $custom["pages_show_bar"][0] : "";
        $pages_navbar_type = isset($custom['pages_navbar_type'][0]) ? $custom['pages_navbar_type'][0] : '';
        $pages_fixed_menu = isset($custom['pages_fixed_menu'][0]) ? $custom['pages_fixed_menu'][0] : '';

        ?>


        <p>
            <label for="pages_show_bar"><?php _e('Show Bar', 'ct_theme') ?>: </label>
            <select id="pages_show_bar" name="pages_show_bar">
                <option
                    value="global" <?php echo selected('global', $pages_show_bar) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option value="yes" <?php echo selected('yes', $pages_show_bar) ?>><?php _e("show bar", 'ct_theme') ?></option>
                <option value="no" <?php echo selected('no', $pages_show_bar) ?>><?php _e("hide bar", 'ct_theme') ?></option>
            </select>
        </p>



        <p>
            <label for="pages_color_bar"><?php _e('Color Bar', 'ct_theme') ?>: </label>
            <select id="pages_color_bar" name="pages_color_bar">
                <option
                    value="global" <?php echo selected('global', $pages_color_bar) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--motive" <?php echo selected('ct-breadcrumb--motive', $pages_color_bar) ?>><?php _e("Motive", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--motiveDark" <?php echo selected('ct-breadcrumb--motiveDark', $pages_color_bar) ?>><?php _e("Motive Dark", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--motiveLight" <?php echo selected('ct-breadcrumb--motiveLight', $pages_color_bar) ?>><?php _e("Motive Light", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--default" <?php echo selected('ct-breadcrumb--default', $pages_color_bar) ?>><?php _e("Default", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--primary" <?php echo selected('ct-breadcrumb--primary', $pages_color_bar) ?>><?php _e("Primary", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--info" <?php echo selected('ct-breadcrumb--info', $pages_color_bar) ?>><?php _e("Info", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--warning" <?php echo selected('ct-breadcrumb--warning', $pages_color_bar) ?>><?php _e("Warning", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--danger" <?php echo selected('ct-breadcrumb--danger', $pages_color_bar) ?>><?php _e("Danger", 'ct_theme') ?></option>
            </select>
        </p>


        <p>
            <label for="pages_size_bar"><?php _e('Size Bar', 'ct_theme') ?>: </label>
            <select id="pages_size_bar" name="pages_size_bar">
                <option
                    value="global" <?php echo selected('global', $pages_size_bar) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option value="default" <?php echo selected('', $pages_size_bar) ?>><?php _e("Default", 'ct_theme') ?></option>
                <option value="ct-breadcrumb--small" <?php echo selected('ct-breadcrumb--small', $pages_size_bar) ?>><?php _e("Small", 'ct_theme') ?></option>

            </select>
        </p>



        <p>
            <label for="pages_show_title_row"><?php _e('Show title', 'ct_theme') ?>: </label>
            <select id="pages_show_title_row" name="pages_show_title_row">
                <option
                    value="global" <?php echo selected('global', $pages_show_title_row) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option value="yes" <?php echo selected('yes', $pages_show_title_row) ?>><?php _e("show title", 'ct_theme') ?></option>
                <option value="no" <?php echo selected('no', $pages_show_title_row) ?>><?php _e("hide title", 'ct_theme') ?></option>
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


        <hr>




        <p>
            <label for="pages_navbar_type"><?php _e('Navbar type', 'ct_theme') ?>: </label>
            <select id="pages_navbar_type" name="pages_navbar_type">
                <option
                    value="global" <?php echo selected('global', $pages_navbar_type) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option
                    value="navbar-transparent" <?php echo selected('navbar-transparent', $pages_navbar_type) ?>><?php _e("transparent", 'ct_theme') ?></option>
                <option
                    value="navbar-default" <?php echo selected('navbar-default', $pages_navbar_type) ?>><?php _e("default", 'ct_theme') ?></option>
                <option
                    value="navbar-inverse" <?php echo selected('navbar-inverse', $pages_navbar_type) ?>><?php _e("inverse", 'ct_theme') ?></option>
                <option
                    value="ct-navbar--motive" <?php echo selected('navbar-motive', $pages_navbar_type) ?>><?php _e("motive", 'ct_theme') ?></option>
                <option
                    value="navbar-success" <?php echo selected('navbar-success', $pages_navbar_type) ?>><?php _e("success", 'ct_theme') ?></option>
                <option
                    value="navbar-info" <?php echo selected('navbar-info', $pages_navbar_type) ?>><?php _e("info", 'ct_theme') ?></option>
                <option
                    value="navbar-warning" <?php echo selected('navbar-warning', $pages_navbar_type) ?>><?php _e("warning", 'ct_theme') ?></option>
                <option
                    value="navbar-danger" <?php echo selected('navbar-danger', $pages_navbar_type) ?>><?php _e("danger", 'ct_theme') ?></option>


            </select>
        </p>
        <p>
            <label for="pages_fixed_menu"><?php _e('On Scrool', 'ct_theme') ?>: </label>
            <select id="pages_fixed_menu" name="pages_fixed_menu">
                <option
                    value="pages_fixed_menu" <?php echo selected('global', $pages_fixed_menu) ?>><?php _e("use global settings", 'ct_theme') ?></option>
                <option
                    value="none" <?php echo selected('none', $pages_fixed_menu) ?>><?php _e("disabled", 'ct_theme') ?></option>
                <option
                    value="ct-navbar--fixedTop" <?php echo selected('ct-navbar--fixedTop', $pages_fixed_menu) ?>><?php _e("Fixed", 'ct_theme') ?></option>
                <option
                    value="ct-js-navbarMakeSmaller" <?php echo selected('ct-js-navbarMakeSmaller', $pages_fixed_menu) ?>><?php _e("Fixed Smaller", 'ct_theme') ?></option>
            </select>
        </p>



    <?php

    }

    public function saveDetails()
    {
        parent::saveDetails();
        global $post;

        $fields = array('pages_show_title_row',
            'show_breadcrumbs',
            'pages_show_bar',
            'pages_color_bar',
            'pages_size_bar',
            'pages_navbar_type',
            'pages_fixed_menu',

        );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post->ID, $field, $_POST[$field]);
            }
        }
    }
}

new ctPageType();}