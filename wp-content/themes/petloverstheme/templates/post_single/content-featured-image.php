<?php $imgsrc = ct_get_feature_image_src(get_the_ID(), 'featured_image'); ?>
<img src="<?php echo esc_url($imgsrc)?>" alt="<?php echo __('featured image','ct_theme') ?>">
