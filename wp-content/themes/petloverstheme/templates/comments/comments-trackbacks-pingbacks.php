<?php if (pings_open()): ?>
    <?php
    global $post;
    $pingbacksCount = count(get_comments(array('type' => 'pingback', 'post_id' => $post->ID)));
    $trackbacksCount = count(get_comments(array('type' => 'trackback', 'post_id' => $post->ID)));
    ?>
    <?php if ($pingbacksCount > 0): ?>
        <header class="page-header text-center">
            <h1 class="page-title"><?php echo __('Pingbacks', 'ct_theme') ?></h1>
        </header>
        <ul class="commentList list-unstyled">
            <?php wp_list_comments(array('callback' => 'theme_comments', 'style' => 'ol', 'type' => 'pingback')); ?>
        </ul>
    <?php endif; ?>

    <?php if ($trackbacksCount > 0): ?>
        <header class="page-header text-center">
            <h1 class="page-title"><?php echo __('Trackbacks', 'ct_theme') ?></h1>
        </header>
        <ul class="commentList list-unstyled">
            <?php wp_list_comments(array('callback' => 'theme_comments', 'style' => 'ol', 'type' => 'trackback')); ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>