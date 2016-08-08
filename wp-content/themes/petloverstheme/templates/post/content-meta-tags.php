<?php if (ct_get_context_option("posts_index_show_tags", 1)): ?>
    <div class="ct-blog-tags list-inline">
        <?php the_tags('<li>', '</li>') ?>
    </div>
<?php endif; ?>