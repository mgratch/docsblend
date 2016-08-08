<?php if (ct_get_context_option("posts_single_show_author_box", 1)): ?>

    <div class="ct-slideInLeftSection ct-slideInLeftSection-motive ct-u-paddingBoth20 animated activate bounceInLeft"
         data-fx="bounceInLeft">

        <ul class="ct-mediaList list-unstyled">
            <li>

                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>">
                    <?php _e(get_avatar(get_the_author_meta('ID'), '85')); ?>
                </a>

                <div>
                    <p class="ct-u-paddingBottom10"><span><?php the_author() ?></span>
                        - <?php echo sprintf(__('%s', 'ct_theme'), esc_html(get_the_date())); ?> </p>

                    <p><?php the_author_meta('user_description', get_the_author_meta('ID')); ?></p>
                </div>

            </li>
        </ul>
    </div>
<?php endif; ?>