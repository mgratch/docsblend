<?php /*global $wp_query;
$arrgs = $wp_query->query_vars;
*/?><!--

<div class="ct-navbar-search">
    <form role="form" action="<?php /*echo home_url('/'); */?>">
        <div class="form-group">
            <input type="text" class="form-control" required
                   value="<?php /*echo (isset($arrgs['s']) && $arrgs['s']) ? esc_attr($arrgs['s']) : ''; */?>"
                   name="s" id="s"
                   placeholder="<?php /*echo esc_attr(ct_get_context_option('navbar_search_placeholder', __('Please type keywords...', 'ct_theme'))) */?>"
                >
        </div>
        <button class="ct-navbar-search-button" type="submit">
            <i class="<?php /*echo ct_get_context_option('navbar_searchform_icon', 'fa fa-search fa-fw') */?>"></i>
        </button>
    </form>
</div>-->