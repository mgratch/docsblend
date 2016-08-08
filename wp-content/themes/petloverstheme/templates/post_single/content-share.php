
<?php if (ct_get_context_option("posts_single_show_socials", 0)): ?>

    <p class="ct-socials"><span><?php _e(ct_get_context_option('posts_single_share_button_text', 'Share: '), 'ct_theme') ?></span>
        <a href="<?php echo esc_url('http://www.facebook.com/sharer.php?u=' . get_permalink()) ?>"
           target="_blank" data-toggle="tooltip" data-placement="top" title=""
           data-original-title="Facebook"><i class="fa fa-fw fa-facebook-square"></i></a>

        <a href="<?php echo esc_url('https://twitter.com/share?url=' . get_permalink()) ?>"
           target="_blank" data-toggle="tooltip" data-placement="top" title=""
           data-original-title="Twitter"><i class="fa fa-fw fa-twitter"></i></a>

        <a href="<?php echo esc_url('https://plus.google.com/share?url=' . get_permalink()) ?>"
           target="_blank" data-toggle="tooltip" data-placement="top" title=""
           data-original-title="Google +"><i class="fa fa-fw fa-google-plus"></i></a>


        <a href="<?php echo esc_url('mailto:?subject=' . get_the_title() . '&body=' . get_permalink()) ?>"
           data-toggle="tooltip" data-placement="top" title=""
           data-original-title="<?php _e('Mail', 'ct_theme') ?>"><i
                class="fa fa-fw fa-envelope"></i></a>

    </p>

<?php endif; ?>