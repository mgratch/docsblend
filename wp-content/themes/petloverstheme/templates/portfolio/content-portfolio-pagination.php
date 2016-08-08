<?php

global $wp_query; ?>
<?php if (isset($wp_query) && $wp_query->max_num_pages > 1) : ?>

    <div class="ct-u-marginBoth20">
        <ul class="pagination pagination-lg">

            <?php $current = 1 ?>
            <?php for ($i = 1; $i <= $wp_query->max_num_pages; $i++) { ?>
                <?php if ($paged == $i): ?>
                    <?php $current = $i ?>
                    <li class="active"><a><?php echo (int)$i; ?></a>
                    </li>
                <?php else: ?>
                    <li><a href=" <?php echo esc_url(get_pagenum_link($i)); ?>"><?php echo (int)$i; ?></a></li>
                <?php endif ?>
            <?php } ?>


        </ul>
        <span
            class="ct-pagination-notice text-uppercase"><?php echo esc_html(strtr(ct_get_context_option('portfolio_pagination_notice', 'PAGE %current% OF %total%'), array('%current%' => $current, '%total%' => $wp_query->max_num_pages))); ?></span>
    </div>
    <!-- / pagination -->

    <?php if (false): ?><?php posts_nav_link(); ?><?php endif; ?>
<?php endif; ?>






