<?php

/**
 * Config for customizer
 * @author alex
 */
class ctAdvancedCustomizerConfig
{

    /**
     * Hook to events
     */

    public function __construct()
    {

        add_filter('ct_customizer_mapper.configure', array($this, 'configure'));
        add_filter('ct_customizer.fapath', array($this, 'faPath'));
        add_filter('ct_customizer.filter_vars', array($this, 'fontAwesomePath'));
        add_filter('uberMenuLessPath', array($this, 'uberMenuPath'));
        add_filter('uberMenuLessFileName', array($this, 'uberMenuLessFileName'));
        add_filter('ct_customizer_brand_config', array($this, 'customizerBrand'));
    }
    public function customizerBrand($config){
        $config['logoSrc'] = CT_THEME_SETTINGS_MAIN_DIR_URI . '/img/tp-logo.png';
        $config['docsSrc'] = CT_THEME_DIR_URI . '/docs/documentation.pdf';
        return $config;

    }
    public  function uberMenuPath(){
        return 'ubermenu/';
    }
    public  function uberMenuLessFileName(){
        return 'custom';
    }

    public function faPath()
    {
        return '/fonts/fontawesome/fonts';
    }

    public function fontAwesomePath($vars)
    {
        $uri = str_replace('"','',$vars['assets-path']);
		$vars['fa-font-path'] = '"'.$uri.'fonts/fontawesome/fonts/"';
        return $vars;
    }

    public function configure($mapper)
    {
        $mapper
            ->panel(__('PetLovers - style', 'ct_theme'))
            ->section(__('Motive colors', 'ct_thme'))////////////////// no idea what it is.
            ->add('@motive', __('Motive', 'ct_theme'), 'color', array('current_value' => 'lead_color'))
            ->add('@motive2', __('Motive 2', 'ct_theme'), 'color')
            ->add('@motiveDark', __('Motive Dark', 'ct_theme'), 'color')
            ->add('@motiveDark2', __('Motive Dark 2', 'ct_theme'), 'color')
            ->add('@motiveLight', __('Motive Light', 'ct_theme'), 'color')
            ->add('@motiveLight2', __('Motive Light 2', 'ct_theme'), 'color')
            ->section(__('Fonts', 'ct_thme'))
            ->add('@h1pagesmall', __('H1 color', 'ct_theme'), 'color')
            ->add('@h2color', __('H2 color', 'ct_theme'), 'color')
            ->add('@h2color', __('H2 color', 'ct_theme'), 'color')
            ->add('@h3color', __('H3 color', 'ct_theme'), 'color')
            ->add('@h4color', __('H4 color', 'ct_theme'), 'color')
            ->add('@h4colorspan', __('H4 span color', 'ct_theme'), 'color')
            ->add('@h5color', __('H5 color', 'ct_theme'), 'color')
            ->add('@h6color', __('H6 color', 'ct_theme'), 'color')
            ->add('@pnormal', __('Paragraph color', 'ct_theme'), 'color')
            ->add('@plar', __('Large paragraph color', 'ct_theme'), 'color')
            ->add('@acollapsetext', __('Collapse text color', 'ct_theme'), 'color')
            ->panel(__('General', 'ct_theme'))
            ->section(__('Main', 'ct_thme'))
            /*->option('general_flavour', __('Select theme flavour', 'ct_theme'), 'select',
                array('choices' => (array('ct--lightMotive' => __('light', "ct_theme"),
                    'ct--darkMotive' => __('dark', "ct_theme"))), 'default' => 'ct--lightMotive'))*/
            ->option('general_layout_type', __('Select layout type', 'ct_theme'), 'select',
                array('choices' => array(
                    'wide' => __('wide', "ct_theme"),
                    'boxed' => __('boxed', "ct_theme")), 'default' => 'ct--lightMotive'))
           /* ->option('general_boxed_pattern', __('Select pattern for boxed layout', 'ct_theme'), 'select',
                array('choices' => array(
                    'none' => __('none', "ct_theme"),
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5'), 'default' => ''))*/
            ->option('general_logo_standard', __('Logo standard', 'ct_theme'), 'image', array())
            ->option('general_logo_standard2', __('Logo Light version', 'ct_theme'), 'image', array())
            ->option('general_logo_mobile', __('Logo mobile', 'ct_theme'), 'image', array())
            ->option('general_logo_mobile2', __('Logo mobile Light', 'ct_theme'), 'image', array())

            ->option('general_login_logo', __('Login logo', 'ct_theme'), 'image', array())
            ->option('general_favicon', __('Favicon', 'ct_theme'), 'image', array())
            ->option('general_apple_touch_icon', __('Apple touch icon', 'ct_theme'), 'image', array())
            ->option('general_footer_text', __('Copyright Footer text', 'ct_theme'), 'text', array('description' => __("Available data: %year% (current year), %name% (site name)", 'ct_theme')))
            ->option('general_footer_link', __('Copyright Footer Link', 'ct_theme'), 'text', array('description' => __("ex. http://www.google.com", 'ct_theme')))
          /*  ->option('navbar_search', __('Search icon in navbar', 'ct_theme'), 'show',
                array('default' => '0'))*/
           ->option('header_top', __('Add top header navbar', 'ct_theme'), 'select',
                array('choices' =>array(
                    'no' => 'no',
                    'yes' => 'yes'),))
            ->option('header_top_text', __('Text', 'ct_theme'), 'text')
          /*  ->option('navbar_search', __('Search icon in navbar', 'ct_theme'), 'show',
                array('default' => '0'))*/
            ->panel(__('Footer configuration', 'ct_theme'))
            ->panel(__('Pages', 'ct_theme'))





            ->section(__('Home', 'ct_thme'))


            /*->option('pages_show_bar', __('Show bar', 'ct_theme'), 'show',
                array('default' => '1'))*/


        /*    ->option('pages_color_bar', __('Select Color', 'ct_theme'), 'select',
                array('choices' => array(
                    'ct-headerMotive' => 'Motive',
                    'ct-headerMotiveDark' => 'Motive Dark',
                    'ct-headerMotiveLight' => 'Motive Light',
                    'ct-headerDefault' => 'Default',
                    'ct-headerPrimary' => 'Primary',
                    'ct-headerInfo' => 'Info',
                    'ct-headerWarning' => 'Warning',
                    'ct-headerDanger' => 'Danger'),
                   'default' => 'ct-headerMotive'))


            ->option('pages_size_bar', __('Size Bar', 'ct_theme'), 'select',
                array('choices' => array(
                     ''                  => 'Default',
                    'ct-header--small'     => 'Small'),
                    'default' => ''))


            ->option('pages_show_title_row', __('Show titles on pages', 'ct_theme'), 'show',
                array('default' => '1'))*/

           /* ->option('pages_show_bar', __('Show bar', 'ct_theme'), 'show',
                array('default' => '1'))*/

          /*  ->option('pages_single_show_breadcrumbs', __('Show breadcrumbs on pages', 'ct_theme'), 'show',
                array('default' => '0'))*/
            ->option('pages_single_show_comments', __('Comments', 'ct_theme'), 'show',
                array('default' => '0'))
            ->option('pages_single_show_comment_form', __('Comment form', 'ct_theme'), 'show',
                array('default' => '0'))

            ->section(__('Header', 'ct_thme'))

            ->option('pages_show_bar', __('Show/hide bar', 'ct_theme'), 'show',
                array('default' => '1'))

            ->option('pages_color_bar', __('Color bar', 'ct_theme'), 'select',
                array('choices' => array(
                    'ct-breadcrumb--motive' => __('Motive', 'ct_theme'),
                    'ct-breadcrumb--motiveDark' => __('Motive Dark', 'ct_theme'),
                    'ct-breadcrumb--motiveLight' => __('Motive Light', 'ct_theme'),
                    'ct-breadcrumb--default' => __('Default', 'ct_theme'),
                    'ct-breadcrumb--primary' => __('Primary', 'ct_theme'),
                    'ct-breadcrumb--info' => __('Info', 'ct_theme'),
                    'ct-breadcrumb--warning' => __('Warning', 'ct_theme'),
                    'ct-breadcrumb--danger' => __('Danger', 'ct_theme'),
                ),
                    'default' => 'ct-breadcrumb--motive',
                    'description' => 'No description'))

            ->option('pages_size_bar', __('Size bar', 'ct_theme'), 'select',
                array('choices' => array(
                    '' => __('Default', 'ct_theme'),
                    'ct-header--small' => __('Small', 'ct_theme'),
                ),
                    'default' => '',
                    'description' => 'No description'))
            ->option('pages_show_title_row', __('Show/hide title', 'ct_theme'), 'show',
                array('default' => '1'))
            ->option('pages_show_breadcrumbs', __('Show/hide Breadcrumbs', 'ct_theme'), 'show',
                array('default' => '1'))

            ->section(__('Maintenance Page', 'ct_theme'))
            ->option('maintenance_page_title', __('Title', 'ct_theme'), 'text',
                array('default' => 'We Will Launch Our Website Very Soon',
                    'description' => ''))
            ->option('maintenance_page_description', __('Description', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))

            ->panel(__('Main Navbar', 'ct_theme'))
            ->section(__('Main Navbar', 'ct_thme'))
            ->option('pages_navbar_type', __('Navbar Type', 'ct_theme'), 'select',
                array('choices' => array(
                    'navbar-transparent' => __('transparent', 'ct_theme'),
                    'navbar-default' => __('default', 'ct_theme'),
                    'navbar-inverse' => __('inverse', 'ct_theme'),
                    'navbar-motive' => __('motive', 'ct_theme'),
                    'navbar-success' => __('success', 'ct_theme'),
                    'navbar-info' => __('info', 'ct_theme'),
                    'navbar-warning' => __('warning', 'ct_theme'),
                    'navbar-danger' => __('danger', 'ct_theme'),
                ),
                    'default' => 'navbar-default',
                    'description' => ''))

            ->option('pages_fixed_menu', __('On Scroll', 'ct_theme'), 'select',
                array('choices' => array(
                    'none' => __('none', 'ct_theme'),
                    'ct-navbar--fixedTop' => __('Fixed', 'ct_theme'),
                    'ct-js-navbarMakeSmaller' => __('Fixed Smaller', 'ct_theme'),
                ),
                    'default' => 'none',
                    'description' => ''))



           /* ->option('navbar_menu_animation', __('Dropdown menu animation', 'ct_theme'), 'select',
                array('choices' => array(
                    '' => __('none', 'ct_theme'),
                    'ct-navbar--bounceIn' => __('bounce in', 'ct_theme'),
                    'ct-navbar--fadeIn' => __('fade in', 'ct_theme'),
                    'ct-navbar--fadeInLeft' => __('fade in left', 'ct_theme'),
                    'ct-navbar--fadeInRight' => __('fade in right', 'ct_theme'),
                    'ct-navbar--fadeInDown' => __('fade in down', 'ct_theme'),
                    'ct-navbar--fadeInUp' => __('fade in up', 'ct_theme'),
                    'ct-navbar--pulse' => __('pulse', 'ct_theme'),
                    'ct-navbar--bounceInRight' => __('bounce in right', 'ct_theme'),
                    'ct-navbar--bounceInLeft' => __('bounce in left', 'ct_theme'),
                    'ct-navbar--flipInX' => __('flip in X', 'ct_theme'),
                    'ct-navbar--flipInY' => __('flip in Y', 'ct_theme'),
                ),
                    'default' => 'navbar-default',
                    'description' => ''))
            ->option('navbar_logo_position', __('Logo position', 'ct_theme'), 'select',
                array('choices' => array(
                    'ct-navbar--logoright' => __('right', 'ct_theme'),
                    'ct-navbar--logoleft' => __('left', 'ct_theme'),
                ),
                    'default' => 'ct-navbar--logoright',
                    'description' => ''))
            ->option('navbar_search_show', __('Search on navbar', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))*/
           /* ->option('navbar_search_label', __('Navbar search label', 'ct_theme'), 'text',
                array('default' => 'Search',
                    'description' => ''))
            ->option('navbar_search_placeholder', __('Navbar search placeholder', 'ct_theme'), 'text',
                array('default' => 'Please type keywords...',
                    'description' => ''))
            ->option('navbar_search_icon', __('Navbar search icon class', 'ct_theme'), 'text',
                array('default' => 'fa fa-search',
                    'description' => ''))
            ->option('navbar_searchform_icon', __('Navbar searchform icon class', 'ct_theme'), 'text',
                array('default' => 'fa fa-search fa-fw',
                    'description' => ''))*/


            ->panel(__('Posts', 'ct_theme'))
            ->section(__('Index', 'ct_thme'))
            ->option('posts_index_title_row', __('Blog title', 'ct_theme'), 'text',
                array('default' => 'Blog',
                    'description' => ''))
            ->option('posts_show_index_as', __('Show index as', 'ct_theme'), 'select',
                array('choices' => array(
                    'content' => __('Blog default', 'ct_theme'),
                    'content-secondary' => __('Blog secondary', 'ct_theme'),
                    'content-masonry' => __('Blog grid', 'ct_theme'),
                ),
                    'default' => 'content',
                    'description' => ''))
            ->option('posts_index_show_title_row', __('Show posts index page title', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_index_more_label', __('Post detail button label', 'ct_theme'), 'text',
                array('default' => 'Read More',
                    'description' => ''))
            ->option('posts_index_show_date', __('Date', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_index_show_image', __('Image / video / gallery', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_index_show_title', __('Title / quote author', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_index_show_excerpt_fulltext', __('Text Option', 'ct_theme'), 'select',
                array('choices' => array(
                    'post_excerpt' => __('Show Excerpt', 'ct_theme'),
                    'post_full' => __('Show Full Text', 'ct_theme'),
                    'post_none' => __('No Text', 'ct_theme'),
                ),
                    'default' => 'post_excerpt',
                    'description' => ''))
            ->option('posts_index_show_more', __('Show read more button ?', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_index_sidebar', __('Sidebar', 'ct_theme'), 'select',
                array('choices' => array(
                    'none' => __('none', 'ct_theme'),
                    'right' => __('right', 'ct_theme'),
                    'left' => __('left', 'ct_theme'),
                ),
                    'default' => 'none',
                    'description' => ''))

           /* ->option('posts_index_sidebar_side', __('Sidebar side', 'ct_theme'), 'select',
                array('choices' => array(
                    '' => __('', 'ct_theme'),
                    'right' => __('right', 'ct_theme'),
                    'left' => __('left', 'ct_theme'),
                ),
                    'default' => 'post_excerpt',
                    'description' => ''))*/


            ->option('posts_index_show_tags', __('Tags', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
            ->option('posts_index_show_categories', __('Categories', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
        /*    ->option('posts_index_pagination_notice', __('Pagination notice', 'ct_theme'), 'text',
                array('description' => 'Available data: %current% (current page), %total% (total page). Eg. PAGE %current% OF %total%'))*/
            ->section(__('Single', 'ct_thme'))
            ->option('posts_single_title_row', __('Post page title', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('posts_single_show_title_row', __('Show posts index page title', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_date', __('Date', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_image', __('Image / video / gallery', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_post_title', __('Title / quote author', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_content', __('Content', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_author', __('Author link', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_comments', __('Comments', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_comment_form', __('Comment form', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_comments_link', __('Comments tag', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_sidebar', __('Sidebar', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_tags', __('Tag cloud', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_categories', __('Categories', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_socials', __('Show socials box', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
            ->option('posts_single_share_button_text', __('Share button label', 'ct_theme'), 'text',
                array('default' => 'Share this post',
                    'description' => ''))
            ->option('posts_single_show_author_box', __('Show author box', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('posts_single_show_pagination', __('Pagination', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('single_post_prev_label', __('Previous post label', 'ct_theme'), 'text',
                array('default' => 'Previous Post',
                    'description' => ''))
            ->option('single_post_next_label', __('Next post label', 'ct_theme'), 'text',
                array('default' => 'Next Post',
                    'description' => ''))
            ->option('single_post_by_label', __('By label', 'ct_theme'), 'text',
                array('default' => 'By',
                    'description' => ''))
            ->panel(__('Portfolio', 'ct_theme'))
            ->section(__('Index', 'ct_thme'))
            ->option('portfolio_index_title_row', __('Enter portfolio index page title', 'ct_theme'), 'text',
                array('default' => 'Portfolio',
                    'description' => ''))
            ->option('portfolio_index_show_title_row', __('Show portfolio index page title', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_space', __('Portfolio type', 'ct_theme'), 'select',
                array('choices' => array(
                    'boxed' => __('boxed', 'ct_theme'),
                    'full' => __('full-width', 'ct_theme'),
                ),
                    'default' => 'full',
                    'description' => ''))


            ->option('portfolio_index_slug', __('Alternative portfolio index slug', 'ct_theme'), 'text',
                array('default' => 'portfolio',
                    'description' => ''))




           /* ->option('portfolio_type', __('Select portfolio type', 'ct_theme'), 'select',
                array('choices' => array(
                    'standard' => __('standard', 'ct_theme'),
                    'masonry' => __('masonry', 'ct_theme'),
                    'ajax' => __('ajax', 'ct_theme'),
                ),
                    'default' => 'standard',
                    'description' => ''))*/
          /*  ->option('portfolio_standard_columns', __('Portfolio standard columns', 'ct_theme'), 'select',
                array('choices' => array(
                    '3' => __('3', 'ct_theme'),
                    '4' => __('4', 'ct_theme'),
                ),
                    'default' => '3',
                    'description' => ''))
            ->option('portfolio_ajax_columns', __('Portfolio ajax columns', 'ct_theme'), 'select',
                array('choices' => array(
                    '3' => __('3', 'ct_theme'),
                    '4' => __('4', 'ct_theme'),
                ),
                    'default' => '3',
                    'description' => ''))*/
            ->option('portfolio_masonry_columns', __('Portfolio masonry columns', 'ct_theme'), 'select',
                array('choices' => array(
                    '1' => __('1', 'ct_theme'),
                    '2' => __('2', 'ct_theme'),
                    '3' => __('3', 'ct_theme'),
                    '4' => __('4', 'ct_theme'),
                ),
                    'default' => '3',
                    'description' => ''))
         /*   ->option('portfolio_index_icon', __('Enter icon class', 'ct_theme'), 'text',
                array('default' => 'fa fa-search',
                    'description' => ''))*/
            ->option('portfolio_index_limit', __('Portfolio items show at most', 'ct_theme'), 'text',
                array('default' => '12',
                    'description' => ''))
            ->option('portfolio_index_show_pagination', __('Show pagination', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_index_filters', __('Masonry category filters', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_index_filters_orderby', __('Order category filters by', 'ct_theme'), 'select',
                array('choices' => array(
                    'id' => __('id', 'ct_theme'),
                    'name' => __('name', 'ct_theme'),
                    'count' => __('count', 'ct_theme'),
                    'slug' => __('slug', 'ct_theme'),
                ),
                    'default' => 'name',
                    'description' => ''))
            ->option('portfolio_index_filters_order', __('Order category filters', 'ct_theme'), 'select',
                array('choices' => array(
                    'desc' => __('descending', 'ct_theme'),
                    'asc' => __('ascending', 'ct_theme'),
                ),
                    'default' => 'desc',
                    'description' => ''))
            ->option('portfolio_index_all_label', __('Masonry filter All label', 'ct_theme'), 'text',
                array('default' => 'All',
                    'description' => ''))
            ->option('portfolio_pagination_notice', __('Pagination notice', 'ct_theme'), 'text',
                array('description' => 'Available data: %current% (current page), %total% (total page). Eg. PAGE %current% OF %total%'))
            ->section(__('Single', 'ct_thme'))
           /* ->option('portfolio_single_type', __('Portfolio single type', 'ct_theme'), 'select',
                array('choices' => array(
                    'normal' => __('normal', 'ct_theme'),
                    'magnific_popup' => __('magnific popup', 'ct_theme'),
                ),
                    'default' => 'magnific_popup',
                    'description' => ''))*/
            ->option('portfolio_single_title_row', __('Portfolio single page title', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('portfolio_single_show_title_row', __('Portfolio single show page title', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
           /* ->option('portfolio_single_label_details', __('Project details - label', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('portfolio_single_client_label', __('Project client - label', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('portfolio_single_project_type_label', __('Project type - label', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('portfolio_single_technologies_label', __('Project type - label', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('portfolio_single_website_label', __('Project website - label', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))*/
            ->option('portfolio_single_prev_label', __('Project prev - label', 'ct_theme'), 'text',
                array('default' => 'Previous Project',
                    'description' => ''))
            ->option('portfolio_single_next_label', __('Project next - label', 'ct_theme'), 'text',
                array('default' => 'Next Project',
                    'description' => ''))
            ->option('portfolio_single_back_label', __('back to portfolio - label', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('portfolio_single_show_breadcrumbs', __('Show breadcrumbs', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
            ->option('portfolio_single_show_title', __('Single work Title', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
          /*  ->option('portfolio_single_show_image', __('Image', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_single_show_client', __('Client', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_single_show_date', __('Date', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_single_show_cats', __('Categories', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_single_show_other_projects', __('Other projects', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''))
            ->option('portfolio_single_url_label', __('External URL label', 'ct_theme'), 'text',
                array('default' => 'Online',
                    'description' => ''))
            ->option('portfolio_single_cats_label', __('Categories label', 'ct_theme'), 'text',
                array('default' => 'Categries',
                    'description' => ''))
            ->option('portfolio_single_date_label', __('Date label', 'ct_theme'), 'text',
                array('default' => 'Date',
                    'description' => ''))*/
            /*->option('portfolio_single_client_label', __('Client label', 'ct_theme'), 'text',
                array('default' => 'Client',
                    'description' => ''))*/
           /* ->option('portfolio_single_show_comments', __('Comments', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
            ->option('portfolio_single_show_comment_form', __('Comment form', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
            ->option('portfolio_related_projects_label', __('Related projects label', 'ct_theme'), 'text',
                array('default' => 'Related Works',
                    'description' => ''))*/
            /*->option('portfolio_related_projects_label_2', __('Related projects description', 'ct_theme'), 'text',
                array('default' => 'Other awesome works from the same category',
                    'description' => ''))*/
            ->option('portfolio_related_projects_limit', __('Related projects limit', 'ct_theme'), 'text',
                array('default' => 'Related works limit',
                    'description' => ''))
            ->panel(__('Socials', 'ct_theme'))
            ->section(__('Socials', 'ct_thme'))
            ->option('bitbucket', __('Bitbucket username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('dribbble', __('Dribbble username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('dropbox', __('Dropbox username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('email', __('Email', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('facebook', __('Facebook username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('flickr', __('Flickr username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('foursquare', __('Foursquare ID', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('github', __('Github username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('gittip', __('Gittip username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('google', __('Google plus username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('instagram', __('Instagram username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('linkedin', __('Linkedin username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('pinterest', __('Pinterest username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('renren', __('Renren ID', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('rss', __('RSS', 'ct_theme'), 'show',
                array('default' => '0',
                    'description' => ''))
            ->option('skype', __('Skype username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('stack_exchange', __('Stack Exchange ID', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('stack_overflow', __('Stack Overflow username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('tumblr', __('Tumblr sername', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('twitter', __('Twitter username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('vimeo', __('Vimeo username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('vkontakte', __('VKontakte username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('weibo', __('Weibo username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('xing', __('Xing username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            ->option('youtube', __('Youtube username', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => ''))
            /*Faq*/
            ->panel(__('Faq', 'ct_theme'))
            ->section(__('Faq', 'ct_thme'))
            ->option('faq_section_header', __('FAQ header', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => 'you can set header for FAQ section'))
            ->option('faq_section_subheader', __('FAQ subheader', 'ct_theme'), 'text',
                array('default' => '',
                    'description' => 'you can set subheader for FAQ section'))
           /* ->option('faq_flavour', __('Select faq accordion style', 'ct_theme'), 'select',
                array('choices' => array(
                    'ct--lightMotive' => __('light', 'ct_theme'),
                    'ct-panelGroup--dark' => __('dark', 'ct_theme'),
                ),
                    'default' => 'ct--lightMotive',
                    'description' => ''))*/
            ->option('faq_bg', __('Select background color', 'ct_theme'), 'select',
                array('choices' => array(
                    '' => __('', 'ct_theme'),
                    'ct-u-backgroundWhite' => __('white', 'ct_theme'),
                    'ct-u-backgroundGray' => __('gray', 'ct_theme'),
                    'ct-u-backgroundGray2' => __('gray 2', 'ct_theme'),
                    'ct-u-backgroundDarkGray' => __('dark gray', 'ct_theme'),
                    'ct-u-backgroundDarkGray2' => __('dark gray 2', 'ct_theme'),
                    'ct-u-backgroundDarkGray3' => __('dark gray 3', 'ct_theme'),
                    'ct-u-backgroundMotive' => __('motive', 'ct_theme'),
                    'ct-u-backgroundDarkMotive' => __('dark motive', 'ct_theme'),
                ),
                    'default' => 'ct--lightMotive',
                    'description' => ''))
            ->panel(__('WooCommerce', 'ct_theme'))
            ->section(__('WooCommerce', 'ct_thme'))
            ->option('shop_product_single_show_share', __('Show share icons?', 'ct_theme'), 'show',
                array('default' => '1',
                    'description' => ''));

        return $mapper;
    }
}

new ctAdvancedCustomizerConfig();