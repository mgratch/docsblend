<?php global $wp_query;

$arrgs = $wp_query->query_vars; ?>
<div class="ct-inputSearch ct-u-marginBottom40">
<form role="search" method="get" id="searchform" class="form-search" action="<?php echo esc_url(home_url('/')); ?>">

    <input type="text"
           value="<?php echo (isset($arrgs['s']) && $arrgs['s']) ? esc_attr($arrgs['s']) : ''; ?>" name="s" id="s"
           placeholder="<?php _e('Search...', 'ct_theme') ?>" required="">

    <button class="" type="submit"><i class="fa fa-search"></i></button>






</form></div>