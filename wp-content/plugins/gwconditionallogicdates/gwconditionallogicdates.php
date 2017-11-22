<?php
/**
* Plugin Name: GP Conditional Logic Dates
* Description: Allows Date fields to be used in Gravity Forms conditional logic.
* Plugin URI: http://gravitywiz.com/
* Version: 1.0.1
* Author: David Smith
* Author URI: http://gravitywiz.com/
* License: GPL2
* Perk: True
*/

define( 'GP_CONDITIONAL_LOGIC_DATES_VERSION', '1.0.1' );

require 'includes/class-gp-bootstrap.php';

$gp_conditional_logic_dates_bootstrap = new GP_Bootstrap( 'class-gp-conditional-logic-dates.php', __FILE__ );
