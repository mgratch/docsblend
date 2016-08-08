<?php
$prev = get_previous_post();
$next = get_next_post();

?>


<?php if (ct_get_context_option("posts_single_show_pagination", 1) && ($prev || $next)): ?>
    <div class="row">
        <div class="col-xs-12 text-center">
            <ul class="pagination ct-pagination">

                <?php if ($prev): ?>
                    <li class="right">

                    <a href="<?php echo get_permalink(get_adjacent_post(false, '', true)) ?>">

                            <i class="fa fa-chevron-left"></i></a>
                    </li>
                <?php else: ?>


                    <li class="left disabled">
                        <a >
                            <i class="fa fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>



                <?php if ($next): ?>
                    <li class="right">
                        <a href=" <?php echo get_permalink(get_adjacent_post(false, '', false)) ?>">
                            <i class="fa fa-chevron-right"></i></a>
                    </li>

                <?php else: ?>
                    <li class="left disabled">
                        <a >
                            <i class="fa fa-chevron-right"></i></a></li>
                <?php endif; ?>
            </ul>
            <div class="clearfix visible-sm visible-xs"></div>
        </div>
    </div>
<?php endif; ?>