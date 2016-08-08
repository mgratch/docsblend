<?php global $post; ?>
<?php get_template_part('templates/post_single/content-meta'); ?>

<a class="link-post"
   href="<?php echo esc_url(get_post_meta($post->ID, 'link', true)) ?>"><?php _e(esc_html(ct_get_blog_item_title())) ?></a><br>



