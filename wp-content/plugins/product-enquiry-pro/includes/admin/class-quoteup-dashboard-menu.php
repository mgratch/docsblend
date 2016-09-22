<?php
namespace Admin\Includes;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class QuoteUpDashboardMenu
{

    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }


        return static::$instance;
    }

    protected function __construct()
    {
        add_action('admin_menu', array( $this, 'dashboardMenu' ), 11);
    }

    /**
     * Include required files and create a menu for QuoteUp
     * @global array $quoteup_plugin_data
     */
    public function dashboardMenu()
    {
        global $quoteup_plugin_data, $quoteupQuoteDetails, $quoteupQuoteDetailsEdit, $quoteupSettings;
        require_once(QUOTEUP_PLUGIN_DIR . '/includes/class-quoteup-get-data.php');
        require_once(QUOTEUP_PLUGIN_DIR . '/includes/admin/class-quoteup-quotes-list.php');
                require_once(QUOTEUP_PLUGIN_DIR . '/includes/admin/class-quoteup-enquiries-list.php');
        $getDataFromDb = \Combined\Includes\QuoteupGetData::getDataFromDb($quoteup_plugin_data);
        $optionData = get_option('wdm_form_data');
        if ($getDataFromDb == 'available') {
            add_menu_page(__('QuoteUp', 'quoteup'), __('Product Enquiry', 'quoteup'), 'manage_options', 'quoteup-details-new', array($quoteupQuoteDetails, 'displayQuoteDetails'));
            add_submenu_page('', __('Quote Details', 'quoteup'), __('Quote Details', 'quoteup'), 'manage_options', 'quoteup-details-edit', array($quoteupQuoteDetailsEdit, 'editQuoteDetails'));
            if (isset($optionData['enable_disable_quote']) && $optionData['enable_disable_quote']==1) {
                $menu = add_submenu_page('quoteup-details-new', __('Enquiry Details', 'quoteup'), __('Enquiry Details', 'quoteup'), 'manage_options', 'quoteup-details-new', array($quoteupQuoteDetails, 'displayQuoteDetails'));

            } else {
                $menu = add_submenu_page('quoteup-details-new', __('Enquiry & Quote Details', 'quoteup'), __('Enquiry & Quote Details', 'quoteup'), 'manage_options', 'quoteup-details-new', array($quoteupQuoteDetails, 'displayQuoteDetails'));
            }
            add_action("load-{$menu}", array($this,'menu_action__load_hook'));
            add_submenu_page('quoteup-details-new', __('QuoteUp Settings', 'quoteup'), __('Settings', 'quoteup'), 'manage_options', 'quoteup-for-woocommerce', array($quoteupSettings, 'displaySettings'));

            // unset($menu);
        }
    }

    public function menu_action__load_hook()
    {
        global $quoteupQuotesList,$quoteupEnquiriesList;
        $optionData = get_option('wdm_form_data');
        if (isset($optionData['enable_disable_quote']) && $optionData['enable_disable_quote'] == 1) {
            $quoteupEnquiriesList = new QuoteupEnquiriesList();
        } else {
            $quoteupQuotesList = new QuoteupQuotesList();
        }    
    }
}

$quoteupDashboardMenu = QuoteUpDashboardMenu::getInstance();
