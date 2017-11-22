<?php 

class GP_Conditional_Logic_Dates extends GWPerk {

    protected $version = GP_CONDITIONAL_LOGIC_DATES_VERSION;
    protected $min_gravity_forms_version = '2.0';
    protected $min_wp_version = '3.4.2';

    public static $instance;

    function init() {

        require_once( $this->get_base_path() . '/includes/class-gw-conditional-logic-date-fields.php' );
        self::$instance = new GWConditionalLogicDateFields( $this );

    }

    function documentation() {
        return array(
            'type'   => 'url',
            'value'  => 'http://gravitywiz.com/documentation/gp-conditional-logic-dates/'
        );
    }

}

class GWConditionalLogicDates extends GP_Conditional_Logic_Dates { }