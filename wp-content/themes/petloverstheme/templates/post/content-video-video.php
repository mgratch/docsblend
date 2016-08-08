<?php if (ct_get_context_option("posts_index_show_image", 1)): ?>
    <!-- Media -->

    <?php global $post;?>
    <?php
    $meta = array('videoCode','videoM4V', 'videoOGV', 'videoDirect');
    foreach($meta as $singleMeta){

        if ( get_post_meta($post->ID,$singleMeta,true) != '' ) {
            $display = true;
            break;
        }
    }
    ?>

    <?php if(isset($display)) : ?>

        <div class="ct-mediaSection-video embed-responsive embed-responsive-16by9">
                <?php
                $embed = get_post_meta($post->ID, 'videoCode', true);
                if (!empty($embed)) {
                    echo(stripslashes(htmlspecialchars_decode($embed)));
                } else {
                    echo ct_post_video($post->ID, 750, 475);
                }
                ?>
            </div>
    <?php endif;?>
<?php endif ?>