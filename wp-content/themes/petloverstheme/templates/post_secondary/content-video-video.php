<?php if (ct_get_context_option("posts_index_show_image", 1)): ?>
    <!-- Media -->
    <div class="ct-articleBox-media">
        <div class="embed-responsive embed-responsive-16by9">
            <?php
            $embed = get_post_meta($post->ID, 'videoCode', true);
            if (!empty($embed)) {
                echo(stripslashes(htmlspecialchars_decode($embed)));
            } else {
                echo ct_post_video($post->ID, 750, 475);
            }
            ?>
        </div>
    </div>
<?php endif ?>