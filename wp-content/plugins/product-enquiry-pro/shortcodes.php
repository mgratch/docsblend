<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_shortcode('APPROVAL_REJECTION_CHOICE', array('Frontend\Includes\QuoteupHandleQuoteApprovalRejection', 'approvalRejectionShortcodeCallback'));

add_shortcode('ENQUIRY_CART', array('Frontend\Includes\QuoteupHandleEnquiryCart', 'quoteupEnquiryCartShortcodeCallback'));
