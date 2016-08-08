<?php
//require_once 'ctTypeBase.class.php';
/**
 * Page type handler
 * @author hc
 */

class ctPageTypeBase extends ctTypeBase {

	/**
	 * Slug option name
	 */

	const OPTION_SLUG = 'page_index_slug';

	/**
	 * Initializes events
	 * @return mixed|void
	 */

	public function init() {
		add_action("admin_init", array($this, "addMetaBox"));


	}


	/**
		 * Adds meta box
		 */

		public function addMetaBox() {
			add_action('save_post', array($this, 'saveDetails'));
		}

		/**
		 * Gets hook name
		 * @return string
		 */
		protected function getHookBaseName() {
			return 'ct_page';
		}

		/**
		 * Returns permalink slug
		 * @return string
		 */

		protected function getPermalinkSlug() {
			// Rewriting Permalink Slug
			$permalink_slug = 'page';
			if(function_exists('ct_get_context_option')){
				$permalink_slug = ct_get_context_option( 'page_index_slug', 'page' );
			}elseif(function_exists('ct_get_option')) {
				$permalink_slug = ct_get_option('page_index_slug', 'page');
			}

			return $permalink_slug;
		}

		public function saveDetails() {
			global $post;

			$fields = array();
			foreach ($fields as $field) {
				if (isset($_POST[$field])) {
					update_post_meta($post->ID, $field, $_POST[$field]);
				}
			}
		}

		/**
		 * Handles rebuild
		 */

		public function handleSlugOptionSaved($newValues) {
			$currentSlug = $this->getPermalinkSlug();
			//rebuild rewrite if new slug
			if (isset($newValues[self::OPTION_SLUG]) && ($currentSlug != $newValues[self::OPTION_SLUG])) {
				$this->callHook('pre_slug_option_saved', array('current_slug' => $currentSlug, 'new_slug' => $newValues[self::OPTION_SLUG]));

				//clean rewrite to refresh it
				delete_option('rewrite_rules');
			}
		}
}
