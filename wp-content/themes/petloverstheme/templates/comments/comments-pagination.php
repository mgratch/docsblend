<div class="ct-u-marginTop20 ct-u-marginBottom50">
    <ul class="pagination pagination-lg">
        <?php
        global $post;
        $commentsCount = count(get_comments(array('type' => 'comment', 'post_id' => $post->ID)));
        $Newcomments = str_replace('<a', '<li><a ', paginate_comments_links(array('echo' => false, 'prev_next' => false)));
        $Newcomments = str_replace('</a>', '</a></li>', $Newcomments);
        $Newcomments = str_replace('<span class=\'page-numbers current\'>', '<li class="active"><a>', $Newcomments);
        $Newcomments = str_replace('</span>', '</a></li>', $Newcomments);

        _e($Newcomments);//no escape required

        ?>
    </ul>
    <?php global $cpage;

    if (get_comment_pages_count() >1 && $commentsCount > 1):?>
        <span class="ct-pagination-notice text-uppercase">
                <?php if (!$cpage): ?>
                    <?php $cpage = get_comment_pages_count(); ?>
                <?php endif ?>
                <?php echo __('Page', 'ct_theme') . ' ' . ($cpage) . ' ' . __('of', 'ct_theme') . ' ' . get_comment_pages_count(); ?>
            </span>
    <?php endif ?>
</div>