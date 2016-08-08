<?php
/*
 *
 * todo: Jako zewnetrzy plugin
 *
 *
 */
if (!class_exists('ctDemoPluginClass')) {
    class ctDemoPluginClass
    {
        public static $settings = array();

        public function __construct()
        {

            if (isset($_GET['blog-type'])) {
                if ($_GET['blog-type'] == 1) {
                    self::$settings['blog_type'] = 'content';
                    add_filter('ct.blog.index.template_name', array($this, 'getBlogTemplate'), 10, 1);

                } elseif ($_GET['blog-type'] == 2) {
                    self::$settings['blog_type'] = 'content-masonry';
                    add_filter('ct.blog.index.template_name', array($this, 'getBlogTemplate'), 10, 1);

                }elseif ($_GET['blog-type'] == 3) {
                    self::$settings['blog_type'] = 'content-secondary';
                    add_filter('ct.blog.index.template_name', array($this, 'getBlogTemplate'), 10, 1);
                }
            }


            if (isset($_GET['sidebar'])) {
                switch ($_GET['sidebar']){
                    case 'left':
                        self::$settings['sidebar'] = 'left';
                        add_filter('ct.sidebar_type', array($this, 'getSidebarType'), 10, 1);
                        break;

                    case 'right':
                        self::$settings['sidebar'] = 'right';
                        add_filter('ct.sidebar_type', array($this, 'getSidebarType'), 10, 1);
                        break;

                    case 'both':
                        self::$settings['sidebar'] = 'both';
                        add_filter('ct.sidebar_type', array($this, 'getSidebarType'), 10, 1);
                        break;

                    case 'none':
                        self::$settings['sidebar'] = 'none';
                        add_filter('ct.sidebar_type', array($this, 'getSidebarType'), 10, 1);
                        break;
                }


            }

        if(isset($_GET['portfolio_columns'])){
            switch($_GET['portfolio_columns']){
                case '1':
                    self::$settings['portfolio_columns'] = '1';
                    add_filter('ct.portfolio_columns', array($this, 'getPortfolioColumns'),10,1);
                    break;

                case '2':
                    self::$settings['portfolio_columns'] = '2';
                    add_filter('ct.portfolio_columns', array($this, 'getPortfolioColumns'),10,1);
                    break;

                case '3':
                    self::$settings['portfolio_columns'] = '3';
                    add_filter('ct.portfolio_columns', array($this, 'getPortfolioColumns'),10,1);
                    break;

                case '4':
                    self::$settings['portfolio_columns'] = '4';
                    add_filter('ct.portfolio_columns', array($this, 'getPortfolioColumns'),10,1);
                    break;
            }

        }

        if(isset($_GET['portfolio'])){
            switch ($_GET['portfolio']){
                case 'boxed':
                    self::$settings['portfolio'] = 'boxed';
                    add_filter('ct.portfolio', array($this, 'getPortfolio'),10,1);
                    break;
                case 'full':
                    self::$settings['portfolio'] = 'full';
                    add_filter('ct.portfolio', array($this, 'getPortfolio'),10,1);
                    break;
            }
        }




        }

        public function getBlogTemplate($templateName)
        {
            return self::$settings['blog_type'];
        }

        public function getSidebarType($templateName)
        {
            return self::$settings['sidebar'];
        }

        public function getPortfolioColumns($templateName)
        {
            return self::$settings['portfolio_columns'];
        }

        public function getPortfolio($templateName)
        {
            return self::$settings['portfolio'];
        }

    }
}
new ctDemoPluginClass();

if (!function_exists('cte')){
    function cte($value=null){
           if ($value){
                var_dump($value);exit();
           }else{
               exit();
           }
    }
}
