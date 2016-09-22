<?php

namespace Settings;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * This function is used to show approval rejection page settings
 * @param  [array] $form_data [Settings stored previously in database]
 * @return [type]            [description]
 */
function quoteupApprovalRejectionPageSection($form_data)
{
    global $quoteupSettings;
    ?>
	<fieldset>
		<?php echo '<legend>' . __('Quotation Approval/Rejection Page', 'quoteup') . '</legend>'; ?>

		<div class="fd">
			<div class='left_div'>
				<label for="wdm_approval_rejection_page"> <?php _e('Approval/Rejection Page', 'quoteup') ?> </label>
			</div>
			<div class='right_div'>
            <?php
            $helptip = __('Plugin will automatically add shortcode [APPROVAL_REJECTION_CHOICE] on the selected page, if it is not already present in the page\'s content', 'quoteup');
            echo $quoteupSettings->quoteupHelpTip($helptip);
            ?>
				<?php
                wp_dropdown_pages(
                    array(
                    'class'              => 'wdm_quoteup_pages_list',
                    'name'               => 'wdm_form_data[approval_rejection_page]',
                    'selected'           => isset($form_data[ 'approval_rejection_page' ]) && ! empty($form_data[ 'approval_rejection_page' ]) ? $form_data[ 'approval_rejection_page' ] : '',
                    'show_option_none'   => __('Select Page', 'quoteup')
                    )
                );
                ?>
			</div>
	<?php $quotationSettingsNonce = wp_create_nonce('fromQuotatioSettings'); ?>
			<input type="hidden" name="quotationSettingsNonce" value="<?php echo $quotationSettingsNonce ?>" />
			<div class='clear'></div>
		</div >
	</fieldset>
	<?php
}

quoteupApprovalRejectionPageSection($form_data);
