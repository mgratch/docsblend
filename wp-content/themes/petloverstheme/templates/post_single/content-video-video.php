<?php if (ct_get_context_option("posts_single_show_image", 1)): ?>


    <?php
    $meta = array('videoCode','videoM4V', 'videoOGV', 'videoDirect');
    foreach($meta as $singleMeta){
        if(get_post_meta($post->ID,$singleMeta,true) != '') {
            $display = true;
            break;
        }
    }
    ?>
    <?php if(isset($display)) : ?>

    <div class="embed-responsive embed-responsive-16by9">
        <?php $embed = get_post_meta($post->ID, 'videoCode', true) ?>
        <?php
        if (!empty($embed)):
            echo stripslashes(htmlspecialchars_decode($embed));//no escape required
        else:
            echo ct_post_video($post->ID, 688, 387);
        endif
        ?>
    </div>
        <?php endif;?>
<?php endif ?>