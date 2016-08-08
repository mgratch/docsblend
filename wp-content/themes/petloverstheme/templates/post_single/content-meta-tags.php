<?php if (ct_get_context_option("posts_single_show_tags", 1) && get_the_tag_list()): ?>





    <p class="ct-tags">
        <span><i class="fa fa-tag"></i><?php _e('Tags:', 'ct_theme') ?></span>
            <?php the_tags('', ', ', '') ?>
    </p>


<?php endif; ?>