<?php

global $wp_query;

//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>


<div class="wp-pagenavi">


<?php echo esc_url(get_previous_posts_page_link()); ?>
<?php echo esc_url(get_next_posts_page_link()); ?>


<ul class="pagination pull-right">
    <?php if ($paged != 1): ?>
        <li><a href="<?php echo esc_url(get_previous_posts_page_link()); ?>"><i class="fa fa-chevron-left"></i></a>
        </li>
    <?php else: ?>
        <li class="disabled"><a><i class="fa fa-chevron-left"></i></a></li>
    <?php endif; ?>



    <?php for ($i = 1; $i <= $wp_query->max_num_pages; $i++) { ?>
        <?php if ($paged == $i): ?>
            <li class="active"><a><?php echo (int)$i; ?></a>
            </li>
        <?php else: ?>
            <li><a href=" <?php echo esc_url(get_pagenum_link($i)); ?>"><?php echo (int)$i; ?></a></li>
        <?php endif ?>
    <?php } ?>



    <?php if ($paged != $wp_query->max_num_pages): ?>
        <li><a class="nextpostslink" href="<?php echo esc_url(get_next_posts_page_link()); ?>"><i class="fa fa-chevron-right"></i></a>
        </li>
    <?php else: ?>
        <li class="disabled"><a><i class="fa fa-chevron-right"></i></a></li>
    <?php endif; ?>

</ul>

</div>
<!-- / pagination -->