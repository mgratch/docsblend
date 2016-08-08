<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

    <p class="sticky"><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Start here!</a>.', 'ct_theme' ), admin_url( 'post-new.php' ) ); ?></p>

<?php elseif ( is_search() ) : ?>

    <p class="sticky"><?php _e( 'No match found. Please try again with different keywords.', 'ct_theme' ); ?></p>


<?php else : ?>

    <p class="sticky"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ct_theme' ); ?></p>


<?php endif; ?>