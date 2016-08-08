<?php


if (!class_exists('ctNavigationClass')) {
    class ctNavigationClass
    {
        public $page_id = '';
        public static  $itemParent;
        public static  $parentItemClassCache = array();
        public static  $parentItemClassToChange = '';


        public function __construct()
        {
            add_filter('nav_menu_css_class', array($this, 'checkItem'), 10, 2); //buils menu items
            add_filter('wp_nav_menu', array($this, 'addClass'), 10, 2);// build navigation
        }

        public function checkItem($classes=array(), $item)
        {

            $currentID = get_the_id();

            if ($item->menu_item_parent == 0 && is_array($classes)){

                self::$itemParent = $item;
                //pre delete active classes (except blog)
                foreach ($classes as $key => $value) {
                    if ($value == 'active' &&  get_post_type( $currentID)!='post')
                        unset($classes [$key]);
                }
                //create cache of current parent menu item class
                self::$parentItemClassCache = implode(' ',$classes);
            }

            if (intval($item->object_id) == $currentID) {

                //current child parent classes = cached classes
                self::$parentItemClassToChange = self::$parentItemClassCache;

                return $classes;
            } else {
                return $classes;
            }
        }


        public function addClass($nav_menu, $args)
        {
            //add active class to parent dropdown menu item. Hook - If you need to change this value.
            self::$parentItemClassToChange = apply_filters('ct_nc_class_parent_class',self::$parentItemClassToChange, $nav_menu);
            $nav_menu = str_replace(self::$parentItemClassToChange, self::$parentItemClassToChange.' active', $nav_menu);
            return $nav_menu;
        }

    }
}
new ctNavigationClass();