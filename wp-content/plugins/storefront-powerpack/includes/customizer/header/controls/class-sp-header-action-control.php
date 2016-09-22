<?php
/**
 * Class to create a Action Control.
 *
 * @package  Storefront_Powerpack
 * @author   Tiago Noronha
 * @since    1.0.0
 */
class SP_Header_Action_Control extends WP_Customize_Control {
	public function render_content() {
		?>
		<div class="sp-section-notice sp-section-notice-header">
			<span class="dashicons dashicons-info"></span>
			<?php _e( 'The Header Configurator allows you to toggle and rearrange the components in Storefront\'s header.', 'storefront-powerpack' ); ?>
		</div>

		<button class="button sp-header-open"><?php _e( 'Header Configurator', 'storefront-powerpack' ); ?></button>
		<input type="hidden" <?php $this->input_attrs(); ?> value="" <?php echo $this->get_link(); ?> />
		<?php
	}
}